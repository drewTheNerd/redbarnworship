<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Carbon\Carbon;

// define the cutoff timestamp
$cutoff = Carbon::create(2025, 8, 16, 13, 49, 0, 'America/Chicago'); // 1:46pm Central

if (Carbon::now('America/Chicago')->lt($cutoff)) {
    // BEFORE cutoff → everything goes to Linktree
    Route::get('/', function () {
        return Inertia::render('Linktree');
    })->name('home');

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