<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'roalmanager:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'admin'])->name('admin.dashboard');

    Route::get('/all-categories', [AdminController::class, 'allCategories'])->name('all.categories');
    Route::get('/category', [AdminController::class, 'category'])->name('category');
    Route::post('/create-category', [AdminController::class, 'createCategory'])->name('create.category');
    Route::get('/edit-category/{id}', [AdminController::class, 'editCategory'])->name('edit.category');
    Route::put('/update-category/{id}', [AdminController::class, 'updateCategory'])->name('update.category');
    Route::get('/delete-category/{id}', [AdminController::class, 'deleteCategory'])->name('delete.category');

    Route::get('/all-collections', [AdminController::class, 'allCollections'])->name('all.collections');
    Route::get('/collection', [AdminController::class, 'collection'])->name('collection');
    Route::post('/create-collection', [AdminController::class, 'createCollection'])->name('create.collection');
    Route::get('/search-product', [AdminController::class, 'searchProduct'])->name('search.product');
    Route::get('/edit-collection/{id}', [AdminController::class, 'editCollection'])->name('edit.collection');
    Route::put('/update-collection/{id}', [AdminController::class, 'updateCollection'])->name('update.collection');
    Route::get('/delete-collection/{id}', [AdminController::class, 'deleteCollection'])->name('delete.collection');

    Route::get('/all-products', [AdminController::class, 'allProducts'])->name('all.products');
    Route::get('/product', [AdminController::class, 'product'])->name('product');
    Route::post('/create-product', [AdminController::class, 'createProduct'])->name('create.product');
    Route::get('/search-product', [AdminController::class, 'searchProduct'])->name('search.product');
    Route::get('/edit-product/{id}', [AdminController::class, 'editProduct'])->name('edit.product');
    Route::put('/update-product/{id}', [AdminController::class, 'updateProduct'])->name('update.product');
    Route::get('/delete-product/{id}', [AdminController::class, 'deleteProduct'])->name('delete.product');

    Route::get('/all-orders', [AdminController::class, 'allOrders'])->name('all.orders');

    Route::get('/all-users', [AdminController::class, 'allUsers'])->name('all.users');
    Route::get('/view-user/{id}', [AdminController::class, 'viewUser'])->name('view.user');
    Route::get('/edit-user/{id}', [AdminController::class, 'editUser'])->name('edit.user');
    Route::put('/update-user/{id}', [AdminController::class, 'updateUser'])->name('update.user');
    Route::get('/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('delete.user');
});
