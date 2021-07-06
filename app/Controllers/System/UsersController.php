<?php

namespace App\Controllers\System;

use App\Core\Controller;
use App\Models\User;

class UsersController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index()
    {
        return $this->render('system.users.index');
    }
}