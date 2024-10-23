<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\UserRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FormController::class, 'index'])->name('forms.index');

Route::post('/registration/store', [UserRegistrationController::class, 'store'])->name('forms.store');
Route::get('/registration/{country}/edit', [UserRegistrationController::class, 'edit'])->name('forms.edit')->middleware('auth');
Route::put('/registration/{country}', [UserRegistrationController::class, 'update'])->name('forms.update');
Route::get('/registration/{country}/register', [UserRegistrationController::class, 'register'])->name('forms.register');
