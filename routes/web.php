<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecentController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SharedController;
use App\Http\Controllers\StarredController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\TrashController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'webLogin']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'webRegister']);
Route::post('/logout', [AuthController::class, 'webLogout'])->name('logout');

Route::get('/storage', [StorageController::class, 'index'])->name('storage.index');
Route::get('/storage/{folder}', [StorageController::class, 'folder'])
    ->where('folder', '[^/]+')
    ->name('storage.folder');

Route::get('/shared', [SharedController::class, 'index'])->name('shared.index');
Route::get('/recent', [RecentController::class, 'index'])->name('recent.index');
Route::get('/starred', [StarredController::class, 'index'])->name('starred.index');
Route::get('/archive', [ArchiveController::class, 'index'])->name('archive.index');
Route::get('/trash', [TrashController::class, 'index'])->name('trash.index');
Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

// Error pages, also directly accessible for review/QA.
foreach (['403', '404', '500'] as $code) {
    Route::get('/errors/'.$code, fn () => response()->view('errors.'.$code, [], (int) $code))
        ->name('errors.'.$code);
}
