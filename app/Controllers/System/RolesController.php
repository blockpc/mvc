<?php

namespace App\Controllers\System;

use App\Core\Controller;
use App\Core\Paginador;
use App\Core\Request;
use App\Models\Role;

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
        $paginador = new Paginador($count, $limit, $page, $request->path . '?page=(:num)');
        return $this->render('system.roles.index',[
            'count' => $count,
            'roles' => $roles,
            'paginador' => $paginador,
        ]);
    }
}