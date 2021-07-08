<?php

namespace App\Controllers\System;

use App\Core\Controller;
use App\Core\Paginador;
use App\Core\Request;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use App\Requests\UserRequest;

class UsersController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $count = User::count();
        $limit = 10;
        $page = isset($request->body()['page']) ? $request->body()['page'] : 1;
        $skip = ( $page == 1 ) ? 0 : ($page - 1) * $limit;
        $users = User::latest()->skip($skip)->take($limit)->get();
        $paginador = new Paginador($count, $limit, $page, $request->path);
        return $this->render('system.users.index',[
            'count' => $count,
            'users' => $users,
            'paginador' => $paginador,
        ]);
    }

    public function create(Request $request)
    {
        if ( $request->method == "post" ) {
            $create = new UserRequest($request);
            if ( $validated = $create->validate() ) {
                $user = User::create($validated['user']);
                $user->profile()->create($validated['profile']);
                session('success', "Usuario <b>{$user->name}</b> ha sido creado");
                redirect( route('users.index'));
            }
        }
        $roles = Role::roles()->get();
        return $this->render('system.users.create', [
            'roles' => $roles,
        ]);
    }

    public function edit(User $user, Request $request)
    {
        if ( $request->method == "put" ) {
            $edit = new UserRequest($request);
            if ( $validated = $edit->validate($user->id) ) {
                $user->update($validated['user']);
                $user->profile()->update($validated['profile']);
                session('success', "Usuario <b>{$user->name}</b> ha sido editado");
                redirect( route('users.index'));
            }
        }
        $roles = Role::roles()->get();
        return $this->render('system.users.edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function delete(User $user, Request $request)
    {
        if ( $request->method == "delete" ) {
            $name = $user->name;
            $user->delete();
            session('success', "Usuario <b>{$user->name}</b> ha sido eliminado");
            redirect( route('users.index'));
        }
        $roles = Role::roles()->get();
        return $this->render('system.users.delete', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }
}