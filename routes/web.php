<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/',[PageController::class, 'homePage'])->name('homepage');
Route::get('/loginpage',[PageController::class, 'loginPage'])->name('loginpage');
Route::post('/login',[PageController::class, 'login'])->name('login.post');
Route::get('/registerpage',[PageController::class, 'registerPage'])->name('registerpage');
Route::post('/register',[PageController::class, 'register'])->name('register.post');
Route::get('/logout',[PageController::class, 'logout'])->name('logout');

Route::get('/listblog',[PostController::class, 'index'])->name('listblog');
Route::get('/createblog',[PostController::class, 'create'])->name('createblog');
Route::post('/create',[PostController::class, 'store'])->name('blog.store');
Route::get('/editblog/{post}',[PostController::class, 'edit'])->name('editblog');
Route::put('/update/{post}',[PostController::class, 'update'])->name('blog.update');
Route::delete('/deleteblog/{post}',[PostController::class, 'destroy'])->name('blog.delete');