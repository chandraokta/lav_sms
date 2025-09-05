<?php

namespace App\Http\Controllers\SupportTeam;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\MyClass;
use App\Models\StudentRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = MyClass::all();
        return view('absensi.rekap', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = MyClass::all();
        return view('absensi.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer',
            'date' => 'required|date',
        ]);

        $class_id = $request->class_id;
        $date = $request->date;

        // Check if attendance already exists for this class and date
        $existing = Attendance::where(['my_class_id' => $class_id, 'date' => $date])->first();
        if ($existing) {
            // If attendance exists, redirect to edit mode with info message
            return redirect()->route('absensi.edit', ['class_id' => $class_id, 'date' => $date])
                ->with('flash_info', 'Attendance records already exist for this class and date. You can edit them below.');
        }

        // Get students in the class
        $students = StudentRecord::where('my_class_id', $class_id)->with('user')->get();

        // Jika tidak ada siswa dalam kelas, kembali ke halaman create
        if ($students->isEmpty()) {
            return back()->with('flash_danger', 'No students found in this class!');
        }

        return view('absensi.manage', compact('students', 'class_id', 'date'));
    }

    /**
     * Show the form for editing existing attendance.
     *
     * @param  int  $class_id
     * @param  string  $date
     * @return \Illuminate\Http\Response
     */
    public function edit($class_id, $date)
    {
        // Get existing attendance records
        $attendances = Attendance::where(['my_class_id' => $class_id, 'date' => $date])->get();
        
        // If no attendance records found, redirect back
        if ($attendances->isEmpty()) {
            return back()->with('flash_danger', 'No attendance records found for this class and date!');
        }

        // Get students in the class
        $students = StudentRecord::where('my_class_id', $class_id)->with('user')->get();

        // Jika tidak ada siswa dalam kelas, kembali ke halaman create
        if ($students->isEmpty()) {
            return back()->with('flash_danger', 'No students found in this class!');
        }

        return view('absensi.edit', compact('students', 'class_id', 'date', 'attendances'));
    }

    /**
     * Update existing attendance records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $class_id
     * @param  string  $date
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $class_id, $date)
    {
        try {
            $request->validate([
                'students' => 'required|array',
            ]);

            $students = $request->students;

            // Update attendance records
            foreach ($students as $student_id => $status) {
                // Find existing record or create new one
                $attendance = Attendance::where([
                    'student_id' => $student_id,
                    'my_class_id' => $class_id,
                    'date' => $date
                ])->first();

                if ($attendance) {
                    // Update existing record
                    $attendance->update(['status' => $status]);
                } else {
                    // Create new record if it doesn't exist
                    Attendance::create([
                        'student_id' => $student_id,
                        'my_class_id' => $class_id,
                        'date' => $date,
                        'status' => $status,
                    ]);
                }
            }

            return redirect()->route('absensi.create')->with('flash_success', 'Attendance records updated successfully!');
        } catch (\Exception $e) {
            return back()->with('flash_danger', 'Error updating attendance records: ' . $e->getMessage());
        }
    }

    /**
     * Store the attendance records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function manage(Request $request)
    {
        try {
            $request->validate([
                'class_id' => 'required|integer',
                'date' => 'required|date',
                'students' => 'required|array',
            ]);

            $class_id = $request->class_id;
            $date = $request->date;
            $students = $request->students;

            // Save attendance records
            foreach ($students as $student_id => $status) {
                Attendance::create([
                    'student_id' => $student_id,
                    'my_class_id' => $class_id,
                    'date' => $date,
                    'status' => $status,
                ]);
            }

            return redirect()->route('absensi.create')->with('flash_success', 'Attendance records saved successfully!');
        } catch (\Exception $e) {
            return back()->with('flash_danger', 'Error saving attendance records: ' . $e->getMessage());
        }
    }

    /**
     * Display attendance records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer',
            'date' => 'required|date',
        ]);

        $class_id = $request->class_id;
        $date = $request->date;

        $attendances = Attendance::where(['my_class_id' => $class_id, 'date' => $date])
            ->with(['student', 'myClass'])
            ->get();

        $class = MyClass::find($class_id);

        return view('absensi.show', compact('attendances', 'class', 'date'));
    }

    /**
     * Export daily attendance as CSV.
     *
     * @param  int  $class_id
     * @param  string  $date
     * @return \Illuminate\Http\Response
     */
    public function exportDailyAttendance($class_id, $date)
    {
        $attendances = Attendance::where(['my_class_id' => $class_id, 'date' => $date])
            ->with(['student', 'myClass'])
            ->get();

        $class = MyClass::find($class_id);

        // Create CSV content
        $csv = "Absensi Harian Kelas {$class->name}\n";
        $csv .= "Tanggal: " . date('d F Y', strtotime($date)) . "\n";
        $csv .= "Exported on: " . date('d F Y H:i:s') . "\n\n";
        
        $csv .= "No,Nama Siswa,NIS,Status\n";

        foreach ($attendances as $attendance) {
            $status = '';
            switch ($attendance->status) {
                case 'H':
                    $status = 'Hadir (H)';
                    break;
                case 'S':
                    $status = 'Sakit (S)';
                    break;
                case 'I':
                    $status = 'Izin (I)';
                    break;
                case 'A':
                    $status = 'Alpa (A)';
                    break;
                default:
                    $status = $attendance->status;
            }
            
            $csv .= "{$attendance->id},{$attendance->student->name},{$attendance->student->student_record->adm_no},{$status}\n";
        }

        // Set headers for download
        $filename = "absensi_harian_{$class->name}_" . date('Ymd', strtotime($date)) . ".csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        return response()->make($csv, 200, $headers);
    }

    /**
     * Display attendance summary/rekap.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function recap(Request $request)
    {
        $classes = MyClass::all();
        
        // If no filters provided, show the filter form
        if (!$request->has('class_id')) {
            return view('absensi.recap_filter', compact('classes'));
        }
        
        $request->validate([
            'class_id' => 'required|integer',
            'period' => 'required|in:daily,weekly,monthly,custom',
            'start_date' => 'required_if:period,custom|date|nullable',
            'end_date' => 'required_if:period,custom|date|after_or_equal:start_date|nullable',
        ]);

        $class_id = $request->class_id;
        $period = $request->period;
        $class = MyClass::find($class_id);
        
        // Determine date range based on period
        $start_date = null;
        $end_date = null;
        
        switch ($period) {
            case 'daily':
                $start_date = $request->start_date ?? date('Y-m-d');
                $end_date = $start_date;
                break;
            case 'weekly':
                $start_date = date('Y-m-d', strtotime('-1 week'));
                $end_date = date('Y-m-d');
                break;
            case 'monthly':
                $start_date = date('Y-m-01');
                $end_date = date('Y-m-t');
                break;
            case 'custom':
                $start_date = $request->start_date;
                $end_date = $request->end_date;
                break;
        }

        // Get attendance records for the date range
        $attendances = Attendance::where('my_class_id', $class_id)
            ->whereBetween('date', [$start_date, $end_date])
            ->with(['student', 'myClass'])
            ->orderBy('date')
            ->get()
            ->groupBy('date');

        // Get all students in the class
        $students = StudentRecord::where('my_class_id', $class_id)
            ->with('user')
            ->get();

        // Calculate attendance summary
        $summary = $this->calculateAttendanceSummary($attendances, $students, $start_date, $end_date);

        return view('absensi.recap', compact('attendances', 'class', 'students', 'summary', 'start_date', 'end_date', 'period'));
    }

    /**
     * Export attendance recap as CSV.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportRecap(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer',
            'period' => 'required|in:daily,weekly,monthly,custom',
            'start_date' => 'required_if:period,custom|date|nullable',
            'end_date' => 'required_if:period,custom|date|after_or_equal:start_date|nullable',
        ]);

        $class_id = $request->class_id;
        $period = $request->period;
        $class = MyClass::find($class_id);
        
        // Determine date range based on period
        $start_date = null;
        $end_date = null;
        
        switch ($period) {
            case 'daily':
                $start_date = $request->start_date ?? date('Y-m-d');
                $end_date = $start_date;
                break;
            case 'weekly':
                $start_date = date('Y-m-d', strtotime('-1 week'));
                $end_date = date('Y-m-d');
                break;
            case 'monthly':
                $start_date = date('Y-m-01');
                $end_date = date('Y-m-t');
                break;
            case 'custom':
                $start_date = $request->start_date;
                $end_date = $request->end_date;
                break;
        }

        // Get attendance records for the date range
        $attendances = Attendance::where('my_class_id', $class_id)
            ->whereBetween('date', [$start_date, $end_date])
            ->with(['student', 'myClass'])
            ->orderBy('date')
            ->get()
            ->groupBy('date');

        // Get all students in the class
        $students = StudentRecord::where('my_class_id', $class_id)
            ->with('user')
            ->get();

        // Create CSV content
        $csv = "Rekap Absensi Kelas {$class->name}\n";
        $csv .= "Periode: ";
        
        switch ($period) {
            case 'daily':
                $csv .= date('d F Y', strtotime($start_date));
                break;
            case 'weekly':
                $csv .= date('d F Y', strtotime($start_date)) . " - " . date('d F Y', strtotime($end_date));
                break;
            case 'monthly':
                $csv .= date('F Y', strtotime($start_date));
                break;
            case 'custom':
                $csv .= date('d F Y', strtotime($start_date)) . " - " . date('d F Y', strtotime($end_date));
                break;
        }
        $csv .= "\n\n";
        
        $csv .= "Tanggal";

        // Add student names as headers
        foreach ($students as $student) {
            $csv .= ",{$student->user->name}";
        }
        $csv .= "\n";

        // Get all dates in the range
        $current_date = $start_date;
        while ($current_date <= $end_date) {
            $csv .= date('d/m/Y', strtotime($current_date));
            
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
        $filename = "rekap_absensi_{$class->name}_" . date('Ymd') . ".csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        return response()->make($csv, 200, $headers);
    }

    /**
     * Calculate attendance summary statistics.
     *
     * @param  \Illuminate\Support\Collection  $attendances
     * @param  \Illuminate\Support\Collection  $students
     * @param  string  $start_date
     * @param  string  $end_date
     * @return array
     */
    private function calculateAttendanceSummary($attendances, $students, $start_date, $end_date)
    {
        $summary = [];
        
        // Initialize summary for each student
        foreach ($students as $student) {
            $summary[$student->user_id] = [
                'student' => $student,
                'total_days' => 0,
                'present' => 0,
                'sick' => 0,
                'leave' => 0,
                'absent' => 0,
                'percentage' => 0
            ];
        }
        
        // Count attendance for each student
        foreach ($attendances as $date => $attendanceRecords) {
            foreach ($attendanceRecords as $attendance) {
                $student_id = $attendance->student_id;
                if (isset($summary[$student_id])) {
                    $summary[$student_id]['total_days']++;
                    switch ($attendance->status) {
                        case 'H':
                            $summary[$student_id]['present']++;
                            break;
                        case 'S':
                            $summary[$student_id]['sick']++;
                            break;
                        case 'I':
                            $summary[$student_id]['leave']++;
                            break;
                        case 'A':
                            $summary[$student_id]['absent']++;
                            break;
                    }
                }
            }
        }
        
        // Calculate percentages
        foreach ($summary as $student_id => $data) {
            if ($data['total_days'] > 0) {
                $summary[$student_id]['percentage'] = round(($data['present'] / $data['total_days']) * 100, 2);
            }
        }
        
        // Sort by percentage (highest first)
        uasort($summary, function($a, $b) {
            return $b['percentage'] <=> $a['percentage'];
        });
        
        return $summary;
    }

    /**
     * Update attendance records in bulk.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateRecap(Request $request)
    {
        $request->validate([
            'attendances' => 'required|array',
        ]);

        try {
            foreach ($request->attendances as $attendance_id => $status) {
                $attendance = Attendance::find($attendance_id);
                if ($attendance) {
                    $attendance->update(['status' => $status]);
                }
            }

            return back()->with('flash_success', 'Attendance records updated successfully!');
        } catch (\Exception $e) {
            return back()->with('flash_danger', 'Error updating attendance records: ' . $e->getMessage());
        }
    }

    /**
     * Show attendance records for a specific class.
     *
     * @param  int  $class_id
     * @return \Illuminate\Http\Response
     */
    public function classAttendance($class_id)
    {
        $attendances = Attendance::where('my_class_id', $class_id)
            ->with(['student', 'myClass'])
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy('date');

        $class = MyClass::find($class_id);

        return view('absensi.class', compact('attendances', 'class'));
    }

    /**
     * Export class attendance as CSV.
     *
     * @param  int  $class_id
     * @return \Illuminate\Http\Response
     */
    public function exportClassAttendance($class_id)
    {
        $attendances = Attendance::where('my_class_id', $class_id)
            ->with(['student', 'myClass'])
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy('date');

        $class = MyClass::find($class_id);

        // Get all students in the class
        $students = StudentRecord::where('my_class_id', $class_id)
            ->with('user')
            ->get();

        // Get all dates
        $dates = $attendances->keys()->sort()->all();

        // Create CSV content
        $csv = "Rekap Absensi Kelas {$class->name}\n";
        $csv .= "Exported on: " . date('d F Y H:i:s') . "\n\n";
        
        $csv .= "Tanggal";

        // Add student names as headers
        foreach ($students as $student) {
            $csv .= ",{$student->user->name}";
        }
        $csv .= "\n";

        // Add attendance data for each date
        foreach ($dates as $date) {
            $csv .= date('d/m/Y', strtotime($date));
            
            // Add attendance status for each student on this date
            foreach ($students as $student) {
                $attendance_record = $attendances->get($date)->firstWhere('student_id', $student->user_id);
                $status = $attendance_record ? $attendance_record->status : '-';
                $csv .= ",{$status}";
            }
            $csv .= "\n";
        }

        // Set headers for download
        $filename = "absensi_kelas_{$class->name}_" . date('Ymd') . ".csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        return response()->make($csv, 200, $headers);
    }
}