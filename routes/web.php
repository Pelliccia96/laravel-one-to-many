<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); */

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard');
});

Route::resource('projects', ProjectController::class);

/* Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ProjectController::class, 'index'])->name('dashboard');
    Route::get('/create', [ProjectController::class, 'create'])->name('create');
    Route::get('/show/{project}', [ProjectController::class, 'show'])->name('show');
    Route::post('/store', [ProjectController::class, 'store'])->name('store');
    Route::get('/edit/{project}', [ProjectController::class, 'edit'])->name('edit');
    Route::put('/admin/{project}', [ProjectController::class, 'update'])->name('update');
    Route::delete("/{project}", [ProjectController::class, "destroy"])->name("destroy");
}); */

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
