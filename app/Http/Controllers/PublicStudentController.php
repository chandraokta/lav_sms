<?php

namespace App\Http\Controllers;

use App\Repositories\StudentRepo;
use Illuminate\Http\Request;

class PublicStudentController extends Controller
{
    protected $student;

    public function __construct(StudentRepo $student)
    {
        $this->student = $student;
    }

    public function index()
    {
        try {
            // Get all students with their class and section information
            $data['students'] = $this->student->getAll()
                ->with(['my_class', 'section', 'user'])
                ->get()
                ->unique('user_id')
                ->values()
                ->sortBy('user.name');

            return view('pages.public.students.index', $data);
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}