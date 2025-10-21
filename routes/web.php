<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\Auth\DemoLoginController;

Route::get('/', [WeatherController::class, 'index'])->name('home');
Route::get('/dashboard', [WeatherController::class, 'index'])->middleware('auth')->name('dashboard');

Route::get('/ranking', [RankingController::class, 'index'])->name('ranking');
Route::post('/ranking/update', [RankingController::class, 'update'])->name('ranking.update');

// デモログイン機能
Route::get('/demo-login', [DemoLoginController::class, 'login'])->name('demo.login');

require __DIR__ . '/auth.php';
