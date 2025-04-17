<?php

use App\Controller\HomeController;
use App\Controller\LoginController;
use App\Controller\MovieController;
use App\Kernel\Router\Route;
use App\Controller\RegisterController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

return [
//pages
    Route::get('/home', [HomeController::class, 'index']),
    Route::get('/movies', [MovieController::class, 'index']),
    Route::get('/admin/movies/add', [MovieController::class, 'add']),[AuthMiddleware::class],
    Route::post('/admin/movies/add', [MovieController::class, 'store']),

//register
    Route::get('/register', [RegisterController::class, 'index']),
    Route::post('/register', [RegisterController::class, 'register']),[GuestMiddleware::class],

//login
    Route::get('/login', [LoginController::class, 'index']),
    Route::post('/login', [LoginController::class, 'login']),[GuestMiddleware::class],
    Route::post('/logout', [LoginController::class, 'logout']),

];