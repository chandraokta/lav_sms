<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\MyClass;
use App\Models\StudentRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function __construct()
    {
        // Allow teachers to access student management pages
        // but restrict create and store methods to administrative users only
        $this->middleware('teamSA', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = MyClass::all();
        return view('pages.teacher.students.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Redirect teachers to the student management page with info
        return redirect()->route('teacher.students.index')
            ->with('flash_info', 'Untuk menambahkan siswa baru, silakan gunakan menu "Tambah Siswa Baru" di halaman manajemen siswa.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Implementation for storing a student
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Show student details
        $student = StudentRecord::with('user', 'my_class')->findOrFail($id);
        return view('pages.teacher.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Redirect teachers to the student management page with info
        return redirect()->route('teacher.students.index')
            ->with('flash_info', 'Untuk mengedit data siswa, silakan gunakan menu "Kelola Siswa" di halaman manajemen siswa.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display a listing of students by class.
     *
     * @param  int  $class_id
     * @return \Illuminate\Http\Response
     */
    public function listByClass($class_id)
    {
        $class = MyClass::findOrFail($class_id);
        $students = StudentRecord::where('my_class_id', $class_id)
            ->with('user')
            ->get();

        return view('pages.teacher.students.list', compact('students', 'class'));
    }
}