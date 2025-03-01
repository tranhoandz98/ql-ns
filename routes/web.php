<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimekeepingController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';
Route::get('/', function () {
    return view('welcome');
});

Route::get('/trang-chu', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
    });

    Route::prefix('cham-cong')->group(function () {
        Route::get('/', [TimekeepingController::class, 'index'])->name('cham-cong.index');
        Route::get('/add-me', [TimekeepingController::class, 'addMe'])->name('cham-cong.add-me');
        Route::post('/add-me', [TimekeepingController::class, 'postAddMe'])->name('cham-cong.post-add-me');

        Route::post('/checkin', [TimekeepingController::class, 'checkin'])->name('cham-cong.checkin');
        Route::get('/create', function () {
            return view('cham-cong.create');
        })->name('cham-cong.create');

        Route::get('/edit/{id}', function ($id) {
            return view('cham-cong.edit', compact('id'));
        })->name('cham-cong.edit');
    });
});
