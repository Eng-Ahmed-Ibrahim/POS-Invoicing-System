<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoriesController;

Route::middleware(['guest'])->group(function() {
    Route::view('/login', 'login')->name('login');
    Route::view('/', 'login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {

    Route::post("logout",[AuthController::class,'logout'])->name('logout');
    Route::get('/',[HomeController::class,'index'])->name('home');
        
    Route::get('/categories',[CategoriesController::class,'index'])->name('categories');
    Route::post('/store-category',[CategoriesController::class,'store'])->name('categories.store');
    Route::post('/update-category',[CategoriesController::class,'update'])->name('categories.update');
    Route::post('/destroy-category',[CategoriesController::class,'destroy'])->name('categories.destroy');

    Route::get('/products',[ProductsController::class,'index'])->name('products');
    Route::post('/store-product',[ProductsController::class,'store'])->name('products.store');
    Route::post('/update-product',[ProductsController::class,'update'])->name('products.update');
    Route::post('/destroy-product',[ProductsController::class,'destroy'])->name('products.destroy');

    Route::get('/clients',[ClientsController::class,'index'])->name('clients');
    Route::post('/store-client',[ClientsController::class,'store'])->name('clients.store');
    Route::post('/update-client',[ClientsController::class,'update'])->name('clients.update');
    Route::post('/destroy-client',[ClientsController::class,'destroy'])->name('clients.destroy');

    Route::get("invoices",[InvoicesController::class,'index'])->name('invoices');
    Route::get("invoices/{invoice_id}",[InvoicesController::class,'view'])->name('invoices.show');
    Route::post("delete-invoice/{invoice_id}",[InvoicesController::class,'delete'])->name('invoice.delete');
    Route::post("add-invoice",[InvoicesController::class,'add_invoice'])->name('add_invoice');
    Route::post("add-item",[InvoicesController::class,'add_item'])->name('add_item');
    Route::post("delete-item/{item_id}",[InvoicesController::class,'delete_item'])->name('invoice.delete_item');
    Route::get("update-invoice-status/{invoice_id}/{status}",[InvoicesController::class,'update_status'])->name('invoices.updateStatus');
    Route::get("invoic/pdf/{invoice_id}",[InvoicesController::class,'generate_pdf'])->name('invoices.download_pdf');
    Route::view('test','test');
});