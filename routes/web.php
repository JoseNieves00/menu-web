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
Route::get('/home', [AdminController::class, 'index'])->name('home');

Route::Redirect('/home', '/');

Route::any('/categorias/{category_products}', [AdminController::class, 'getCategoryProducts'])->name('getCategoryProducts');

Route::any('admin', [AdminController::class, 'login'])->name('admin');
Route::get('logout', [AdminController::class, 'logout'])->name('logout');


Route::any('admin/categorys', [AdminController::class, 'listCategorys'])->name('listCategorys');
Route::any('admin/product/{category_product}', [AdminController::class, 'getProducts'])->name('getProducts');
Route::any('admin/{category_product}/edit', [AdminController::class, 'editCategory'])->name('editCategory');
Route::any('admin/product/edit/{id}', [AdminController::class, 'editProduct'])->name('editProduct');
Route::any('admin/product/{category_product}/create', [AdminController::class, 'createProduct'])->name('createProduct');
Route::any('admin/category_product/create', [AdminController::class, 'createCategory'])->name('createCategory');


Route::get('admin/category_product', [AdminController::class, 'listCategoryProduct'])->name('admin/category_product');
Route::any('admin/downloadImage/{model}/{id}', [AdminController::class, 'downloadFile'])->name('admin/downloadImage');


