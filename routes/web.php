<?php

use App\Http\Controllers\ScreeningController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('screenings', ScreeningController::class);
