<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;   

Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);
Route::get('/posts/search', [PostController::class, 'search']);
Route::get('/posts/paginated', [PostController::class, 'paginated']); 
Route::get('/posts/list', [PostController::class, 'list']);  
