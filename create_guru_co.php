<?php
// create_guru_co.php

// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>Membuat Akun Guru 'co'</h2>";

try {
    // Database configuration from .env
    $host = 'localhost';
    $dbname = 'lav_sms';
    $username = 'root';
    $password = '';
    
    echo "<p>Menghubungkan ke database: $dbname...</p>";
    
    // Create PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p>Berhasil terhubung ke database.</p>";
    
    // Check if user already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute(['co']);
    $existing = $stmt->fetch();
    
    echo "<p>Memeriksa apakah user 'co' sudah ada...</p>";
    
    // Prepare data
    // We need to manually hash the password since we can't use Laravel's Hash facade
    $passwordHash = password_hash('co', PASSWORD_DEFAULT);
    $code = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10));
    $rememberToken = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
    
    if ($existing) {
        echo "<p>User 'co' sudah ada. Memperbarui data...</p>";
        // Update existing user
        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, password = ?, user_type = ?, code = ?, remember_token = ?, updated_at = NOW() WHERE username = ?");
        $stmt->execute([
            'Guru CO',
            'co@localhost',
            $passwordHash,
            'teacher',
            $code,
            $rememberToken,
            'co'
        ]);
        echo "<p style='color: green;'>User 'co' berhasil diperbarui.</p>";
    } else {
        echo "<p>User 'co' belum ada. Membuat user baru...</p>";
        // Insert new user
        $stmt = $pdo->prepare("INSERT INTO users (name, email, username, password, user_type, code, remember_token, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute([
            'Guru CO',
            'co@localhost',
            'co',
            $passwordHash,
            'teacher',
            $code,
            $rememberToken
        ]);
        echo "<p style='color: green;'>User 'co' berhasil dibuat.</p>";
    }
    
    echo "<p><strong>Data login:</strong></p>";
    echo "<ul>";
    echo "<li>Username: <strong>co</strong></li>";
    echo "<li>Password: <strong>co</strong></li>";
    echo "</ul>";
    echo "<p>Silakan coba login di <a href='public/login'>halaman login</a>.</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<p>Pastikan database MySQL sudah berjalan dan database 'lav_sms' sudah dibuat.</p>";
}
?>