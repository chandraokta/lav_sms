<?php
// File untuk memeriksa akun guru
require_once 'vendor/autoload.php';

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;

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

// Check if guru@localhost user exists
$guru = Capsule::table('users')->where('email', 'guru@localhost')->first();

if ($guru) {
    echo "Akun guru ditemukan:\n";
    echo "Name: " . $guru->name . "\n";
    echo "Email: " . $guru->email . "\n";
    echo "User Type: " . $guru->user_type . "\n";
} else {
    echo "Akun guru@localhost tidak ditemukan\n";
}

// List all users
echo "\nDaftar semua user:\n";
$users = Capsule::table('users')->get(['name', 'email', 'user_type']);
foreach ($users as $user) {
    echo "- " . $user->name . " (" . $user->email . ") - " . $user->user_type . "\n";
}
?>