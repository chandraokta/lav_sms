<?php
// Script to delete all classes
// This script should be run from the Laravel environment

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get the MyClass repository
$myClassRepo = App::make(\App\Repositories\MyClassRepo::class);

// Get all classes
$classes = $myClassRepo->all();

echo "Found " . $classes->count() . " classes.\
";

// Delete all classes
foreach ($classes as $class) {
    echo "Processing class: " . $class->name . " (ID: " . $class->id . ")\
";
    
    // Check if class has students
    $studentCount = $class->student_record()->count();
    echo "  Students in class: " . $studentCount . "\
";
    
    if ($studentCount > 0) {
        echo "  Cannot delete class with students. Please remove students first.\
";
        continue;
    }
    
    // Delete sections first
    $sections = $class->section;
    foreach ($sections as $section) {
        echo "    Deleting section: " . $section->name . "\
";
        $section->delete();
    }
    
    // Delete the class
    echo "  Deleting class: " . $class->name . "\
";
    $myClassRepo->delete($class->id);
}

echo "Class cleanup completed.\
";
