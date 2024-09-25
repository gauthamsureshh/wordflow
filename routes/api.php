<?php

use App\Http\Controllers\Post_APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


    Route::get('/list',[Post_APIController::class,'index']);
    Route::delete('/delete/{id}',[Post_APIController::class,'destroy']);
    Route::post('/create',[Post_APIController::class,'store']);
    Route::put('/update/{id}',[Post_APIController::class,'update']);