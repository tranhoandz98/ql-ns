<?php

use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TimekeepingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PositionController;
use App\Models\Overtimes;
use App\Models\User;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';
Route::get('/', function () {
    return view(view: 'dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');;

Route::get('/trang-chu', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
    });

    Route::post('change-lang', [ConfigController::class, 'changeLang'])->name('change-lang');


    Route::prefix('timekeeping')->name('timekeeping.')->group(function () {
        Route::get('/', [TimekeepingController::class, 'index'])->name('index');
        Route::get('/add-me', [TimekeepingController::class, 'addMe'])->name('add-me');
        Route::post('/add-me', [TimekeepingController::class, 'postAddMe'])->name('post-add-me');
        Route::post('/checkin', [TimekeepingController::class, 'checkin'])->name('checkin');

        Route::get('/create', [TimekeepingController::class, 'create'])->name('create');
        Route::post('/', [TimekeepingController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TimekeepingController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TimekeepingController::class, 'update'])->name('update');
        Route::delete('/{id}', [TimekeepingController::class, 'destroy'])->name('destroy');
    });

    // vai trò
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index')
            ->can('viewAny', App\Models\Roles::class);
        Route::get('/create', [RoleController::class, 'create'])->name('create')
            ->can('create', App\Models\Roles::class);
        Route::post('/', [RoleController::class, 'store'])->name('store')
            ->can('create', App\Models\Roles::class);
        Route::get('/{id}', [RoleController::class, 'show'])->name('show')
            ->can('view', App\Models\Roles::class);
        Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('edit')
            ->can('update', App\Models\Roles::class);
        Route::put('/{id}', [RoleController::class, 'update'])->name('update')
            ->can('update', App\Models\Roles::class);
        Route::delete('/{id}', [RoleController::class, 'destroy'])->name('destroy')
            ->can('delete', App\Models\Roles::class);
    });

    // người dùng
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index')
            ->can('viewAny', User::class);
        Route::get('/create', [UserController::class, 'create'])->name('create')
            ->can('create', User::class)
        ;
        Route::post('/', [UserController::class, 'store'])->name('store')
            ->can('create', User::class)
        ;
        Route::get('/{id}', [UserController::class, 'show'])->name('show')
            ->can('view', User::class)
        ;
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit')
            ->can('update', User::class)

        ;
        Route::put('/{id}', [UserController::class, 'update'])->name('update')
            ->can('update', User::class)

        ;
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy')
            ->can('delete', User::class)
        ;
    });

    // chức vụ
    Route::prefix('positions')->name('positions.')->group(function () {
        Route::get('/', [PositionController::class, 'index'])->name('index')
            ->can('viewAny', App\Models\Position::class);
        Route::get('/create', [PositionController::class, 'create'])->name('create')
            ->can('create', App\Models\Position::class);
        Route::post('/', [PositionController::class, 'store'])->name('store')
            ->can('create', App\Models\Position::class);
        Route::get('/{id}', [PositionController::class, 'show'])->name('show')
            ->can('view', App\Models\Position::class);
        Route::get('/{id}/edit', [PositionController::class, 'edit'])->name('edit')
            ->can('update', App\Models\Position::class);
        Route::put('/{id}', [PositionController::class, 'update'])->name('update')
            ->can('update', App\Models\Position::class);
        Route::delete('/{id}', [PositionController::class, 'destroy'])->name('destroy')
            ->can('delete', App\Models\Position::class);
    });

    // phòng ban
    Route::prefix('departments')->name('departments.')->group(function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('index')
            ->can('viewAny', App\Models\Departments::class);
        Route::get('/create', [DepartmentController::class, 'create'])->name('create')
            ->can('create', App\Models\Departments::class);
        Route::post('/', [DepartmentController::class, 'store'])->name('store')
            ->can('create', App\Models\Departments::class);
        Route::get('/{id}', [DepartmentController::class, 'show'])->name('show')
            ->can('view', App\Models\Departments::class);
        Route::get('/{id}/edit', [DepartmentController::class, 'edit'])->name('edit')
            ->can('update', App\Models\Departments::class);
        Route::put('/{id}', [DepartmentController::class, 'update'])->name('update')
            ->can('update', App\Models\Departments::class);
        Route::delete('/{id}', [DepartmentController::class, 'destroy'])->name('destroy')
            ->can('delete', App\Models\Departments::class);
    });

    // tăng ca
    Route::prefix('overtimes')->name('overtimes.')->group(function () {
        Route::get('/', [OvertimeController::class, 'index'])->name('index')
            ->can('viewAny', Overtimes::class);
        Route::get('/create', [OvertimeController::class, 'create'])->name('create')
            ->can('create', Overtimes::class);
        Route::post('/', [OvertimeController::class, 'store'])->name('store')
            ->can('create', Overtimes::class);
        Route::get('/{id}', [OvertimeController::class, 'show'])->name('show')
            ->can('view', Overtimes::class);
        Route::get('/{id}/edit', [OvertimeController::class, 'edit'])->name('edit')
            ->can('update', Overtimes::class);
        Route::put('/{id}', [OvertimeController::class, 'update'])->name('update')
            ->can('update', Overtimes::class);
        Route::delete('/{id}', [OvertimeController::class, 'destroy'])->name('destroy')
            ->can('delete', Overtimes::class);
        Route::get('/{id}/send', [OvertimeController::class, 'send'])->name('send')
            ->can('send', Overtimes::class);
        Route::get('/{id}/approve', [OvertimeController::class, 'approve'])->name('approve')
            ->can('approve', Overtimes::class);
        Route::get('/{id}/reject', [OvertimeController::class, 'reject'])->name('reject')
            ->can('reject', Overtimes::class);
    });

    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('update-read/{id}', [NotificationController::class, 'updateRead'])->name('updateRead');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::post('/list-limit', [NotificationController::class, 'listLimit'])->name('listLimit');
        Route::post('/read/{id}', [NotificationController::class, 'read'])->name('read');
    });
});
