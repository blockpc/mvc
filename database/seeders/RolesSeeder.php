<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sudo = new Role;
        $sudo->key = "sudo";
        $sudo->name = "Super administrador";
        $sudo->description = "Role con control total";
        $sudo->save();

        $admin = new Role;
        $admin->key = "admin";
        $admin->name = "Administrador";
        $admin->description = "Administrador aplicación";
        $admin->save();

        $user = new Role;
        $user->key = "user";
        $user->name = "Usuario";
        $user->description = "Usuario aplicación";
        $user->save();
    }

}