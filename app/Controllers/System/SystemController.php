<?php

namespace App\Controllers\System;

use App\Core\Controller;
use Illuminate\Support\Facades\Hash;

class SystemController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $this->render('system.dashboard', [
            'user' => auth(),
        ]);
    }

    public function settings()
    {
        $this->render('system.settings', [
            'user' => auth(),
        ]);
    }

    public function profile()
    {
        $this->middleware('profile', auth()->id);
        $this->render('system.profile', [
            'user' => auth(),
        ]);
    }
}