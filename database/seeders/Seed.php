<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Seed extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesSeeder::class,
            UserSeeder::class,
            //...
        ]);
    }
}