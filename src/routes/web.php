<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;


// home
Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');
Route::get('locale/{lang}', [LocaleController::class, 'setLocale']);

// manual page
Route::get('/manual', function () {
    return view("manual");
})->name('manual');
Route::get("/pdf/manual", [ManualController::class, 'downloadPDF'])->name('downloadPDF');

// my questions
Route::get('/dashboard', [QuestionController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// questions
Route::post('/question', [QuestionController::class, 'store'])->middleware(['auth', 'verified'])->name('question.store');
Route::get('/question/create', [QuestionController::class, 'create'])->middleware(['auth', 'verified'])->name('question.create');
Route::post('/question/{question}', [QuestionController::class, 'multiply'])->middleware(['auth', 'verified'])->name('question.multiply');
Route::put('/question/{question}', [QuestionController::class, 'update'])->middleware(['auth', 'verified'])->name('question.update');
Route::get('/question/{question}/answers', [AnswerController::class, 'show'])->name('answers.show');
Route::get('/question/{question}/answers/update', [AnswerController::class, 'updateShow'])->name('answers.showUpdate');
Route::get('/question/{question}/comparison', [AnswerController::class, 'comparison'])->middleware(['auth', 'verified'])->name('answers.comparison');
Route::get('/question/{question}/answers/export', [AnswerController::class, 'export'])->middleware(['auth', 'verified'])->name('answers.export');
Route::resource('question', QuestionController::class)->except(['update', 'store']);

Route::post('/answer/{id}', [AnswerController::class, 'store'])->name('answer.store');

// admin
Route::get('/admin/Users', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('adminUserControl');
Route::get('/admin/AllQuestions', [UserController::class, 'indexQuestions'])->middleware(['auth', 'verified'])->name('adminQuestionControl');
Route::post('/admin/create', [UserController::class, 'create'])->middleware(['auth', 'verified'])->name('admin.create');
Route::delete('/question/{id}/admin', [QuestionController::class, 'destroyAdmin'])->middleware(['auth', 'verified'])->name('question.destroyAdmin');

// user
Route::get('/user/{id}', [UserController::class, 'getById'])->middleware(['auth', 'verified'])->name('getById');
Route::post('/user/{user}/admin', [UserController::class, 'update'])->middleware(['auth', 'verified'])->name('user.update');
Route::post('/user/{user}/password', [UserController::class, 'edit'])->middleware(['auth', 'verified'])->name('user.updatePassword');
Route::post('/user/{user}/name', [UserController::class, 'editName'])->middleware(['auth', 'verified'])->name('user.updateName');
Route::delete('/user/{user}/delete', [UserController::class, 'destroy'])->middleware(['auth', 'verified'])->name('user.delete');

// auth
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

require __DIR__.'/auth.php';
