<?php

namespace App\Http\Controllers\SupportTeam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BackupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get list of backup files
        $backups = [];
        
        if (File::exists(storage_path('app/backups'))) {
            $files = File::files(storage_path('app/backups'));
            foreach ($files as $file) {
                $backups[] = [
                    'name' => $file->getFilename(),
                    'size' => $file->getSize(),
                    'modified' => $file->getMTime(),
                ];
            }
        }
        
        return view('backup.index', compact('backups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Create backup directory if it doesn't exist
            if (!File::exists(storage_path('app/backups'))) {
                File::makeDirectory(storage_path('app/backups'), 0755, true);
            }
            
            // Create custom database backup
            $filename = 'backup-' . date('Y-m-d-H-i-s') . '.sql';
            $filepath = storage_path('app/backups/' . $filename);
            
            // Generate SQL dump
            $this->createDatabaseBackup($filepath);
            
            return back()->with('flash_success', 'Backup created successfully!');
        } catch (\Exception $e) {
            Log::error('Backup creation failed: ' . $e->getMessage());
            return back()->with('flash_danger', 'Failed to create backup: ' . $e->getMessage());
        }
    }

    /**
     * Import a database backup.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        try {
            // Validate the file
            $request->validate([
                'backup_file' => 'required|file|mimes:sql|max:10240' // Max 10MB
            ]);

            // Get the uploaded file
            $file = $request->file('backup_file');
            
            // Store the file temporarily
            $filepath = $file->getRealPath();
            
            // Read the SQL file
            $sql = file_get_contents($filepath);
            
            // Split the SQL file into individual statements
            $statements = array_filter(array_map('trim', explode(';', $sql)));
            
            // Execute each statement
            foreach ($statements as $statement) {
                if (!empty($statement)) {
                    DB::unprepared($statement);
                }
            }
            
            return back()->with('flash_success', 'Backup imported successfully!');
        } catch (\Exception $e) {
            Log::error('Backup import failed: ' . $e->getMessage());
            return back()->with('flash_danger', 'Failed to import backup: ' . $e->getMessage());
        }
    }

    /**
     * Create a custom database backup.
     *
     * @param string $filepath
     * @return void
     */
    private function createDatabaseBackup($filepath)
    {
        // Get database configuration
        $host = env('DB_HOST', 'localhost');
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        
        // Simple approach: Export important tables
        $tables = [
            'users', 'my_classes', 'sections', 'student_records', 'subjects', 
            'class_types', 'exams', 'marks', 'settings', 'dorms'
        ];
        
        $sql = "-- Database Backup\n";
        $sql .= "-- Generated on " . date('Y-m-d H:i:s') . "\n\n";
        
        foreach ($tables as $table) {
            if (DB::getSchemaBuilder()->hasTable($table)) {
                $sql .= "\n-- Table structure for table `{$table}`\n";
                $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
                
                // Get table creation statement
                $createTable = DB::select("SHOW CREATE TABLE `{$table}`");
                if (!empty($createTable)) {
                    $sql .= $createTable[0]->{'Create Table'} . ";\n\n";
                }
                
                // Get table data
                $rows = DB::table($table)->get();
                if ($rows->count() > 0) {
                    $sql .= "-- Dumping data for table `{$table}`\n";
                    foreach ($rows as $row) {
                        $values = [];
                        foreach ($row as $value) {
                            $values[] = is_null($value) ? 'NULL' : "'" . addslashes($value) . "'";
                        }
                        $sql .= "INSERT INTO `{$table}` VALUES (" . implode(', ', $values) . ");\n";
                    }
                    $sql .= "\n";
                }
            }
        }
        
        // Write to file
        File::put($filepath, $sql);
    }

    /**
     * Download the specified backup file.
     *
     * @param  string  $filename
     * @return \Illuminate\Http\Response
     */
    public function download($filename)
    {
        $path = storage_path('app/backups/' . $filename);
        
        if (!File::exists($path)) {
            return back()->with('flash_danger', 'Backup file not found!');
        }
        
        return response()->download($path);
    }

    /**
     * Remove the specified backup file from storage.
     *
     * @param  string  $filename
     * @return \Illuminate\Http\Response
     */
    public function destroy($filename)
    {
        $path = storage_path('app/backups/' . $filename);
        
        if (File::exists($path)) {
            File::delete($path);
            return back()->with('flash_success', 'Backup deleted successfully!');
        }
        
        return back()->with('flash_danger', 'Backup file not found!');
    }
}