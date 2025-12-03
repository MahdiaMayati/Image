<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PhotosController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('photos', PhotosController::class);

