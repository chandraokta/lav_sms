<?php
// simple_force_reset.php
// Script sangat sederhana untuk menghapus semua kelas dan membuat hanya "Kelas Contoh"
// Akses via browser: http://localhost/lav_sms/simple_force_reset.php

// Koneksi database langsung
$host = 'localhost';
$dbname = 'lav_sms'; // sesuaikan dengan nama database Anda
$username = 'root'; // sesuaikan dengan username database Anda
$password = ''; // sesuaikan dengan password database Anda

echo "<!DOCTYPE html>
<html>
<head>
    <title>Force Reset Classes</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        .info { color: blue; }
        h2 { color: #333; }
        ul { background: #f9f9f9; padding: 15px; border-left: 4px solid #007cba; }
        button { background: #007cba; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #005a87; }
    </style>
</head>
<body>
<div class='container'>
<h2>Force Reset Classes to 'Kelas Contoh'</h2>";

try {
    // Koneksi ke database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p class='success'>✓ Koneksi database berhasil</p>";
    
    // Cek apakah tombol reset ditekan
    if (isset($_POST['reset'])) {
        echo "<h3>Memulai proses reset...</h3>";
        
        // Hapus semua sections
        $stmt = $pdo->prepare("DELETE FROM sections");
        $deletedSections = $stmt->execute() ? $stmt->rowCount() : 0;
        echo "<p class='info'>✓ Telah menghapus {$deletedSections} sections</p>";
        
        // Hapus semua student records (jika ada)
        $stmt = $pdo->prepare("DELETE FROM student_records");
        $deletedStudents = $stmt->execute() ? $stmt->rowCount() : 0;
        if ($deletedStudents > 0) {
            echo "<p class='warning'>⚠ Telah menghapus {$deletedStudents} student records</p>";
        }
        
        // Hapus semua classes
        $stmt = $pdo->prepare("DELETE FROM my_classes");
        $deletedClasses = $stmt->execute() ? $stmt->rowCount() : 0;
        echo "<p class='info'>✓ Telah menghapus {$deletedClasses} classes</p>";
        
        // Cari class_type_id untuk Primary
        $stmt = $pdo->prepare("SELECT id FROM class_types WHERE name = 'Primary' LIMIT 1");
        $stmt->execute();
        $classType = $stmt->fetch(PDO::FETCH_OBJ);
        
        if (!$classType) {
            // Jika tidak ada Primary, ambil yang pertama
            $stmt = $pdo->prepare("SELECT id FROM class_types LIMIT 1");
            $stmt->execute();
            $classType = $stmt->fetch(PDO::FETCH_OBJ);
        }
        
        if (!$classType) {
            throw new Exception("Tidak ada class types yang ditemukan!");
        }
        
        echo "<p>Menggunakan class type ID: <strong>{$classType->id}</strong></p>";
        
        // Buat "Kelas Contoh"
        $stmt = $pdo->prepare("INSERT INTO my_classes (name, class_type_id, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
        $stmt->execute(['Kelas Contoh', $classType->id]);
        $kelasContohId = $pdo->lastInsertId();
        
        echo "<p class='success'>✓ Berhasil membuat 'Kelas Contoh' dengan ID: {$kelasContohId}</p>";
        
        // Buat sections untuk "Kelas Contoh"
        $stmt = $pdo->prepare("INSERT INTO sections (name, my_class_id, active, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
        $stmt->execute(['A', $kelasContohId, 1]);
        $stmt->execute(['B', $kelasContohId, 1]);
        
        echo "<p class='success'>✓ Berhasil membuat 2 sections untuk 'Kelas Contoh'</p>";
        
        // Verifikasi hasil
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM my_classes");
        $stmt->execute();
        $finalClassCount = $stmt->fetch(PDO::FETCH_OBJ)->count;
        
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM sections");
        $stmt->execute();
        $finalSectionCount = $stmt->fetch(PDO::FETCH_OBJ)->count;
        
        echo "<h3>Hasil Akhir:</h3>";
        echo "<ul>";
        echo "<li>Jumlah classes sekarang: <strong>{$finalClassCount}</strong></li>";
        echo "<li>Jumlah sections sekarang: <strong>{$finalSectionCount}</strong></li>";
        echo "</ul>";
        
        echo "<h3 class='success'>✓ RESET BERHASIL!</h3>";
        echo "<p>Sekarang hanya ada 1 kelas: <strong>Kelas Contoh</strong> dengan 2 sections (A dan B)</p>";
        
    } else {
        // Tampilkan form konfirmasi
        echo "<p>Script ini akan:</p>";
        echo "<ul>";
        echo "<li>❌ MENGHAPUS SEMUA classes yang ada</li>";
        echo "<li>❌ MENGHAPUS SEMUA sections yang ada</li>";
        echo "<li>❌ MENGHAPUS SEMUA student records (jika ada)</li>";
        echo "<li>✅ Membuat 1 class baru bernama 'Kelas Contoh'</li>";
        echo "<li>✅ Membuat 2 sections: A dan B</li>";
        echo "</ul>";
        echo "<p style='color: red; font-weight: bold;'>⚠ PERINGATAN: Tindakan ini tidak bisa dibatalkan!</p>";
        echo "<form method='post'>";
        echo "<button type='submit' name='reset' onclick='return confirm(\"Yakin ingin menghapus SEMUA classes dan membuat hanya Kelas Contoh?\")'>FORCE RESET SEKARANG</button>";
        echo "</form>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>ERROR: " . $e->getMessage() . "</p>";
}

echo "</div></body></html>";