<?php

namespace App\Controllers\Auth;

use App\Core\Controller;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        return $this->render('auth.login');
    }

    public function register()
    {
        // $this->middleware('auth');
        $saludo = "Hola Mundo";
        $this->render('auth.register', [
            'message' => $saludo,
        ]);
    }
}