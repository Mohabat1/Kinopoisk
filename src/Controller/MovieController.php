<?php

namespace App\Controller;

use App\Kernel\Controller\Controller;
use App\Kernel\View\View;
use App\Kernel\Validator\Validator;
use App\Kernel\Http\Redirect;
use App\Kernel\Session\Session;


class MovieController extends Controller
{
    public function index(): void
    {
        $this->view('movies');
    }
    public function add(): void
    {
        $this->view('admin/movies/add');
    }
    public function store(): void
    {
        $validation = $this->request()->validate([
            'name' => ['required', 'min:3', 'max:255'],
        ]);

        if(! $validation){
            foreach ($this->request()->errors() as $field => $error){
                $this->session()->set("name.errors", $this->request()->errors());
            }

            $this->redirect('/admin/movies/add');
        }


        $id = $this->db()->insert('movie', [
            'name' => $this->request()->input('name'),
        ]);
        dd("Movie added successfully with id: " . $id);
    }
}