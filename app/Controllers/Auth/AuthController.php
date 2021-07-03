<?php

namespace App\Controllers\Auth;

use App\Core\Controller;

class AuthController extends Controller
{
    public function login()
    {
        return $this->render('auth.login');
    }

    public function register()
    {
        return $this->render('auth.register');
    }
}