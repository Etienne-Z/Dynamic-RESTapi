<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            domain_Seeder::class,
            permission_seeder::class,
            role_Seeder::class,
            role_permission_Seeder::class,
            role_seeder::class,
            user_seeder::class,

        ]);
    }    
}
