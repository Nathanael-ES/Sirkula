<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;


// home
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();

    return match ($user->role) {
        'admin'    => redirect()->route('dashboard'),
        'relawan'  => redirect()->route('dashboard'),
        'donatur'  => redirect()->route('donations.index'),
        default    => redirect()->route('login'),
    };
})->name('home');


Route::get('register', [RegisterController::class, 'show'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register.perform');

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.perform');

Route::post('logout', [LogoutController::class, 'perform'])->name('logout.perform');

//navbar
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});

//admin
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('categories', CategoryController::class);
        Route::resource('users', UserController::class);
    });


Route::middleware(['auth'])->group(function () {

    Route::resource('items', ItemController::class)->except(['show']);
    Route::resource('recipients', RecipientController::class);

    Route::resource('donations', DonationController::class)
        ->only(['index', 'create', 'store', 'destroy']);

    Route::patch('items/{item}/status/{status}', [ItemController::class, 'updateStatus'])
        ->middleware('role:admin')
        ->name('items.updateStatus');
});

Route::middleware(['auth','role:admin,relawan'])->group(function () {
    Route::resource('distributions', DistributionController::class)
        ->only(['index','create','store','destroy']);
});

Route::get('/locale/{lang}', function ($lang) {
    if (in_array($lang, ['id','en'])) {
        session(['locale' => $lang]);
    }
    return back();
})->name('locale.switch');