<?php

namespace App\Controllers\System;

use App\Core\Controller;

class RolesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index()
    {
        return $this->render('system.roles.index');
    }
}