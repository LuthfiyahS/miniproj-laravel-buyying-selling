<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
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

Route::get('/login', [AuthenticateController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthenticateController::class, 'auth']);
Route::get('/logout', [AuthenticateController::class, 'logout'])->name('logout');

//Route::group(['middleware' => ['auth', 'role:1']], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('dashboard');
        });
    
        Route::resource('/profile', ProfileController::class);

        Route::resource('/users', UserController::class);
        
        Route::resource('/inventories', InventoryController::class);
        
        Route::get('/sales-invoice/{id}', [SalesController::class,'print']);
        Route::get('/sales-laporan/{start}/{end}', [SalesController::class,'printtgl']);
        Route::get('/sales-export/excel', [SalesController::class,'export'])->name('export.excelSales');
        Route::resource('/sales', SalesController::class);
        

        Route::get('/purchase-invoice/{id}', [PurchaseController::class,'print']);
        Route::get('/purchase-laporan/{start}/{end}', [PurchaseController::class,'printtgl']);
        Route::get('/purchase-export/excel', [PurchaseController::class,'export'])->name('export.excelPurchase');
        Route::resource('/purchase', PurchaseController::class);

        Route::get('/users-pdf', [UserController::class,'pdf'])->name('pdf.User');
        Route::get('/inventories-pdf', [InventoryController::class,'pdf'])->name('pdf.Inventory');

        Route::get('/users-export/excel', [UserController::class,'export'])->name('export.excelUser');
        Route::get('/inventories-export/excel', [InventoryController::class,'export'])->name('export.excelInventory');
    
    });
