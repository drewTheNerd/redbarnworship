<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Carbon\Carbon;
use App\Services\PageViewService;

// ==== ROUTE TRACKING =====

Route::get('/', function () {
    return Inertia::render('Evangelism');
})->middleware('page.track:homeEvangelism')->name('homeEvangelism');


// Route::get('/', function () {
//     $visits = PageViewService::track('homeNormalWithLinks');
//     return Inertia::render('HomeNormalWithLinks');
// })->name('homeNormalWithLinks');


// album launch
Route::get('/album', function () {
    return Inertia::render('Album');
})->middleware('page.track:album')->name('album');


// about
Route::get('/about', function () {
    return redirect('/');
})->name('about');


// evangelism
// Route::get('/evangelism', function () {
//     return Inertia::render('Evangelism');
// })->name('evangelism');


// evangelism
Route::get('/greek', function () {
    return Inertia::render('Greek');
})->name('greek');



// // admin stats
// Route::get('/stats', function () {
//     if (request('pw') !== env('STATS_PW', 'jesus')) {
//         abort(403, 'Unauthorized');
//     }
//     return response()->json(PageViewService::all(), 200, [], JSON_PRETTY_PRINT);
// });

Route::get('/stats', function () {
    if (request('pw') !== env('STATS_PW', 'jesus')) {
        abort(403, 'Unauthorized');
    }

    $stats = PageViewService::all();

    $computed = collect($stats)
        ->map(function ($data, $routeName) {
            $days = $data['by_day'] ?? [];
            $fbclidSum = 0;
            $otherSum = 0;

            // If there are previous counts, add them as a "virtual first day"
            $previousCount = (int)($data['_previous'] ?? 0);
            if ($previousCount > 0) {
                $days = array_merge(
                    ['previous' => ['fbclid' => 0, 'other' => $previousCount]],
                    $days
                );
            }

            // Calculate sums
            foreach ($days as $day) {
                if (is_int($day)) {
                    $otherSum += $day;
                } else {
                    $fbclidSum += $day['fbclid'] ?? 0;
                    $otherSum += $day['other'] ?? 0;
                }
            }

            $totalDays = max(count($days), 1); // avoid div by zero
            $avgFbclid = round($fbclidSum / $totalDays, 2);
            $avgOther = round($otherSum / $totalDays, 2);
            $avgTotal = round(($fbclidSum + $otherSum) / $totalDays, 2);

            return [
                'route' => $routeName,
                'total_all_time' => $data['total_all_time'] ?? 0,
                'avg_fbclid' => $avgFbclid,
                'avg_other' => $avgOther,
                'avg_total' => $avgTotal,
                'fbclid_sum' => $fbclidSum,
                'other_sum' => $otherSum,
                'days_count' => $totalDays,
                'by_day' => $days,
            ];
        })
        ->sortByDesc('total_all_time')
        ->values();

    return Inertia::render('Stats', [
        'stats' => $computed,
    ]);
});




// anything else
Route::any('{any}', function () {
    return redirect('/');
})->where('any', '.*')->name('any');



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








