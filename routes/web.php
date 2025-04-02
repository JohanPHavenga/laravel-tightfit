<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home.home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/manuals', [HomeController::class, 'manuals'])->name('manuals');
Route::get('/contact', [ContactController::class, "show"])->name('contact.show');
Route::post('/contact', [ContactController::class, "store"])->name('contact.store');
Route::get('/success', [ContactController::class, "success"])->name('contact.success');
Route::get('/gallery/{type?}/{product?}', [GalleryController::class, "index"])->name('gallery');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
