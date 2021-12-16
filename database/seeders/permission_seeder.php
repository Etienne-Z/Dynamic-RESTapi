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
            'permission_name' => 'Domain_save',
        ]);
        DB::table('permissions')->insert([
            'permission_name' => 'Domain_delete',
        ]);
        DB::table('permissions')->insert([
            'permission_name' => 'Domain_getall',
        ]);
        DB::table('permissions')->insert([
            'permission_name' => 'Domain_getone',
        ]);
        DB::table('permissions')->insert([
            'permission_name' => 'Domain_update',
        ]);
        DB::table('permissions')->insert([
            'permission_name' => 'User_create',
        ]);
        DB::table('permissions')->insert([
            'permission_name' => 'User_delete',
        ]);
        DB::table('permissions')->insert([
            'permission_name' => 'User_getall',
        ]);
        DB::table('permissions')->insert([
            'permission_name' => 'User_getone',
        ]);
        DB::table('permissions')->insert([
            'permission_name' => 'User_update',
        ]);
    }
}
