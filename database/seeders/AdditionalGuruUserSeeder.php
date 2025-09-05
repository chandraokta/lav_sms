<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdditionalGuruUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('12345678'); // Password: 12345678

        $d = [
            'name' => 'Guru SMP Additional',
            'email' => 'guru.additional@localhost',
            'username' => 'guru_additional',
            'password' => $password,
            'user_type' => 'teacher',
            'code' => strtoupper(Str::random(10)),
            'remember_token' => Str::random(10),
        ];

        // Check if user already exists
        $existing = DB::table('users')->where('email', 'guru.additional@localhost')->first();
        
        if ($existing) {
            // Update existing user
            DB::table('users')->where('email', 'guru.additional@localhost')->update($d);
        } else {
            // Create new user
            DB::table('users')->insert($d);
        }
        
        echo "Akun tambahan guru.additional@localhost berhasil dibuat/diperbarui\n";
    }
}