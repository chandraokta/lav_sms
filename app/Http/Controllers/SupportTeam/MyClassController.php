<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Http\Requests\MyClass\ClassCreate;
use App\Http\Requests\MyClass\ClassUpdate;
use App\Repositories\MyClassRepo;
use App\Repositories\UserRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyClassController extends Controller
{
    protected $my_class, $user;

    public function __construct(MyClassRepo $my_class, UserRepo $user)
    {
        // Hapus semua middleware pembatas akses
        // Semua guru dianggap sebagai admin/super_admin

        $this->my_class = $my_class;
        $this->user = $user;
    }

    public function index()
    {
        $d['my_classes'] = $this->my_class->all();
        $d['class_types'] = $this->my_class->getTypes();

        return view('pages.support_team.classes.index', $d);
    }

    public function store(ClassCreate $req)
    {
        $data = $req->all();
        // Remove class_type_id if it exists since we're not using it anymore
        unset($data['class_type_id']);
        $mc = $this->my_class->create($data);

        // Create Default Section
        $s =['my_class_id' => $mc->id,
            'name' => 'A',
            'active' => 1,
            'teacher_id' => NULL,
        ];

        $this->my_class->createSection($s);

        return Qs::jsonStoreOk();
    }

    public function edit($id)
    {
        $d['c'] = $c = $this->my_class->find($id);

        return is_null($c) ? Qs::goWithDanger('classes.index') : view('pages.support_team.classes.edit', $d) ;
    }

    public function update(ClassUpdate $req, $id)
    {
        try {
            $data = $req->only(['name']);
            $this->my_class->update($id, $data);

            return Qs::updateOk('classes.index');
        } catch (\Exception $e) {
            return back()->with('flash_danger', 'Error updating class: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            // Cek apakah kelas masih digunakan
            $class = $this->my_class->find($id);
            if (!$class) {
                return back()->with('flash_danger', 'Class not found!');
            }
            
            // HAPUS PAKSA - hapus semua student records terkait dulu
            $studentRecords = $class->student_record;
            foreach ($studentRecords as $record) {
                // Hapus user terkait
                $user = $record->user;
                if ($user) {
                    // Hapus direktori foto jika ada
                    $path = Qs::getUploadPath('student').$user->code;
                    \Storage::exists($path) ? \Storage::deleteDirectory($path) : false;
                    $user->delete();
                }
                // Hapus record student
                $record->delete();
            }
            
            // Hapus semua section terkait
            $sections = $class->section;
            foreach ($sections as $section) {
                $section->delete();
            }
            
            // Hapus kelas
            $this->my_class->delete($id);
            return back()->with('flash_success', __('msg.del_ok'));
        } catch (\Exception $e) {
            return back()->with('flash_danger', 'Error deleting class: ' . $e->getMessage());
        }
    }
    
    public function bulkDestroy(Request $request)
    {
        try {
            $selectedClasses = $request->input('selected_classes', []);
            
            // Debugging - log the received data
            \Log::info('Selected classes for deletion: ' . json_encode($selectedClasses));
            
            if (empty($selectedClasses)) {
                return back()->with('flash_danger', 'No classes selected for deletion.');
            }
            
            $deletedCount = 0;
            $errorMessages = [];
            
            foreach ($selectedClasses as $classId) {
                try {
                    // Pastikan $classId adalah integer
                    $classId = (int) $classId;
                    
                    // Cek apakah kelas masih digunakan
                    $class = $this->my_class->find($classId);
                    if (!$class) {
                        $errorMessages[] = "Class with ID {$classId} not found.";
                        continue;
                    }
                    
                    // HAPUS PAKSA - hapus semua student records terkait dulu
                    $studentRecords = $class->student_record;
                    foreach ($studentRecords as $record) {
                        // Hapus user terkait
                        $user = $record->user;
                        if ($user) {
                            // Hapus direktori foto jika ada
                            $path = Qs::getUploadPath('student').$user->code;
                            \Storage::exists($path) ? \Storage::deleteDirectory($path) : false;
                            $user->delete();
                        }
                        // Hapus record student
                        $record->delete();
                    }
                    
                    // Hapus semua section terkait
                    $sections = $class->section;
                    foreach ($sections as $section) {
                        $section->delete();
                    }
                    
                    $this->my_class->delete($classId);
                    $deletedCount++;
                } catch (\Exception $e) {
                    $errorMessages[] = "Error deleting class with ID {$classId}: " . $e->getMessage();
                }
            }
            
            $message = "Successfully deleted {$deletedCount} class(es).";
            if (!empty($errorMessages)) {
                $message .= " Errors: " . implode(', ', $errorMessages);
                return back()->with('flash_warning', $message);
            }
            
            return redirect()->route('classes.index')->with('flash_success', $message);
        } catch (\Exception $e) {
            return back()->with('flash_danger', 'Error deleting classes: ' . $e->getMessage());
        }
    }

}
