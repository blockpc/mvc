<?php

namespace App\Controllers\System;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Role;
use App\Requests\ProfileRequest;
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

    public function profile(Request $request)
    {
        $user = auth();
        $this->middleware('profile', $user->id);
        if ( $request->method == "put" ) {
            $profile = new ProfileRequest($request);
            if ( $validated = $profile->validate() ) {
                $user->update($validated['user']);
                $user->profile()->update($validated['profile']);
                session('success', "Tus datos de usuario han sido editados");
                redirect( route('profile'));
            }
        }
        $this->render('system.profile', [
            'user' => $user,
            'roles' => Role::roles()->get(),
        ]);
    }
}