<?php

namespace App\Controllers\System;

use App\Core\Controller;
use App\Core\Paginador;
use App\Core\Request;
use App\Models\Role;
use App\Requests\RoleRequest;

class RolesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $count = Role::count();
        $limit = 10;
        $page = isset($request->body()['page']) ? $request->body()['page'] : 1;
        $skip = ( $page == 1 ) ? 0 : ($page - 1) * $limit;
        $roles = Role::latest()->skip($skip)->take($limit)->get();
        $paginador = new Paginador($count, $limit, $page, $request->path);
        return $this->render('system.roles.index',[
            'count' => $count,
            'roles' => $roles,
            'paginador' => $paginador,
        ]);
    }

    public function create(Request $request)
    {
        if ( $request->method == "post" ) {
            $edit = new RoleRequest($request);
            if ( $validated = $edit->validate() ) {
                $role = Role::create($validated);
                session('success', "Role <b>{$role->name}</b> ha sido creado");
                redirect( route('roles.index'));
            }
        }
        return $this->render('system.roles.create');
    }

    public function edit(Role $role, Request $request)
    {
        if ( $request->method == "put" ) {
            $edit = new RoleRequest($request);
            if ( $validated = $edit->validate($role->id) ) {
                $role->update($validated);
                session('success', "Role <b>{$role->name}</b> ha sido editado");
                redirect( route('roles.index'));
            }
        }
        return $this->render('system.roles.edit', [
            'role' => $role,
        ]);
    }

    public function delete(Role $role, Request $request)
    {
        if ( $request->method == "delete" ) {
            $name = $role->name;
            $role->delete();
            session('success', "Role <b>{$name}</b> ha sido eliminado");
            redirect( route('roles.index'));
        }
        return $this->render('system.roles.delete', [
            'role' => $role,
        ]);
    }
}