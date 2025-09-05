<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Helpers\Mk;
use App\Http\Requests\Student\StudentRecordCreate;
use App\Http\Requests\Student\StudentRecordUpdate;
use App\Repositories\LocationRepo;
use App\Repositories\MyClassRepo;
use App\Repositories\StudentRepo;
use App\Repositories\UserRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentRecordController extends Controller
{
    protected $loc, $my_class, $user, $student;

   public function __construct(LocationRepo $loc, MyClassRepo $my_class, UserRepo $user, StudentRepo $student)
   {
       $this->middleware('teamSA', ['only' => ['edit','update', 'reset_pass', 'graduated'] ]);
       $this->middleware('teamSAT', ['only' => ['create', 'store'] ]);
       $this->middleware('super_admin', ['only' => ['destroy',] ]);

        $this->loc = $loc;
        $this->my_class = $my_class;
        $this->user = $user;
        $this->student = $student;
   }

    public function reset_pass($st_id)
    {
        $st_id = Qs::decodeHash($st_id);
        $data['password'] = Hash::make('student');
        $this->user->update($st_id, $data);
        return back()->with('flash_success', __('msg.p_reset'));
    }

    public function index(Request $request)
    {
        $data['my_classes'] = $this->my_class->all();
        $data['classes'] = $this->my_class->all();
        $data['parents'] = $this->user->getUserByType('parent');
        $data['dorms'] = $this->student->getAllDorms();
        $data['states'] = $this->loc->getStates();
        $data['nationals'] = $this->loc->getAllNationals();
        
        // Get all students or filter by class
        $class_id = $request->get('class_id');
        if ($class_id) {
            $data['all_students'] = $this->student->findStudentsByClass($class_id);
        } else {
            $data['all_students'] = $this->student->getAll()->with(['my_class', 'section', 'user'])->get()->unique('user_id')->values()->sortBy('user.name');
        }
        
        return view('pages.support_team.students.index', $data);
    }

    public function create()
    {
        $data['my_classes'] = $this->my_class->all();
        $data['parents'] = $this->user->getUserByType('parent');
        $data['dorms'] = $this->student->getAllDorms();
        $data['states'] = $this->loc->getStates();
        $data['nationals'] = $this->loc->getAllNationals();
        return view('pages.support_team.students.add', $data);
    }

    public function store(StudentRecordCreate $req)
    {
       $data =  $req->only(Qs::getUserRecord());
       $sr =  $req->only(Qs::getStudentData());

        $ct = $this->my_class->findTypeByClass($req->my_class_id)->code;
       /* $ct = ($ct == 'J') ? 'JSS' : $ct;
        $ct = ($ct == 'S') ? 'SS' : $ct;*/

        $data['user_type'] = 'student';
        $data['name'] = ucwords($req->name);
        $data['code'] = strtoupper(Str::random(10));
        $data['password'] = Hash::make('student');
        $data['photo'] = Qs::getDefaultUserImage();
        $adm_no = $req->adm_no;
        $data['username'] = strtoupper(Qs::getAppCode().'/'.$ct.'/'.$sr['year_admitted'].'/'.($adm_no ?: mt_rand(1000, 99999)));

        if($req->hasFile('photo')) {
            $photo = $req->file('photo');
            $f = Qs::getFileMetaData($photo);
            $f['name'] = 'photo.' . $f['ext'];
            $f['path'] = $photo->storeAs(Qs::getUploadPath('student').$data['code'], $f['name']);
            $data['photo'] = asset('storage/' . $f['path']);
        }

        $user = $this->user->create($data); // Create User

        $sr['adm_no'] = $data['username'];
        $sr['user_id'] = $user->id;
        $sr['session'] = Qs::getSetting('current_session');

        $this->student->createRecord($sr); // Create Student
        return Qs::jsonStoreOk();
    }

    public function listByClass($class_id)
    {
        $data['my_class'] = $mc = $this->my_class->getMC(['id' => $class_id])->first();
        $data['students'] = $this->student->findStudentsByClass($class_id);
        $data['sections'] = $this->my_class->getClassSections($class_id);

        return is_null($mc) ? Qs::goWithDanger('students.index', 'Class not found') : view('pages.support_team.students.list', $data);
    }

    public function graduated()
    {
        $data['my_classes'] = $this->my_class->all();
        $data['students'] = $this->student->allGradStudents();

        return view('pages.support_team.students.graduated', $data);
    }

    public function not_graduated($sr_id)
    {
        $d['grad'] = 0;
        $d['grad_date'] = NULL;
        $d['session'] = Qs::getSetting('current_session');
        $this->student->updateRecord($sr_id, $d);

        return back()->with('flash_success', __('msg.update_ok'));
    }

    public function show($sr_id)
    {
        $sr_id = Qs::decodeHash($sr_id);
        if(!$sr_id){return Qs::goWithDanger();}

        $data['sr'] = $this->student->getRecord(['id' => $sr_id])->first();

        /* Prevent Other Students/Parents from viewing Profile of others */
        if(Auth::user()->id != $data['sr']->user_id && !Qs::userIsTeamSAT() && !Qs::userIsMyChild($data['sr']->user_id, Auth::user()->id)){
            return redirect(route('dashboard'))->with('pop_error', __('msg.denied'));
        }

        return view('pages.support_team.students.show', $data);
    }

    public function edit($sr_id)
    {
        $sr_id = Qs::decodeHash($sr_id);
        if(!$sr_id){return Qs::goWithDanger();}

        $data['sr'] = $this->student->getRecord(['id' => $sr_id])->first();
        $data['my_classes'] = $this->my_class->all();
        $data['parents'] = $this->user->getUserByType('parent');
        $data['dorms'] = $this->student->getAllDorms();
        $data['states'] = $this->loc->getStates();
        $data['nationals'] = $this->loc->getAllNationals();
        return view('pages.support_team.students.edit', $data);
    }

    public function update(StudentRecordUpdate $req, $sr_id)
    {
        $sr_id = Qs::decodeHash($sr_id);
        if(!$sr_id){return Qs::goWithDanger();}

        $sr = $this->student->getRecord(['id' => $sr_id])->first();
        $d =  $req->only(Qs::getUserRecord());
        $d['name'] = ucwords($req->name);

        if($req->hasFile('photo')) {
            $photo = $req->file('photo');
            $f = Qs::getFileMetaData($photo);
            $f['name'] = 'photo.' . $f['ext'];
            $f['path'] = $photo->storeAs(Qs::getUploadPath('student').$sr->user->code, $f['name']);
            $d['photo'] = asset('storage/' . $f['path']);
        }

        $this->user->update($sr->user->id, $d); // Update User Details

        $srec = $req->only(Qs::getStudentData());

        $this->student->updateRecord($sr_id, $srec); // Update St Rec

        /*** If Class/Section is Changed in Same Year, Delete Marks/ExamRecord of Previous Class/Section ****/
        Mk::deleteOldRecord($sr->user->id, $srec['my_class_id']);

        return Qs::jsonUpdateOk();
    }

    public function destroy($st_id)
    {
        $st_id = Qs::decodeHash($st_id);
        if(!$st_id){return Qs::goWithDanger();}

        $sr = $this->student->getRecord(['user_id' => $st_id])->first();
        $path = Qs::getUploadPath('student').$sr->user->code;
        Storage::exists($path) ? Storage::deleteDirectory($path) : false;
        $this->user->delete($sr->user->id);

        return back()->with('flash_success', __('msg.del_ok'));
    }

    public function import(Request $request)
    {
        // Validasi file
        $request->validate([
            'excel_file' => 'required|mimes:csv,txt|max:2048',
            'class_id' => 'required|exists:my_classes,id'
        ]);

        // Cek apakah file berhasil diupload
        if ($request->hasFile('excel_file')) {
            $file = $request->file('excel_file');
            
            // Simpan file sementara
            $path = $file->getRealPath();
            
            // Baca file CSV
            $data = array_map('str_getcsv', file($path));
            
            // Hapus header
            $header = array_shift($data);
            
            // Dapatkan kelas yang dipilih
            $class = $this->my_class->find($request->class_id);
            if (!$class) {
                return back()->with('flash_danger', 'Selected class not found.');
            }
            
            // Proses data siswa
            $importedCount = 0;
            $errors = [];
            
            foreach ($data as $row) {
                // Validasi data minimum - hanya butuh nama
                if (empty($row[0])) { // Jika nama kosong, lewati
                    continue;
                }
                
                try {
                    // Untuk template sederhana, kita hanya membutuhkan nama
                    $name = $row[0];
                    
                    // Dapatkan bagian pertama untuk kelas
                    $section = $class->section()->first();
                    if (!$section) {
                        $errors[] = "No section found for class: {$class->name}";
                        continue;
                    }

                    // Buat data user
                    $userData = [
                        'name' => ucwords($name),
                        'user_type' => 'student',
                        'code' => strtoupper(Str::random(10)),
                        'password' => Hash::make('student'),
                        'photo' => Qs::getDefaultUserImage()
                    ];

                    // Buat user
                    $user = $this->user->create($userData);

                    // Buat data record siswa
                    $studentData = [
                        'user_id' => $user->id,
                        'my_class_id' => $class->id,
                        'section_id' => $section->id,
                        'year_admitted' => date('Y'),
                        'adm_no' => strtoupper(Qs::getAppCode() . '/' . date('Y') . '/' . mt_rand(1000, 9999)),
                        'session' => Qs::getSetting('current_session')
                    ];

                    // Buat record siswa
                    $this->student->createRecord($studentData);
                    $importedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Error importing row: " . $e->getMessage();
                }
            }
            
            $message = "Successfully imported {$importedCount} students.";
            if (!empty($errors)) {
                $message .= " Errors: " . implode(', ', $errors);
                return back()->with('flash_warning', $message);
            }
            
            return back()->with('flash_success', $message);
        }
        
        return back()->with('flash_danger', 'No file uploaded.');
    }

    public function downloadTemplate()
    {
        try {
            $path = public_path('templates/student_template.csv');
            
            \Log::info('Attempting to download template from: ' . $path);
            \Log::info('File exists: ' . (file_exists($path) ? 'true' : 'false'));
            
            if (!file_exists($path)) {
                \Log::error('Template file not found at: ' . $path);
                return back()->with('flash_danger', 'Template file not found.');
            }
            
            $headers = [
                'Content-Type' => 'text/csv',
            ];
            
            return response()->download($path, 'student_template.csv', $headers);
        } catch (\Exception $e) {
            \Log::error('Error downloading template: ' . $e->getMessage());
            return back()->with('flash_danger', 'Error downloading template: ' . $e->getMessage());
        }
    }

    public function importManual(Request $request)
    {
        // Validate input
        $request->validate([
            'student_names' => 'required|string',
            'class_id' => 'required|exists:my_classes,id'
        ]);

        // Get class information
        $class = $this->my_class->find($request->class_id);
        if (!$class) {
            return back()->with('flash_danger', 'Selected class not found.');
        }

        // Split student names by line
        $names = array_filter(array_map('trim', explode("\n", $request->student_names)));
        
        if (empty($names)) {
            return back()->with('flash_danger', 'Please enter at least one student name.');
        }

        $importedCount = 0;
        $errors = [];

        foreach ($names as $name) {
            if (empty($name)) {
                continue;
            }

            try {
                // Get first available section for the class
                $section = $class->section()->first();
                if (!$section) {
                    $errors[] = "No section found for class: {$class->name}";
                    continue;
                }

                // Create user data
                $ct = $class->class_type->code ?? 'GEN';
                $data['user_type'] = 'student';
                $data['name'] = ucwords($name);
                $data['code'] = strtoupper(Str::random(10));
                $data['password'] = Hash::make('student');
                $data['photo'] = Qs::getDefaultUserImage();
                $data['username'] = strtoupper(Qs::getAppCode().'/'.$ct.'/'.date('Y').'/'.mt_rand(1000, 99999));

                // Create user
                $user = $this->user->create($data);

                // Create student record
                $sr['adm_no'] = $data['username'];
                $sr['user_id'] = $user->id;
                $sr['session'] = Qs::getSetting('current_session');
                $sr['my_class_id'] = $request->class_id;
                $sr['section_id'] = $section->id;
                $sr['year_admitted'] = date('Y');

                $this->student->createRecord($sr);
                $importedCount++;
            } catch (\Exception $e) {
                $errors[] = "Error importing {$name}: " . $e->getMessage();
                \Log::error("Error importing student {$name}: " . $e->getMessage());
            }
        }

        $message = "Successfully added {$importedCount} student(s) to {$class->name}.";
        if (!empty($errors)) {
            $message .= " Errors: " . implode(', ', $errors);
            return back()->with('flash_warning', $message);
        }

        return back()->with('flash_success', $message);
    }

}
