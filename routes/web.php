<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\TimekeepingController;
use App\Http\Controllers\UsersController;
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

    Route::prefix('cham-cong')->name('cham-cong.')->group(function () {
        Route::get('/', [TimekeepingController::class, 'index'])->name('index');
        Route::get('/add-me', [TimekeepingController::class, 'addMe'])->name('add-me');
        Route::post('/add-me', [TimekeepingController::class, 'postAddMe'])->name('post-add-me');

        Route::post('/checkin', [TimekeepingController::class, 'checkin'])->name('checkin');
        Route::get('/create', function () {
            return view('create');
        })->name('create');

        Route::get('/edit/{id}', function ($id) {
            return view('edit', compact('id'));
        })->name('edit');
    });

    // vai trò
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RolesController::class, 'index'])->name('index');
        Route::get('/create', [RolesController::class, 'create'])->name('create');
        Route::post('/', [RolesController::class, 'store'])->name('store');
        Route::get('/{id}', [RolesController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [RolesController::class, 'edit'])->name('edit');
        Route::put('/{id}', [RolesController::class, 'update'])->name('update');
        Route::delete('/{id}', [RolesController::class, 'destroy'])->name('destroy');
    });

    // người dùng
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('index');
        Route::get('/create', [UsersController::class, 'create'])->name('create');
        Route::post('/', [UsersController::class, 'store'])->name('store');
        Route::get('/{id}', [UsersController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UsersController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UsersController::class, 'update'])->name('update');
        Route::delete('/{id}', [UsersController::class, 'destroy'])->name('destroy');
    });
});
