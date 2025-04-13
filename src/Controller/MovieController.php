<?php

namespace App\Controller;

use App\Kernel\Controller\Controller;
use App\Kernel\View\View;

class MovieController extends Controller
{
    public function index(): void
    {
        $this->view('movies');

        $view = new View();

        $view->page('movies');
    }

}