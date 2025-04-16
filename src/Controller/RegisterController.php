<?php

namespace App\Controller;

use App\Kernel\Controller\Controller;

class RegisterController extends Controller
{
public function index()
{
$this->view('register');
}

public function register()
{
$validation = $this->request()->validate([
'email' => ['required', 'email'],
'password' => ['required', 'min:8']
]);

if (!$validation) {
foreach ($this->request()->errors() as $field => $errors) {
$this->session()->set($field . '.errors', $errors);
}

$this->redirect('/register');
}

dd('store user in database');
}
}
