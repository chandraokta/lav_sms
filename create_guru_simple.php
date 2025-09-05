<?php
// File untuk membuat akun guru dengan password sederhana
require_once 'vendor/autoload.php';

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Hash;

// Setup database connection
$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => '127.0.0.1',
    'database'  => 'lav_sms',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

// Hash password
$password = password_hash('12345678', PASSWORD_DEFAULT);

// Create or update guru user with simple password
$d = [
    'name' => 'Guru SMP Test',
    'email' => 'guru@localhost',
    'username' => 'guru',
    'password' => $password,
    'user_type' => 'teacher',
    'code' => 'TEST123456',
    'remember_token' => null,
];

// Check if user already exists
$existing = Capsule::table('users')->where('email', 'guru@localhost')->first();

if ($existing) {
    // Update existing user
    Capsule::table('users')->where('email', 'guru@localhost')->update($d);
    echo "Akun guru diperbarui dengan password baru\n";
} else {
    // Create new user
    Capsule::table('users')->insert($d);
    echo "Akun guru baru dibuat dengan password baru\n";
}

echo "Password hash: " . $password . "\n";
?>