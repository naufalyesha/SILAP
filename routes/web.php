<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VendorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['guest'])->group(function(){
    Route::get('/login',[LoginController::class,'index'])->name('login');
    Route::post('/login-process',[LoginController::class,'login_process'])->name('login-process');

    Route::get('/register',[LoginController::class,'register'])->name('register');
    Route::post('/register-process',[LoginController::class,'register_process'])->name('register-process');
});

Route::get('/home', function(){
    return redirect('/admin');
});

Route::middleware(['auth'])->group(function(){
    Route::get('/logout',[LoginController::class,'logout'])->name('logout');
    Route::get('/admin',[AdminController::class,'index'])->name('admin');
    Route::get('/admin/admin1',[AdminController::class,'admin1'])->middleware('userAccess:admin');
    Route::get('/admin/vendor',[AdminController::class,'vendor'])->middleware('userAccess:vendor');
    Route::get('/admin/customer',[AdminController::class,'customer'])->middleware('userAccess:customer');
    Route::post('/vendors', [VendorController::class, 'store'])->name('createVendors');
    Route::get('/admin/newvendors', function () {
        return view('vendors.create');
    });
});

