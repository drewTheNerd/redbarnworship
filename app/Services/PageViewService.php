<?php

namespace App\Services;

use Carbon\Carbon;

class PageViewService
{
	/** Timezone for bucketing days */
	private const TZ = 'America/Chicago';

	private static function path(?string $filePath): string
	{
		return $filePath ?: storage_path('app/stats.json');
	}

	/** Ensure array structure for a key: ['_previous' => int, 'by_day' => []] */
	private static function ensureKeyStructure(array &$stats, string $key): void
	{
		if (!array_key_exists($key, $stats)) {
			$stats[$key] = ['_previous' => 0, 'by_day' => []];
			return;
		}

		if (is_int($stats[$key])) {
			$stats[$key] = ['_previous' => $stats[$key], 'by_day' => []];
			return;
		}

		if (is_array($stats[$key])) {
			if (!array_key_exists('_previous', $stats[$key]) || !is_int($stats[$key]['_previous'])) {
				$stats[$key]['_previous'] = 0;
			}
			if (!array_key_exists('by_day', $stats[$key]) || !is_array($stats[$key]['by_day'])) {
				$stats[$key]['by_day'] = [];
			}
			return;
		}

		$stats[$key] = ['_previous' => 0, 'by_day' => []];
	}

	private static function computeTotalForKey(array $keyData): int
	{
		$total = (int)($keyData['_previous'] ?? 0);
		if (!empty($keyData['by_day']) && is_array($keyData['by_day'])) {
			foreach ($keyData['by_day'] as $count) {
				$total += (int)$count;
			}
		}
		return $total;
	}

	private static function sumByDay(array $keyData): int
	{
		$sum = 0;
		if (!empty($keyData['by_day']) && is_array($keyData['by_day'])) {
			foreach ($keyData['by_day'] as $count) {
				$sum += (int)$count;
			}
		}
		return $sum;
	}

	private static function todayYmd(): string
	{
		return Carbon::now(self::TZ)->format('Y-m-d');
	}

	/** Safely load the JSON file with locking; returns [data, fp] or [[], null] */
	private static function load(string $filePath): array
	{
		if (!is_dir(dirname($filePath))) {
			mkdir(dirname($filePath), 0775, true);
		}

		$fp = fopen($filePath, 'c+');
		if (!$fp) {
			return [[], null];
		}

		flock($fp, LOCK_EX);
		rewind($fp);
		$raw = stream_get_contents($fp) ?: '';
		$data = json_decode($raw, true);
		if (!is_array($data)) {
			$data = [];
		}

		return [$data, $fp];
	}

	private static function saveAndClose($fp, array $data): void
	{
		rewind($fp);
		ftruncate($fp, 0);
		fwrite($fp, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
		fflush($fp);
		flock($fp, LOCK_UN);
		fclose($fp);
	}

	// Increment and return the count for a key (total all-time).
	public static function track(string $key, ?string $filePath = null): int
	{
		$filePath = self::path($filePath);
		[$stats, $fp] = self::load($filePath);

		if ($fp === null) {
			return 0;
		}

		self::ensureKeyStructure($stats, $key);

		$today = self::todayYmd();
		$byDay =& $stats[$key]['by_day'];
		$byDay[$today] = (int)($byDay[$today] ?? 0) + 1;

		$total = self::computeTotalForKey($stats[$key]);

		self::saveAndClose($fp, $stats);

		return $total;
	}

	// Read total (all-time) without incrementing.
	public static function get(string $key, ?string $filePath = null): int
	{
		$filePath = self::path($filePath);
		if (!file_exists($filePath)) {
			return 0;
		}
		$data = json_decode(file_get_contents($filePath), true);
		if (!is_array($data) || !array_key_exists($key, $data)) {
			return 0;
		}

		if (is_int($data[$key])) {
			return (int)$data[$key];
		}

		if (is_array($data[$key])) {
			return self::computeTotalForKey($data[$key]);
		}

		return 0;
	}

	// Get today's count (Central time) without incrementing.
	public static function getToday(string $key, ?string $filePath = null): int
	{
		$filePath = self::path($filePath);
		if (!file_exists($filePath)) return 0;

		$data = json_decode(file_get_contents($filePath), true);
		if (!is_array($data) || !array_key_exists($key, $data)) return 0;

		if (is_int($data[$key])) return 0;

		$today = self::todayYmd();
		return (int)($data[$key]['by_day'][$today] ?? 0);
	}

	// Get the count for a specific YYYY-MM-DD day for a key without incrementing.
	public static function getByDay(string $key, string $ymd, ?string $filePath = null): int
	{
		$filePath = self::path($filePath);
		if (!file_exists($filePath)) return 0;

		$data = json_decode(file_get_contents($filePath), true);
		if (!is_array($data) || !array_key_exists($key, $data)) return 0;

		if (is_int($data[$key])) return 0;

		return (int)($data[$key]['by_day'][$ymd] ?? 0);
	}

	/**
	 * Get all stats, enriched with:
	 * - total_all_time
	 * - average_per_day (sum(by_day) / count(days), 2 decimals)
	 * Also migrates legacy integers to structured form and writes back.
	 */
	public static function all(?string $filePath = null): array
	{
		$filePath = self::path($filePath);
		[$stats, $fp] = self::load($filePath);

		if ($fp === null) {
			return [];
		}

		$migrated = false;

		foreach ($stats as $key => $value) {
			$before = $stats[$key] ?? null;

			self::ensureKeyStructure($stats, $key);

			// If ensureKeyStructure changed the type, consider it a migration
			if ($before !== $stats[$key]) {
				$migrated = true;
			}

			// Compute totals
			$totalByDay = self::sumByDay($stats[$key]);
			$totalAll   = (int)($stats[$key]['_previous'] ?? 0) + $totalByDay;

			$daysCount  = (!empty($stats[$key]['by_day']) && is_array($stats[$key]['by_day']))
				? count($stats[$key]['by_day'])
				: 0;

			$avgPerDay  = $daysCount > 0 ? round($totalByDay / $daysCount, 2) : 0.0;

			$stats[$key]['total_all_time'] = $totalAll;
			$stats[$key]['average_per_day'] = $avgPerDay;
		}

		// Persist migration (if any), plus the computed fields so /stats can read directly
		self::saveAndClose($fp, $stats);

		return $stats;
	}

	/** Raw file contents (no enrichment/migration); use only if you really need the original file state. */
	public static function rawAll(?string $filePath = null): array
	{
		$filePath = self::path($filePath);
		if (!file_exists($filePath)) return [];

		$data = json_decode(file_get_contents($filePath), true);
		return is_array($data) ? $data : [];
	}
}
