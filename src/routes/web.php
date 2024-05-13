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

Route::get('/dashboard', [QuestionController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/manual', function () {
    return view("manual");
})->name('manual');


Route::resource('question', QuestionController::class);
Route::post('/question/{question}', [QuestionController::class, 'multiply'])->middleware(['auth', 'verified'])->name('question.multiply');
Route::put('/question/{question}', [QuestionController::class, 'update'])->middleware(['auth', 'verified'])->name('question.update');

Route::post('/answer/{id}', [AnswerController::class, 'store'])->name('answer.store');
Route::get('/answer/{id}', [AnswerController::class, 'show'])->name('answer.show');

Route::get('/user/{id}', [UserController::class, 'getById'])->middleware(['auth', 'verified'])->name('getById');

Route::get('/admin/Users', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('adminUserControl');
Route::get('/admin/AllQuestions', [UserController::class, 'indexQuestions'])->middleware(['auth', 'verified'])->name('adminQuestionControl');
Route::delete('/question/{id}/admin', [QuestionController::class, 'destroyAdmin'])->middleware(['auth', 'verified'])->name('question.destroyAdmin');

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

Route::get('/{any}', function ($any) {
    if (App\Models\Question::where('id', $any)->exists()) {
        return redirect("/question/$any");
    }
    abort(404);
})->where('any', '^(?!login$|register$|forgot-password$)[a-zA-Z0-9]{5}$');

require __DIR__ . '/auth.php';
