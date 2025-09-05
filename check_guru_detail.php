<?php
// File untuk memeriksa detail akun guru
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

// Check if guru@localhost user exists with full details
$guru = Capsule::table('users')->where('email', 'guru@localhost')->first();

if ($guru) {
    echo "Akun guru ditemukan:\n";
    echo "Name: " . $guru->name . "\n";
    echo "Email: " . $guru->email . "\n";
    echo "Username: " . $guru->username . "\n";
    echo "User Type: " . $guru->user_type . "\n";
    echo "Password (hashed): " . $guru->password . "\n";
    echo "Created at: " . $guru->created_at . "\n";
} else {
    echo "Akun guru@localhost tidak ditemukan\n";
}
?>