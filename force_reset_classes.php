<?php
// force_reset_classes.php
// Script untuk menghapus semua kelas dan membuat hanya "Kelas Contoh"
// Simpan file ini di direktori utama project (C:\xampp\htdocs\lav_sms)

// Mulai session dan bootstrap Laravel
require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

try {
    // Bootstrap Laravel app
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    echo "<h2>Force Reset Classes to 'Kelas Contoh'</h2>\n";
    echo "<p>Memulai proses reset kelas...</p>\n";
    
    // Cek koneksi database
    DB::connection()->getPdo();
    echo "<p style='color: green;'>✓ Koneksi database berhasil</p>\n";
    
    // Hitung kelas yang ada sekarang
    $classCount = DB::table('my_classes')->count();
    echo "<p>Jumlah kelas saat ini: <strong>{$classCount}</strong></p>\n";
    
    // Hitung section yang ada sekarang
    $sectionCount = DB::table('sections')->count();
    echo "<p>Jumlah section saat ini: <strong>{$sectionCount}</strong></p>\n";
    
    // Hitung student records yang ada sekarang
    $studentCount = DB::table('student_records')->count();
    echo "<p>Jumlah student records saat ini: <strong>{$studentCount}</strong></p>\n";
    
    // PERINGATAN: Jika ada student records, ini akan menghapus semua
    if ($studentCount > 0) {
        echo "<p style='color: orange; font-weight: bold;'>⚠ PERINGATAN: Ada {$studentCount} student records yang akan dihapus!</p>\n";
        echo "<p>Untuk melanjutkan, hapus dulu semua student records atau ubah script ini.</p>\n";
        exit;
    }
    
    // Hapus semua sections dulu (karena ada foreign key constraint)
    $deletedSections = DB::table('sections')->delete();
    echo "<p style='color: blue;'>✓ Telah menghapus {$deletedSections} sections</p>\n";
    
    // Hapus semua classes
    $deletedClasses = DB::table('my_classes')->delete();
    echo "<p style='color: blue;'>✓ Telah menghapus {$deletedClasses} classes</p>\n";
    
    // Cari class_type_id untuk Primary (atau gunakan yang pertama tersedia)
    $classType = DB::table('class_types')->where('name', 'Primary')->first();
    if (!$classType) {
        $classType = DB::table('class_types')->first();
        if (!$classType) {
            throw new Exception("Tidak ada class types yang ditemukan!");
        }
    }
    
    echo "<p>Menggunakan class type: <strong>{$classType->name}</strong></p>\n";
    
    // Buat "Kelas Contoh"
    $kelasContohId = DB::table('my_classes')->insertGetId([
        'name' => 'Kelas Contoh',
        'class_type_id' => $classType->id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    echo "<p style='color: green;'>✓ Berhasil membuat 'Kelas Contoh' dengan ID: {$kelasContohId}</p>\n";
    
    // Buat sections untuk "Kelas Contoh"
    $sections = [
        [
            'name' => 'A',
            'my_class_id' => $kelasContohId,
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'B',
            'my_class_id' => $kelasContohId,
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]
    ];
    
    DB::table('sections')->insert($sections);
    echo "<p style='color: green;'>✓ Berhasil membuat 2 sections untuk 'Kelas Contoh'</p>\n";
    
    // Verifikasi hasil
    $finalClassCount = DB::table('my_classes')->count();
    $finalSectionCount = DB::table('sections')->count();
    
    echo "<h3>Hasil Akhir:</h3>\n";
    echo "<ul>\n";
    echo "<li>Jumlah classes sekarang: <strong>{$finalClassCount}</strong></li>\n";
    echo "<li>Jumlah sections sekarang: <strong>{$finalSectionCount}</strong></li>\n";
    echo "</ul>\n";
    
    echo "<h3 style='color: green;'>✓ RESET BERHASIL!</h3>\n";
    echo "<p>Sekarang hanya ada 1 kelas: <strong>Kelas Contoh</strong> dengan 2 sections (A dan B)</p>\n";
    
} catch (Exception $e) {
    echo "<p style='color: red; font-weight: bold;'>ERROR: " . $e->getMessage() . "</p>\n";
    echo "<pre>" . $e->getTraceAsString() . "</pre>\n";
}