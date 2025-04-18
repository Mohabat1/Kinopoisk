<?php

namespace App\Middleware;

use App\Kernel\Middleware\AbstractMiddleware;

class GuestMiddleware extends AbstractMiddleware
{

    public function handle(): void
    {
        // Логируем, чтобы понять, вызвался ли middleware
        error_log('GuestMiddleware handle called');

        if ($this->auth->check()) {
            $this->redirect->to('/home');
            exit;
        }
    }
}