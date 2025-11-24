<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MateriController;
use App\Http\Controllers\Admin\LogMateriController;
use App\Http\Controllers\Admin\AddController;
use App\Http\Controllers\Admin\JobsheetController;
use App\Http\Controllers\Admin\LogJobsheetController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('materi', MateriController::class);
    Route::resource('log-materi', LogMateriController::class);
    Route::resource('add', AddController::class);
    Route::resource('user', UserController::class);
    Route::resource('jobsheet', JobsheetController::class);
    Route::resource('log-jobsheet', LogJobsheetController::class);
    Route::resource('quiz', QuizController::class);
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user', fn () => view('user.dashboard'));
});

require __DIR__.'/auth.php';