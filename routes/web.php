<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Product Routes for managing products on the platform via Inertia.js
Route::prefix('products')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Products/Index');
    })->name('products.index');

    Route::get('/create', function () {
        return Inertia::render('Products/Create');
    })->name('products.create');

    Route::get('/{id}', function ($id) {
        return Inertia::render('Products/Show', [
            'id' => (int) $id, // Ensure ID is an integer
        ]);
    })->name('products.show');

    Route::get('/{id}/edit', function ($id) {
        return Inertia::render('Products/Edit', [
            'id' => (int) $id, // Ensure ID is an integer
        ]);
    })->name('products.edit');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
