<?php

namespace App\Controllers\System;

use App\Core\Controller;

class PermissionsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index()
    {
        return $this->render('system.permissions.index');
    }
}