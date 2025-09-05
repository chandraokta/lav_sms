<?php

namespace App\Http\Controllers\SupportTeam;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Mark;
use App\Models\MyClass;
use App\Models\StudentRecord;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = MyClass::all();
        return view('laporan.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
     * Display student grade report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function studentReport(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer',
        ]);

        $class_id = $request->class_id;
        $class = MyClass::find($class_id);
        
        // Get students in the class
        $students = StudentRecord::where('my_class_id', $class_id)
            ->with('user')
            ->get();

        // Get all subjects
        $subjects = Subject::all();

        // Get marks for all students
        $marks = Mark::whereHas('user.student_record', function($q) use($class_id) {
                $q->where('my_class_id', $class_id);
            })
            ->with(['user.student_record', 'subject'])
            ->get()
            ->groupBy('user.student_record.id');

        return view('laporan.student', compact('students', 'subjects', 'marks', 'class'));
    }

    /**
     * Print student report card.
     *
     * @param  int  $student_id
     * @return \Illuminate\Http\Response
     */
    public function printReport($student_id)
    {
        $student = StudentRecord::where('user_id', $student_id)
            ->with('user', 'my_class')
            ->first();
            
        // Get marks for the student
        $marks = Mark::where('student_id', $student_id)
            ->with(['subject', 'exam'])
            ->get()
            ->groupBy('exam_id');

        // Get attendance for the student
        $attendances = Attendance::where('student_id', $student_id)
            ->get();

        return view('laporan.print', compact('student', 'marks', 'attendances'));
    }

    /**
     * Display attendance report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function attendanceReport(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer',
        ]);

        $class_id = $request->class_id;
        $month = $request->month;
        $year = $request->year;
        
        $class = MyClass::find($class_id);
        
        // Get students in the class
        $students = StudentRecord::where('my_class_id', $class_id)
            ->with('user')
            ->get();

        // Get attendance records for the specified month and year
        $attendances = Attendance::where('my_class_id', $class_id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->with(['student'])
            ->get()
            ->groupBy('date');

        return view('laporan.attendance', compact('students', 'attendances', 'class', 'month', 'year'));
    }

    /**
     * Download attendance report as CSV.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function downloadAttendanceReport(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer',
        ]);

        $class_id = $request->class_id;
        $month = $request->month;
        $year = $request->year;
        
        $class = MyClass::find($class_id);
        
        // Get students in the class
        $students = StudentRecord::where('my_class_id', $class_id)
            ->with('user')
            ->get();

        // Get attendance records for the specified month and year
        $attendances = Attendance::where('my_class_id', $class_id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->with(['student'])
            ->get()
            ->groupBy('date');

        // Create CSV content
        $csv = "Laporan Kehadiran Kelas {$class->name} - {$month}/{$year}\n";
        $csv .= "Tanggal";

        // Add student names as headers
        foreach ($students as $student) {
            $csv .= ",{$student->user->name}";
        }
        $csv .= "\n";

        // Get all dates in the month
        $start_date = "{$year}-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-01";
        $end_date = date("Y-m-t", strtotime($start_date));
        
        $current_date = $start_date;
        while ($current_date <= $end_date) {
            $csv .= "{$current_date}";
            
            // Add attendance status for each student on this date
            foreach ($students as $student) {
                $attendance_record = $attendances->get($current_date)->firstWhere('student_id', $student->user_id);
                $status = $attendance_record ? $attendance_record->status : '-';
                $csv .= ",{$status}";
            }
            $csv .= "\n";
            $current_date = date("Y-m-d", strtotime("+1 day", strtotime($current_date)));
        }

        // Set headers for download
        $filename = "laporan_kehadiran_{$class->name}_{$month}_{$year}.csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        return response()->make($csv, 200, $headers);
    }

    /**
     * Download student grade report as CSV.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function downloadStudentReport(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer',
        ]);

        $class_id = $request->class_id;
        $class = MyClass::find($class_id);
        
        // Get students in the class
        $students = StudentRecord::where('my_class_id', $class_id)
            ->with('user')
            ->get();

        // Get all subjects
        $subjects = Subject::all();

        // Get marks for all students
        $marks = Mark::whereHas('user.student_record', function($q) use($class_id) {
                $q->where('my_class_id', $class_id);
            })
            ->with(['user.student_record', 'subject'])
            ->get()
            ->groupBy('user.student_record.id');

        // Create CSV content
        $csv = "Laporan Nilai Siswa Kelas {$class->name}\n";
        $csv .= "No,Nama Siswa,NIS";
        
        // Add subject names as headers
        foreach ($subjects as $subject) {
            $csv .= ",{$subject->name}";
        }
        $csv .= "\n";

        // Add student data and marks
        foreach ($students as $student) {
            $csv .= "{$student->id},{$student->user->name},{$student->adm_no}";
            
            // Add marks for each subject
            foreach ($subjects as $subject) {
                $studentMarks = $marks->get($student->id, collect());
                $subjectMark = $studentMarks->firstWhere('subject_id', $subject->id);
                $markValue = $subjectMark ? $subjectMark->exm : '-';
                $csv .= ",{$markValue}";
            }
            $csv .= "\n";
        }

        // Set headers for download
        $filename = "laporan_nilai_{$class->name}.csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        return response()->make($csv, 200, $headers);
    }

    /**
     * Download student report card as PDF.
     *
     * @param  int  $student_id
     * @return \Illuminate\Http\Response
     */
    public function downloadPrintReport($student_id)
    {
        $student = StudentRecord::where('user_id', $student_id)
            ->with('user', 'my_class')
            ->first();
            
        // Get marks for the student
        $marks = Mark::where('student_id', $student_id)
            ->with(['subject', 'exam'])
            ->get()
            ->groupBy('exam_id');

        // Get attendance for the student
        $attendances = Attendance::where('student_id', $student_id)
            ->get();

        // For now, we'll return a CSV version. In a real application, you might want to use a PDF library.
        $csv = "Rapor Siswa\n";
        $csv .= "Nama: {$student->user->name}\n";
        $csv .= "Kelas: {$student->my_class->name}\n";
        $csv .= "NIS: {$student->adm_no}\n\n";
        
        $csv .= "Mata Pelajaran,Nilai\n";
        foreach ($marks as $exam_id => $examMarks) {
            foreach ($examMarks as $mark) {
                $csv .= "{$mark->subject->name},{$mark->exm}\n";
            }
        }

        // Set headers for download
        $filename = "rapor_{$student->user->name}.csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        return response()->make($csv, 200, $headers);
    }
}