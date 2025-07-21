<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('AlbumLaunchHomepage');
})->name('home');


Route::get('/album', function () {
    return Inertia::render('AlbumLaunchHomepage');
})->name('album');

