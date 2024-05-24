<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShoppingItemController;

Route::get('/', [ShoppingItemController::class, 'index'])->name('shopping.index');
Route::post('/shopping', [ShoppingItemController::class, 'store'])->name('shopping.store');
Route::put('/shopping/{id}', [ShoppingItemController::class, 'markAsBought'])->name('shopping.markAsBought');
Route::delete('/shopping/{id}', [ShoppingItemController::class, 'destroy'])->name('shopping.destroy');
