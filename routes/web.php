<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Models\Vendor;

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

Route::middleware(['guest'])->group(function () {
    //login
    Route::get('/login', [LoginController::class, 'index'])->name('login'); //done
    Route::post('/login-process', [LoginController::class, 'login_process'])->name('login-process'); //done
    //register
    Route::get('/register', [LoginController::class, 'register'])->name('register'); //done
    Route::post('/register-process', [LoginController::class, 'register_process'])->name('register-process'); //done

    Route::post('/newvendors', [VendorController::class, 'store'])->name('createVendors');
    Route::get('/newvendors', function () {
        return view('vendors.create');
    })->name('newvendors');
});

Route::middleware(['auth'])->group(function () {
    //logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout'); //done
    //User
    Route::get('/admin', [AdminController::class, 'admin'])->middleware('userAccess:admin')->name('admin'); //done
    Route::get('/vendor', [VendorController::class, 'vendor'])->middleware('userAccess:vendor')->name('vendor'); //done
    Route::get('/home', [UserController::class, 'customer'])->middleware('userAccess:customer'); //done

    Route::get('/vendors', [AdminController::class, 'getVendors'])->name('getVendors'); //belom (gatau mau dipake apa engga)
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    //Admin CRUD Manajemen Vendor
    Route::get('/admin/vendor-management', [AdminController::class, 'indexVendorManagement'])->name('admin.vendor-management'); //done
    Route::post('/admin/vendor-management/ban', [AdminController::class, 'banVendor'])->name('admin.vendor-management.ban'); //done
    Route::post('/admin/vendor-management/unban', [AdminController::class, 'unbanVendor'])->name('admin.vendor-management.unban'); //done
    
    //Admin CRUD Response Pengaduan User
    Route::get('/admin/response-user', [AdminController::class, 'indexResponseUser'])->name('admin.response-user'); //done
    
    //Admin CRUD Response Pengaduan Vendor
    Route::get('/admin/response-vendor', [AdminController::class, 'indexResponseVendor'])->name('admin.response-vendor'); //done
});

Route::middleware(['auth', 'role:vendor'])->group(function () {
    //Vendor CRUD lapangan
    Route::get('/vendor/lapangans', [VendorController::class, 'indexLapangan'])->name('vendor.lapangans'); //done
    Route::get('/vendor/lapangans/create', [VendorController::class, 'createLapangan'])->name('lapangans.create'); //done
    Route::post('/vendor/lapangans', [VendorController::class, 'storeLapangan'])->name('lapangans.store'); //done
    Route::get('/lapangans/{id}/edit', [VendorController::class, 'editLapangan'])->name('lapangans.edit'); //done
    Route::delete('/lapangans/{id}', [VendorController::class, 'destroyLapangan'])->name('lapangans.destroy'); //done
    Route::put('/lapangans/{id}', [VendorController::class, 'updateLapangan'])->name('lapangans.update'); //done

    //Vendor CRUD Jadwal
    Route::get('/vendor/schedules', [VendorController::class, 'indexSchedule'])->name('schedules.index'); //done
    Route::get('/vendor/schedules/create', [VendorController::class, 'createSchedule'])->name('schedules.create'); //done
    Route::post('/vendor/schedules', [VendorController::class, 'storeSchedule'])->name('schedules.store'); //done
    Route::get('/schedules/{schedule}/edit', [VendorController::class, 'editSchedule'])->name('schedules.edit'); //done
    Route::put('/schedules/{schedule}', [VendorController::class, 'updateSchedule'])->name('schedules.update'); //done
    Route::delete('/schedules/{schedule}', [VendorController::class, 'destroySchedule'])->name('schedules.destroy'); //done

    //Vendor CRUD Metode Pembayaran
    Route::get('/vendor/payment_methods', [VendorController::class, 'indexPaymentMethod'])->name('payment_methods.index'); //done
    Route::get('/vendor/payment_methods/create', [VendorController::class, 'createPaymentMethod'])->name('payment_methods.create'); //belom
    Route::post('/vendor/payment_methods', [VendorController::class, 'storePaymentMethod'])->name('payment_methods.store'); //belom
    Route::get('/payment_methods/{payment_method}/edit', [VendorController::class, 'editPaymentMethod'])->name('payment_methods.edit'); //belom
    Route::put('/payment_methods/{payment_method}', [VendorController::class, 'updatePaymentMethod'])->name('payment_methods.update'); //belom
    Route::delete('/payment_methods/{payment_method}', [VendorController::class, 'destroyPaymentMethod'])->name('payment_methods.destroy'); //belom

    //Vendor CRUD Interaksi dengan User
    Route::get('/vendor/vendor_interactions', [VendorController::class, 'indexVendorInteraction'])->name('vendor_interactions.index');

    //Vendor Read Laporan dan Statistik Keuangan
    Route::get('/vendor/finance-reports', [VendorController::class, 'indexPendapatan'])->name('finance_reports.index'); //belom (nunggu tabel pembayaran user)
});

Route::middleware(['guest'])->group(function(){
    Route::get('/login',[LoginController::class,'index'])->name('login');
    Route::post('/login-process',[LoginController::class,'login_process'])->name('login-process');

    Route::get('/register',[LoginController::class,'register'])->name('register');
    Route::post('/register-process',[LoginController::class,'register_process'])->name('register-process');
});

