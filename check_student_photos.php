<?php
// File untuk memeriksa data siswa
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
    'password' => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

// Check for student named "Badu"
echo "Mencari siswa bernama 'Badu'...
";

$students = Capsule::table('users as u')
    ->join('student_records as sr', 'u.id', '=', 'sr.user_id')
    ->select('u.name', 'u.photo', 'sr.adm_no', 'u.id')
    ->where('u.name', 'LIKE', '%Badu%')
    ->get();

if ($students->count() > 0) {
    echo "Ditemukan " . $students->count() . " siswa dengan nama mengandung 'Badu':
";
    foreach ($students as $student) {
        echo "ID: " . $student->id . "
";
        echo "Nama: " . $student->name . "
";
        echo "NIS: " . $student->adm_no . "
";
        echo "Photo: " . $student->photo . "
";
        echo "Photo empty: " . (empty($student->photo) ? 'Ya' : 'Tidak') . "
";
        echo "Photo null: " . (is_null($student->photo) ? 'Ya' : 'Tidak') . "
";
        echo "------------------------
";
    }
} else {
    echo "Tidak ditemukan siswa dengan nama mengandung 'Badu'
";
}

// Check all students with missing or invalid photos
echo "
Mencari siswa dengan foto yang bermasalah...
";
$problematicStudents = Capsule::table('users as u')
    ->join('student_records as sr', 'u.id', '=', 'sr.user_id')
    ->select('u.name', 'u.photo', 'sr.adm_no')
    ->where(function($query) {
        $query->whereNull('u.photo')
              ->orWhere('u.photo', '=', '')
              ->orWhere('u.photo', 'NOT LIKE', 'http%');
    })
    ->get();

echo "Ditemukan " . $problematicStudents->count() . " siswa dengan foto yang bermasalah:
";
foreach ($problematicStudents as $student) {
    echo "- " . $student->name . " (" . $student->adm_no . "): " . ($student->photo ?: 'NULL') . "
";
}
?>
