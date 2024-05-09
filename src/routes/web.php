<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');

Route::get('/question/create', [QuestionController::class, 'create'])->middleware(['auth', 'verified'])->name('question.create');

Route::post('/question', [QuestionController::class, 'store'])->middleware(['auth', 'verified'])->name('question.store');

Route::resource('question', QuestionController::class);

Route::post('/answer', [AnswerController::class, 'store'])->name('answer.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/adminBoard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('adminBoard');

Route::post('/user/{user}/admin', [UserController::class, 'update'])->middleware(['auth', 'verified'])->name('user.update');
Route::post('/user/{user}/password', [UserController::class, 'edit'])->middleware(['auth', 'verified'])->name('user.updatePassword');
Route::post('/user/{user}/name', [UserController::class, 'editName'])->middleware(['auth', 'verified'])->name('user.updateName');
Route::delete('/user/{user}/delete', [UserController::class, 'destroy'])->middleware(['auth', 'verified'])->name('user.delete');
Route::post('/admin/create', [UserController::class, 'create'])->middleware(['auth', 'verified'])->name('admin.create');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
