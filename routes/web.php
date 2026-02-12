<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\BorrowingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\ToolController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Peminjam\PeminjamController;
use App\Http\Controllers\Petugas\PetugasController;
use App\Http\Controllers\Petugas\ReportController;
use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login.show')
    ->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login')
    ->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register.show')
    ->middleware('guest');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register')
    ->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');



// Route Admin

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'admin'])
        ->name('admin.dashboard');

    Route::resource('/users', UserController::class)->names('admin.users');


    Route::resource('/categories', CategoryController::class)
        ->except(['show'])->names('admin.categories');


    Route::resource('/tools', ToolController::class)
        ->except(['show'])->names('admin.tools');


    Route::resource('/borrowings', BorrowingController::class)
        ->names('admin.borrowings');


    Route::resource('/return-tools', ReturnController::class)
        ->names('admin.return-tools')->except('create', 'show', 'store');

    Route::get('/return-tools/{borrowing}', [ReturnController::class, 'create'])
        ->name('admin.return-tools.create');

    Route::post('/return-tools/{borrowing}', [ReturnController::class, 'store'])
        ->name('admin.return-tools.store');



    Route::resource('/activity-logs', ActivityLogController::class)
        ->only(['index'])
        ->names('admin.activity-logs');


    Route::patch(
        '/borrowings/{borrowing}/approve',
        [BorrowingController::class, 'approve']
    )->name('admin.borrowings.approve');

    Route::get('/reports', [ReportController::class, 'index'])
        ->name('admin.reports');

    Route::get('/activities', [ActivityLogController::class, 'index'])
        ->name('activities.index');
});



// Route Petugas

Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'petugas'])
        ->name('petugas.dashboard');


    Route::get('/borrowings', [PetugasController::class, 'index'])
        ->name('petugas.borrowings.index');

    Route::get('/return-tools/{borrowing}', [PetugasController::class, 'returnTool'])
        ->name('petugas.return-tools.create');

    Route::post('/return-tools/{borrowing}', [PetugasController::class, 'storeReturnTool'])
        ->name('petugas.return-tools.store');

    Route::patch('/borrowings/{borrowing}/approve', [PetugasController::class, 'approve'])
        ->name('petugas.borrowings.approve');

    Route::get('/reports', [ReportController::class, 'index'])
        ->name('petugas.reports');
});


//Route Peminjam

Route::middleware(['auth', 'role:peminjam'])->prefix('peminjam')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'peminjam'])->name('peminjam.dashboard');

    Route::get('/tools', [PeminjamController::class, 'Tool'])
        ->name('peminjam.tools');

    Route::get('/borrowings', [PeminjamController::class, 'Borrowing'])
        ->name('peminjam.borrowings.index');

    Route::get('/borrowings/create', [PeminjamController::class, 'CreateBorrowing'])
        ->name('peminjam.borrowings.create');

    Route::post('/borrowings', [PeminjamController::class, 'StoreBorrowing'])
        ->name('peminjam.borrowings.store');

    Route::get('/return-tools', [PeminjamController::class, 'returnTool'])
        ->name('peminjam.return-tools.index');

    Route::post('/return-tools/{borrowing}', [PeminjamController::class, 'storeReturnTool'])
        ->name('peminjam.return-tools.store');
});
