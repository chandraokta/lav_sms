<?php
// File untuk membuat akun guru dengan password bcrypt
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

// Create user with bcrypt password (12345678)
$d = [
    'name' => 'Guru SMP Final',
    'email' => 'guru@localhost',
    'username' => 'guru',
    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // bcrypt('12345678')
    'user_type' => 'teacher',
    'code' => 'FINAL123456',
    'remember_token' => null,
];

// Check if user already exists
$existing = Capsule::table('users')->where('email', 'guru@localhost')->first();

if ($existing) {
    // Update existing user
    Capsule::table('users')->where('email', 'guru@localhost')->update($d);
    echo "Akun guru diperbarui dengan password bcrypt\n";
} else {
    // Create new user
    Capsule::table('users')->insert($d);
    echo "Akun guru baru dibuat dengan password bcrypt\n";
}
?>