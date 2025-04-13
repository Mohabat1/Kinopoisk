<?php

namespace App\Controller;

use App\Kernel\Controller\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('home');
    }
}
