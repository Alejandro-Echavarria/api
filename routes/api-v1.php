<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;

Route::post('register', [RegisterController::class, 'store'])->name('api.v1.register');
