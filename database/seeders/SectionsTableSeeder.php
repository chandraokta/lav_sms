<?php
namespace Database\Seeders;

use App\Models\MyClass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sections')->delete();
        $c = MyClass::pluck('id')->all();

        // Only create sections for the first class (Kelas Contoh)
        if (!empty($c)) {
            $data = [
                ['name' => 'A', 'my_class_id' => $c[0], 'active' => 1],
                ['name' => 'B', 'my_class_id' => $c[0], 'active' => 1],
            ];

            DB::table('sections')->insert($data);
        }
    }
}
