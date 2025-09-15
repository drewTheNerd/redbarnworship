<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Carbon\Carbon;
use App\Services\PageViewService;

// ==== ROUTE TRACKING =====

Route::get('/', function () {
    $visits = PageViewService::track('homeNormalWithLinks');
    return Inertia::render('HomeNormalWithLinks');
})->name('homeNormalWithLinks');


// album launch
Route::get('/album', function () {
    $visits = PageViewService::track('album');
    return Inertia::render('Album');
})->name('album');


// about
Route::get('/about', function () {
    return redirect('/');
})->name('about');



// admin stats
Route::get('/stats', function () {
    if (request('pw') !== env('STATS_PW', 'jesus')) {
        abort(403, 'Unauthorized');
    }
    return response()->json(PageViewService::all(), 200, [], JSON_PRETTY_PRINT);
});





// anything else
Route::any('{any}', function () {
    return redirect('/');
})->where('any', '.*')->name('homeNormalWithLinks');



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








