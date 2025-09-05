<?php
// reset_classes.php
// Script to reset classes to only "Kelas Contoh"

// This script needs to be run from the project root directory

// Check if we're in the correct directory
if (!file_exists('artisan')) {
    die("Error: This script must be run from the Laravel project root directory.\n");
}

echo "Resetting classes to 'Kelas Contoh'...\n";

// Run the seeder
echo shell_exec('php artisan db:seed --class=ResetToKelasContohSeeder');

echo "Class reset completed.\n";
