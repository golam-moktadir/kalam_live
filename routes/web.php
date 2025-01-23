<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('user-info', [App\Http\Controllers\UserController::class, 'index']);
Route::get('user-list', [App\Http\Controllers\UserController::class, 'userList'])->name('user-list');
Route::post('user-add', [App\Http\Controllers\UserController::class, 'addUser']);
Route::post('user-update/{id}', [App\Http\Controllers\UserController::class, 'updateUser']);
Route::get('user-delete/{id}', [App\Http\Controllers\UserController::class, 'userDelete']);

Route::get('lookup-info', [App\Http\Controllers\Admin\LookupController::class, 'index']);
Route::get('lookup-list', [App\Http\Controllers\Admin\LookupController::class, 'lookupList'])->name('lookup-list');
Route::post('lookup-add', [App\Http\Controllers\Admin\LookupController::class, 'addLookup']);
Route::post('lookup-update/{id}', [App\Http\Controllers\Admin\LookupController::class, 'updateLookup']);
Route::get('lookup-delete/{id}', [App\Http\Controllers\Admin\LookupController::class, 'deleteLookup']);

Route::get('product-info', [App\Http\Controllers\Product\ProductController::class, 'index']);
Route::get('product-list', [App\Http\Controllers\Product\ProductController::class, 'productList'])->name('product-list');
Route::post('product-add', [App\Http\Controllers\Product\ProductController::class, 'addProduct']);
Route::post('product-update/{id}', [App\Http\Controllers\Product\ProductController::class, 'updateProduct']);
Route::get('product-delete/{id}', [App\Http\Controllers\Product\ProductController::class, 'productDelete']);
Route::get('supplier-info', [App\Http\Controllers\Supplier\SupplierController::class, 'index']);
Route::get('supplier-new', [App\Http\Controllers\Supplier\SupplierController::class, 'supplierNew']);
Route::post('supplier-add', [App\Http\Controllers\Supplier\SupplierController::class, 'addSupplier']);
Route::get('supplier-edit/{id}', [App\Http\Controllers\Supplier\SupplierController::class, 'supplierEdit']);
Route::post('supplier-update', [App\Http\Controllers\Supplier\SupplierController::class, 'updateSupplier']);
Route::get('supplier-delete/{id}', [App\Http\Controllers\Supplier\SupplierController::class, 'supplierDelete']);

Route::get('product-purchase', [App\Http\Controllers\Purchase\ProductPurchaseController::class, 'index']);
Route::get('product-purchase-new', [App\Http\Controllers\Purchase\ProductPurchaseController::class, 'productPurchaseNew']);
Route::post('product-purchase-add', [App\Http\Controllers\Purchase\ProductPurchaseController::class, 'addProductPurchase']);





