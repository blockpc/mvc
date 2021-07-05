<?php

namespace App\Controllers\Auth;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Profile;
use App\Models\User;
use App\Requests\LoginRequest;
use App\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login(Request $request)
    {
        if ( $request->method == "post" ) {
            $login = new LoginRequest($request);
            if ( $validated = $login->validate() ) {
                $remember = $validated['rememberme'] ? 1 : 0;
                if ( !$user = User::where('email', $validated['email'])->first() ) {
                    session('error', 'Credenciales no encontradas');
                }
                if ( $user && password_verify($validated['password'], $user->password) ) {
                    app()->login($user, $remember);
                    session('success', "Bienvenido <b>{$user->name}</b> a blokcpc");
                    redirect(route('dashboard'));
                } else {
                    session('error', 'Credenciales no encontradas');
                }
            }
        }
        return $this->render('auth.login');
    }

    public function register(Request $request)
    {
        if ( $request->method == "post" ) {
            $register = new RegisterRequest($request);
            if ( $validated = $register->validate() ) {
                $user = User::create($validated['user']);
                $validated['profile']['user_id'] = $user->id;
                $user->profile()->save(Profile::create($validated['profile']));
                session('success', "Usuario <b>{$user->name}</b> ha sido creado");
                redirect( route('home'));
            }
        }
        $this->render('auth.register');
    }

    public function logout(Request $request)
    {
        $this->middleware('auth');
        if ( $request->method == "post" ) {
            app()->logout();
        }
        redirect(route('home'));
    }
}