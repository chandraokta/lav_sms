<?php
// reset_now.php
// Script paling sederhana untuk reset kelas
// Akses: http://localhost/lav_sms/reset_now.php

echo "<h2>RESET KELAS - Hapus Semua & Buat Kelas Contoh</h2>";

if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    // Koneksi database - sesuaikan dengan konfigurasi Anda
    $link = mysqli_connect("localhost", "root", "", "lav_sms");
    
    if (!$link) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
    
    echo "<p style='color: blue;'>✓ Terhubung ke database</p>";
    
    // HAPUS SEMUA TANPA PERTANYAAN!
    mysqli_query($link, "DELETE FROM sections");
    echo "<p style='color: orange;'>✓ Sections dihapus: " . mysqli_affected_rows($link) . "</p>";
    
    mysqli_query($link, "DELETE FROM student_records");
    echo "<p style='color: orange;'>✓ Student records dihapus: " . mysqli_affected_rows($link) . "</p>";
    
    mysqli_query($link, "DELETE FROM my_classes");
    echo "<p style='color: orange;'>✓ Classes dihapus: " . mysqli_affected_rows($link) . "</p>";
    
    // Cari class type
    $result = mysqli_query($link, "SELECT id FROM class_types WHERE name = 'Primary' LIMIT 1");
    if (mysqli_num_rows($result) == 0) {
        $result = mysqli_query($link, "SELECT id FROM class_types LIMIT 1");
    }
    
    $row = mysqli_fetch_assoc($result);
    $class_type_id = $row['id'];
    
    echo "<p>Gunakan class type ID: {$class_type_id}</p>";
    
    // Buat Kelas Contoh
    $sql = "INSERT INTO my_classes (name, class_type_id, created_at, updated_at) VALUES ('Kelas Contoh', {$class_type_id}, NOW(), NOW())";
    mysqli_query($link, $sql);
    $class_id = mysqli_insert_id($link);
    
    echo "<p style='color: green;'>✓ Kelas Contoh dibuat dengan ID: {$class_id}</p>";
    
    // Buat sections
    mysqli_query($link, "INSERT INTO sections (name, my_class_id, active, created_at, updated_at) VALUES ('A', {$class_id}, 1, NOW(), NOW())");
    mysqli_query($link, "INSERT INTO sections (name, my_class_id, active, created_at, updated_at) VALUES ('B', {$class_id}, 1, NOW(), NOW())");
    
    echo "<p style='color: green;'>✓ 2 Sections dibuat untuk Kelas Contoh</p>";
    echo "<h3 style='color: green;'>✓ SELESAI! Sekarang hanya ada 'Kelas Contoh'</h3>";
    
    mysqli_close($link);
} else {
    echo "<p><a href='?confirm=yes' style='background: red; color: white; padding: 10px 20px; text-decoration: none; font-weight: bold;'>KLIK DI SINI UNTUK HAPUS SEMUA KELAS & BUAT HANYA 'KELAS CONTOH'</a></p>";
    echo "<p style='color: red; font-weight: bold;'>⚠ TINDAKAN INI AKAN MENGHAPUS SEMUA KELAS, SECTION, DAN STUDENT RECORDS!</p>";
}