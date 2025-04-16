<?php

use App\Controller\HomeController;
use App\Controller\MovieController;
use App\Kernel\Router\Route;
use App\Controller\RegisterController;

return [
    //pages
    Route::get('/home', [HomeController::class, 'index']),
    Route::get('/movies', [MovieController::class, 'index']),
    Route::get('/admin/movies/add', [MovieController::class, 'add']),
    Route::post('/admin/movies/add', [MovieController::class, 'store']),

    //register
    Route::get('/register', [RegisterController::class, 'index']),
    Route::post('/register', [RegisterController::class, 'register']),

];