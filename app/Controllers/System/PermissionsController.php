<?php

namespace App\Controllers\System;

use App\Core\Controller;
use App\Core\Paginador;
use App\Core\Request;
use App\Models\Permission;
use App\Requests\PermissionRequest;

class PermissionsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $count = Permission::count();
        $limit = 10;
        $page = isset($request->body['page']) ? $request->body['page'] : 1;
        $skip = ( $page == 1 ) ? 0 : ($page - 1) * $limit;
        $permissions = Permission::latest()->skip($skip)->take($limit)->get();
        $paginador = new Paginador($count, $limit, $page, $request->path);
        return $this->render('system.permissions.index',[
            'permissions' => $permissions,
            'paginador' => $paginador,
        ]);
    }

    public function create(Request $request)
    {
        if ( $request->method == "post" ) {
            $create = new PermissionRequest($request);
            if ( $validated = $create->validate() ) {
                $permission = Permission::create($validated);
                session('success', "Permiso <b>{$permission->name}</b> ha sido creado");
                redirect( route('permissions.index'));
            }
        }
        return $this->render('system.permissions.create');
    }

    public function edit(Permission $permission, Request $request)
    {
        if ( $request->method == "put" ) {
            $edit = new PermissionRequest($request);
            if ( $validated = $edit->validate($permission->id) ) {
                $permission->update($validated);
                session('success', "Permiso <b>{$permission->name}</b> ha sido editado");
                redirect( route('permissions.index'));
            }
        }
        return $this->render('system.permissions.edit', [
            'permission'   => $permission
        ]);
    }

    public function delete(Permission $permission, Request $request)
    {
        if ( $request->method == "delete" ) {
            $name = $permission->name;
            $permission->delete();
            session('success', "Permiso <b>{$name}</b> ha sido eliminado");
            redirect( route('permissions.index'));
        }
        return $this->render('system.permissions.delete', [
            'permission'   => $permission
        ]);
    }
}