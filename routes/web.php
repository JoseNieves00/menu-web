<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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

Route::get('/', [AdminController::class, 'index'])->name('/');
Route::any('/categorias/{category_products}', [AdminController::class, 'getCategoryProducts'])->name('getCategoryProducts');


Route::post('get_products', [AdminController::class, 'getProducts'])->name('get_products');

Route::any('admin', [AdminController::class, 'login'])->name('admin');
Route::get('logout', [AdminController::class, 'logout'])->name('logout');


Route::get('admin/product', [AdminController::class, 'listProducts'])->name('admin/product');
Route::any('admin/product/create', [AdminController::class, 'createProduct'])->name('admin/product/create');

Route::get('admin/category_product', [AdminController::class, 'listCategoryProduct'])->name('admin/category_product');


