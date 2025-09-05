<?php
// File untuk menguji autentikasi manual
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

// Test credentials
$email = 'guru@localhost';
$password = '12345678';

// Get user from database
$user = Capsule::table('users')->where('email', $email)->first();

if ($user) {
    echo "User ditemukan:\n";
    echo "Email: " . $user->email . "\n";
    echo "Password hash: " . $user->password . "\n";
    
    // Verify password
    if (password_verify($password, $user->password)) {
        echo "Password benar! Autentikasi berhasil.\n";
    } else {
        echo "Password salah! Autentikasi gagal.\n";
        
        // Check if it's a bcrypt hash
        if (substr($user->password, 0, 4) === '$2y$') {
            echo "Password menggunakan bcrypt hash.\n";
        } else {
            echo "Password tidak menggunakan bcrypt hash yang benar.\n";
        }
    }
} else {
    echo "User tidak ditemukan.\n";
}
?>
