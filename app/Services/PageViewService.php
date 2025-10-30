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
				if (is_int($count)) {
					$total += $count;
				} elseif (is_array($count)) {
					$total += (int)($count['fbclid'] ?? 0)
						+ (int)($count['qr'] ?? 0)
						+ (int)($count['other'] ?? 0);
				}
			}
		}
		return $total;
	}

	private static function sumByDay(array $keyData): int
	{
		$sum = 0;
		if (!empty($keyData['by_day']) && is_array($keyData['by_day'])) {
			foreach ($keyData['by_day'] as $count) {
				if (is_int($count)) {
					$sum += $count;
				} elseif (is_array($count)) {
					$sum += (int)($count['fbclid'] ?? 0)
						+ (int)($count['qr'] ?? 0)
						+ (int)($count['other'] ?? 0);
				}
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

	// Increment and return total all-time count for a key
	public static function track(string $key, bool $hasFbclid = false, bool $hasQr = false, ?string $filePath = null): int
	{
		$filePath = self::path($filePath);
		[$stats, $fp] = self::load($filePath);

		if ($fp === null) {
			return 0;
		}

		self::ensureKeyStructure($stats, $key);

		$today = self::todayYmd();
		$byDay =& $stats[$key]['by_day'];

		// Backward compatibility: convert int to structured array if needed
		if (!isset($byDay[$today])) {
			$byDay[$today] = ['fbclid' => 0, 'qr' => 0, 'other' => 0];
		} elseif (is_int($byDay[$today])) {
			$old = (int)$byDay[$today];
			$byDay[$today] = ['fbclid' => 0, 'qr' => 0, 'other' => $old];
		} else {
			// Make sure new field exists
			if (!array_key_exists('qr', $byDay[$today])) {
				$byDay[$today]['qr'] = 0;
			}
		}

		if ($hasFbclid) {
			$byDay[$today]['fbclid']++;
		} elseif ($hasQr) {
			$byDay[$today]['qr']++;
		} else {
			$byDay[$today]['other']++;
		}

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

	// Get today's total (fbclid + other)
	public static function getToday(string $key, ?string $filePath = null): int
	{
		$filePath = self::path($filePath);
		if (!file_exists($filePath)) return 0;

		$data = json_decode(file_get_contents($filePath), true);
		if (!is_array($data) || !array_key_exists($key, $data)) return 0;

		$today = self::todayYmd();
		$entry = $data[$key]['by_day'][$today] ?? 0;

		if (is_int($entry)) return (int)$entry;

		return (int)($entry['fbclid'] ?? 0) + (int)($entry['other'] ?? 0);
	}

	// Get fbclid count for a specific day
	public static function getFbclidByDay(string $key, string $ymd, ?string $filePath = null): int
	{
		$filePath = self::path($filePath);
		if (!file_exists($filePath)) return 0;

		$data = json_decode(file_get_contents($filePath), true);
		if (!is_array($data) || !array_key_exists($key, $data)) return 0;

		$entry = $data[$key]['by_day'][$ymd] ?? 0;

		if (is_int($entry)) return 0;

		return (int)($entry['fbclid'] ?? 0);
	}

	// Get total count for a specific day
	public static function getByDay(string $key, string $ymd, ?string $filePath = null): int
	{
		$filePath = self::path($filePath);
		if (!file_exists($filePath)) return 0;

		$data = json_decode(file_get_contents($filePath), true);
		if (!is_array($data) || !array_key_exists($key, $data)) return 0;

		$entry = $data[$key]['by_day'][$ymd] ?? 0;
		if (is_int($entry)) return (int)$entry;

		return (int)($entry['fbclid'] ?? 0) + (int)($entry['other'] ?? 0);
	}

	/**
	 * Get all stats with computed:
	 * - total_all_time
	 * - average_per_day
	 * Also migrates legacy integers to structured arrays.
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

			// Convert legacy int entries to structured array
			foreach ($stats[$key]['by_day'] as $day => $val) {
				if (is_int($val)) {
					$stats[$key]['by_day'][$day] = [
						'fbclid' => 0,
						'other' => (int)$val,
					];
					$migrated = true;
				}
			}

			if ($before !== $stats[$key]) $migrated = true;

			$totalByDay = self::sumByDay($stats[$key]);
			$totalAll   = (int)($stats[$key]['_previous'] ?? 0) + $totalByDay;

			$daysCount  = (!empty($stats[$key]['by_day']) && is_array($stats[$key]['by_day']))
				? count($stats[$key]['by_day'])
				: 0;

			$avgPerDay  = $daysCount > 0 ? round($totalByDay / $daysCount, 2) : 0.0;

			$stats[$key]['total_all_time'] = $totalAll;
			$stats[$key]['average_per_day'] = $avgPerDay;
		}

		if ($migrated) {
			self::saveAndClose($fp, $stats);
		} else {
			flock($fp, LOCK_UN);
			fclose($fp);
		}

		return $stats;
	}

	public static function rawAll(?string $filePath = null): array
	{
		$filePath = self::path($filePath);
		if (!file_exists($filePath)) return [];
		$data = json_decode(file_get_contents($filePath), true);
		return is_array($data) ? $data : [];
	}
}
