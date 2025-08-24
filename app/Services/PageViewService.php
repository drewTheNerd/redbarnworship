<?php

namespace App\Services;

class PageViewService
{
	// Increment and return the count for a key.
	public static function track(string $key, ?string $filePath = null): int
	{
		$filePath = $filePath ?: storage_path('app/stats.json');

		$dir = dirname($filePath);
		if (!is_dir($dir)) {
			mkdir($dir, 0775, true);
		}

		$fp = fopen($filePath, 'c+');
		if (!$fp) {
			return 0;
		}

		flock($fp, LOCK_EX);

		rewind($fp);
		$raw = stream_get_contents($fp) ?: '';
		$stats = json_decode($raw, true);
		if (!is_array($stats)) {
			$stats = [];
		}

		$stats[$key] = ($stats[$key] ?? 0) + 1;

		rewind($fp);
		ftruncate($fp, 0);
		fwrite($fp, json_encode($stats, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
		fflush($fp);

		flock($fp, LOCK_UN);
		fclose($fp);

		return (int) $stats[$key];
	}

	// Read without incrementing.
	public static function get(string $key, ?string $filePath = null): int
	{
		$filePath = $filePath ?: storage_path('app/stats.json');
		if (!file_exists($filePath)) return 0;

		$data = json_decode(file_get_contents($filePath), true);
		return is_array($data) ? (int) ($data[$key] ?? 0) : 0;
	}

	// Get all stats.
	public static function all(?string $filePath = null): array
	{
		$filePath = $filePath ?: storage_path('app/stats.json');
		if (!file_exists($filePath)) return [];

		$data = json_decode(file_get_contents($filePath), true);
		return is_array($data) ? $data : [];
	}
}
