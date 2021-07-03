<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sudo = Role::find(1);
        $admin = Role::find(2);
        $user = Role::find(3);

        $sudo = new User;
        $sudo->name = "sudo";
        $sudo->email = "sudo@mail.com";
        $sudo->password = 'password';
        $sudo->role_id = 1;
        $sudo->email_verified_at = date("Y-m-d H:i:s");
        $sudo->save();
        $sudo->profile()->create([
            'firstname' => 'Super', 
            'lastname' => 'Administrador'
        ]);

        $admin = new User;
        $admin->name = "admin";
        $admin->email = "admin@mail.com";
        $admin->password = 'password';
        $admin->role_id = 2;
        $admin->email_verified_at = date("Y-m-d H:i:s");
        $admin->save();
        $admin->profile()->create([
            'firstname' => 'Admin', 
            'lastname' => 'General'
        ]);

        $juan = new User;
        $juan->name = "juan";
        $juan->email = "juan@mail.com";
        $juan->password = 'password';
        $juan->role_id = 3;
        $juan->email_verified_at = date("Y-m-d H:i:s");
        $juan->save();
        $juan->profile()->create([
            'firstname' => 'Juan', 
            'lastname' => 'Andres'
        ]);

        $pedro = new User;
        $pedro->name = "pedro";
        $pedro->email = "pedro@mail.com";
        $pedro->password = 'password';
        $pedro->role_id = 3;
        $pedro->email_verified_at = date("Y-m-d H:i:s");
        $pedro->save();
        $pedro->profile()->create([
            'firstname' => 'Pedro', 
            'lastname' => 'Martinez'
        ]);
    }

}