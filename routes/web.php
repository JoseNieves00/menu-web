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

Route::any('/categorias/{id}', [AdminController::class, 'getCategoryProducts'])->name('/categorias');

Route::any('/getToppings/{id}', [AdminController::class, 'getToppings'])->name('/getToppings');



Route::any('admin', [AdminController::class, 'login'])->name('admin');
Route::get('logout', [AdminController::class, 'logout'])->name('logout');


Route::any('admin/categorys', [AdminController::class, 'listCategorys'])->name('admin/categorys');
Route::any('admin/products/{id}', [AdminController::class, 'getProducts'])->name('admin/products');
Route::any('admin/category/edit/{id}', [AdminController::class, 'editCategory'])->name('admin/category/edit');
Route::any('admin/product/edit/{id}', [AdminController::class, 'editProduct'])->name('admin/product/edit');
Route::any('admin/product/create/{id}', [AdminController::class, 'createProduct'])->name('admin/product/create');
Route::any('admin/category_product/create', [AdminController::class, 'createCategory'])->name('createCategory');

Route::any('admin/toppings', [AdminController::class, 'listTopping'])->name('admin/toppings');
Route::any('admin/toppings/create', [AdminController::class, 'createTopping'])->name('admin/toppings/create');
Route::any('admin/toppings/edit/{id}', [AdminController::class, 'editTopping'])->name('admin/toppings/edit');

Route::any('admin/updateProductVersion/{id}', [AdminController::class, 'editProductVersion'])->name('admin/updateProductVersion');
Route::any('admin/createProductVersion', [AdminController::class, 'createProductVersion'])->name('admin/createProductVersion');

Route::any('admin/getCategoryToppings/{id}', [AdminController::class, 'getCategoryToppings'])->name('admin/getCategoryToppings');

Route::get('admin/category_product', [AdminController::class, 'listCategoryProduct'])->name('admin/category_product');
Route::any('admin/downloadImage/{model}/{id}', [AdminController::class, 'downloadFile'])->name('admin/downloadImage');


