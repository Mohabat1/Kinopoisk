<?php

use App\Router\Route;

return[
    Route::get('/home', function () {
        require_once APP_PATH .  "/views/pages/home.php";
    }),
    Route::get('/movies', function () {
        require_once APP_PATH .  "/views/pages/movies.php";
    }),
];
