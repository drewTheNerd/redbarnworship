<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Carbon\Carbon;



Route::get('/', function () {
    $visits = trackPageView('homeButItsAlbum');
    return Inertia::render('Album');
})->name('homeButItsAlbum');

// /about works normally
Route::get('/about', function () {
    $visits = trackPageView('about');
    return Inertia::render('About');
})->name('about');




// admin stats
Route::get('/stats', function () {
    // Check password from query param
    if (request('pw') !== 'jesus') {
        abort(403, 'Unauthorized');
    }

    $filePath = storage_path('app/stats.json');

    if (!file_exists($filePath)) {
        // Return empty JSON if no stats file exists yet
        return response()->json([], 200, [], JSON_PRETTY_PRINT);
    }

    $contents = file_get_contents($filePath);
    // If you want to return as plain text:
    // return response($contents, 200)->header('Content-Type', 'text/plain');

    // Or as proper JSON with pretty print:
    return response($contents, 200)
        ->header('Content-Type', 'application/json');
});





// anything else
Route::any('{any}', function () {
    return redirect('/');
})->where('any', '.*')->name('album');



// ===== TIMESTAMP BASED PAGE VISIBILTY ======

/*
// define the cutoff timestamp
$cutoff = Carbon::create(2025, 8, 22, 19, 0, 0, 'America/Chicago'); // 7pm central on Aug 22nd 2025

if (Carbon::now('America/Chicago')->lt($cutoff)) {
    // BEFORE cutoff → everything goes to Linktree
    Route::get('/', function () {
        return Inertia::render('Linktree');
    })->name('home');

    // /about works normally
    Route::get('/about', function () {
        return Inertia::render('About');
    })->name('about_normal');

    // /album works normally
    Route::get('/album', function () {
        return Inertia::render('Album');
    })->name('album_normal');

    Route::any('{any}', function () {
        return redirect('/');
    })->where('any', '.*')->name('home');
} else {
    // AFTER cutoff
    Route::get('/', function () {
        return Inertia::render('Album');
    })->name('homeButItsAlbum');

    // /about works normally
    Route::get('/about', function () {
        return Inertia::render('About');
    })->name('about');


    // anything else
    Route::any('{any}', function () {
        return redirect('/');
    })->where('any', '.*')->name('album');
}


*/




// Route::get('/', function () {
//     return Inertia::render('Linktree');
// })->name('home');


// Route::get('/album', function () {
//     return Inertia::render('Album');
// })->name('album');


// Route::get('/about', function () {
//     return Inertia::render('About');
// })->name('about');



// fallback route for any other page. if a user attempts to load anything else besides the routes defined above, we'll fallback to redirecting to the homepage. this MUST be the last route in this file
Route::fallback(function () {
    return redirect('/');
});








// ==== ROUTE TRACKING =====





/**
 * Track a page view by key and return the updated count.
 * Stores counts in storage/app/stats.json as: { "homeButItsAlbum": 123, "about": 45, ... }
 */
if (!function_exists('trackPageView')) {
    function trackPageView(string $key, ?string $filePath = null): int {
        $filePath = $filePath ?: storage_path('app/stats.json');

        // Ensure directory exists
        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        // Open or create file without truncation
        $fp = fopen($filePath, 'c+');
        if (!$fp) {
            // Fallback: try a simple non-locked bump in memory
            return 0;
        }

        // Exclusive lock so concurrent requests don't clobber each other
        flock($fp, LOCK_EX);

        // Read existing JSON
        rewind($fp);
        $raw = stream_get_contents($fp);
        $stats = $raw ? json_decode($raw, true) : [];
        if (!is_array($stats)) {
            $stats = [];
        }

        // Increment the key
        $stats[$key] = ($stats[$key] ?? 0) + 1;

        // Write back pretty JSON atomically
        rewind($fp);
        ftruncate($fp, 0);
        fwrite($fp, json_encode($stats, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        fflush($fp);

        // Unlock/close
        flock($fp, LOCK_UN);
        fclose($fp);

        return $stats[$key];
    }
}

/**
 * Optional helper to read a count without incrementing.
 */
if (!function_exists('getPageViews')) {
    function getPageViews(string $key, ?string $filePath = null): int {
        $filePath = $filePath ?: storage_path('app/stats.json');
        if (!file_exists($filePath)) return 0;
        $data = json_decode(file_get_contents($filePath), true);
        return is_array($data) ? (int) ($data[$key] ?? 0) : 0;
    }
}
