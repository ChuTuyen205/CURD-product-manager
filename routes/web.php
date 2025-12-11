<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/contacts', [ContactController::class, 'index'])->name('contact.index');
Route::get('/brands', [BrandController::class, 'index'])->name('brand.index');
Route::get('/products', [ProductController::class, 'index'])->name('product.index');
