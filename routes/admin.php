<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'roalmanager:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'admin'])->name('admin.dashboard');

    Route::get('/all-categories', [AdminController::class, 'allCategories'])->name('all.categories');
    Route::get('/category', [AdminController::class, 'category'])->name('category');

    Route::post('/create-category', [AdminController::class, 'createCategory'])->name('create.category');

    Route::get('/all-collections', [AdminController::class, 'allCollections'])->name('all.collections');
    Route::get('/collection', [AdminController::class, 'collection'])->name('collection');

    Route::post('/create-collection', [AdminController::class, 'createCollection'])->name('create.collection');
    Route::get('/search-product', [AdminController::class, 'searchProduct'])->name('search.product');

    Route::get('/all-products', [AdminController::class, 'allProducts'])->name('all.products');
    Route::get('/product', [AdminController::class, 'product'])->name('product');

    Route::get('/all-orders', [AdminController::class, 'allOrders'])->name('all.orders');

    Route::get('/all-users', [AdminController::class, 'allUsers'])->name('all.users');
    Route::get('/view-user/{id}', [AdminController::class, 'viewUser'])->name('view.user');
    Route::get('/edit-user/{id}', [AdminController::class, 'editUser'])->name('edit.user');
    Route::put('/update-user/{id}', [AdminController::class, 'updateUser'])->name('update.user');
    Route::get('/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('delete.user');
});
