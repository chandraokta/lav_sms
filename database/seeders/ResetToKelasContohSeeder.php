<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResetToKelasContohSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo "Starting reset to 'Kelas Contoh'...\n";
        
        // Get the class type for Primary (or create one if it doesn't exist)
        $classType = DB::table('class_types')->where('name', 'Primary')->first();
        if (!$classType) {
            // If Primary doesn't exist, use the first available class type
            $classType = DB::table('class_types')->first();
        }
        
        if (!$classType) {
            echo "No class types found. Please run ClassTypesTableSeeder first.\n";
            return;
        }
        
        echo "Using class type: " . $classType->name . "\n";
        
        // Get all existing classes
        $existingClasses = DB::table('my_classes')->get();
        echo "Found " . $existingClasses->count() . " existing classes.\n";
        
        // Check if any classes have students
        $classesWithStudents = [];
        foreach ($existingClasses as $class) {
            $studentCount = DB::table('student_records')->where('my_class_id', $class->id)->count();
            if ($studentCount > 0) {
                $classesWithStudents[] = $class;
                echo "Class '" . $class->name . "' has {$studentCount} students and cannot be deleted.\n";
            }
        }
        
        if (!empty($classesWithStudents)) {
            echo "Cannot proceed: Some classes have students. Please remove students first.\n";
            return;
        }
        
        // Delete all sections first to avoid foreign key constraints
        $sectionsDeleted = DB::table('sections')->delete();
        echo "Deleted {$sectionsDeleted} sections.\n";
        
        // Delete all classes
        $classesDeleted = DB::table('my_classes')->delete();
        echo "Deleted {$classesDeleted} classes.\n";
        
        // Create only "Kelas Contoh"
        $kelasContohId = DB::table('my_classes')->insertGetId([
            'name' => 'Kelas Contoh',
            'class_type_id' => $classType->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        echo "Created 'Kelas Contoh' with ID: {$kelasContohId}\n";
        
        // Create sections for Kelas Contoh
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
        echo "Created 2 sections for 'Kelas Contoh'.\n";
        
        echo "Reset completed successfully!\n";
    }
}