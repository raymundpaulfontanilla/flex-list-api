<?php

use App\Http\Controllers\AuthenticationControlller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthenticationControlller::class, 'register']);
Route::post('/login', [AuthenticationControlller::class, 'login']);
