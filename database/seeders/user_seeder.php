<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class user_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Etienne',
            'email' => 'etiennezoer@gmail.com',
            'password' => 'geheim123',
            'api_token' => Hash::make(Str::random(60)),
            'role_id' => '1'
        ]);
    }
}
