<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class role_permission_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('roles_permissions')->insert([
            'role_id' => '1',
            'permission_id' => '1'
        ]);        
        DB::table('roles_permissions')->insert([
            'role_id' => '1',
            'permission_id' => '2'
        ]);        
        DB::table('roles_permissions')->insert([
            'role_id' => '1',
            'permission_id' => '3'
        ]);        
        DB::table('roles_permissions')->insert([
            'role_id' => '1',
            'permission_id' => '4'
        ]);        
        DB::table('roles_permissions')->insert([
            'role_id' => '1',
            'permission_id' => '5'
        ]);        
        DB::table('roles_permissions')->insert([
            'role_id' => '1',
            'permission_id' => '6'
        ]);        
        DB::table('roles_permissions')->insert([
            'role_id' => '1',
            'permission_id' => '7'
        ]);        
        DB::table('roles_permissions')->insert([
            'role_id' => '1',
            'permission_id' => '8'
        ]);        
   
    }
}
