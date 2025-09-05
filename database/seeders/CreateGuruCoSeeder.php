<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateGuruCoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('co'); // Password: co

        $d = [
            'name' => 'Guru CO',
            'email' => 'co@localhost',
            'username' => 'co',
            'password' => $password,
            'user_type' => 'teacher',
            'code' => strtoupper(Str::random(10)),
            'remember_token' => Str::random(10),
        ];

        // Check if user already exists
        $existing = DB::table('users')->where('username', 'co')->first();
        
        if ($existing) {
            // Update existing user
            DB::table('users')->where('username', 'co')->update($d);
        } else {
            // Create new user
            DB::table('users')->insert($d);
        }
    }
}