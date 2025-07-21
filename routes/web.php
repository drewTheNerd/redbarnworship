<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('AlbumLaunchHomepage');
})->name('home');


Route::get('/album', function () {
    return Inertia::render('AlbumLaunchHomepage');
})->name('album');



// fallback route for any other page. if a user attempts to load anything else besides the routes defined above, we'll fallback to redirecting to the homepage. this MUST be the last route in this file
Route::fallback(function () {
    return redirect('/');
});