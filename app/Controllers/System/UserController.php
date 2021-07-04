<?php

namespace App\Controllers\System;

use App\Core\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function profile(User $user)
    {
        $this->middleware('profile', $user->id);
        $this->render('system.user.profile', [
            'user' => auth(),
        ]);
    }
}