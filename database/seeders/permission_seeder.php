<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class permission_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'permission_name' => 'create_domain',
        ]);
        DB::table('permissions')->insert([
            'permission_name' => 'delete_domain',
        ]);
        DB::table('permissions')->insert([
            'permission_name' => 'getAll_domain',
        ]);
        DB::table('permissions')->insert([
            'permission_name' => 'getOne_domain',
        ]);
        DB::table('permissions')->insert([
            'permission_name' => 'create_user',
        ]);
        DB::table('permissions')->insert([
            'permission_name' => 'delete_user',
        ]);
        DB::table('permissions')->insert([
            'permission_name' => 'getAll_user',
        ]);
        DB::table('permissions')->insert([
            'permission_name' => 'getOne_user',
        ]);
    }
}
