<?php

// Public routes - completely outside of auth middleware
Route::get('/students-public', function() {
    try {
        // Try to get students directly without going through controller
        $students = DB::table('student_records as sr')
            ->join('users as u', 'sr.user_id', '=', 'u.id')
            ->leftJoin('my_classes as mc', 'sr.my_class_id', '=', 'mc.id')
            ->leftJoin('sections as s', 'sr.section_id', '=', 's.id')
            ->select('u.name', 'sr.adm_no', 'mc.name as class_name', 's.name as section_name')
            ->orderBy('u.name')
            ->get();
            
        return view('pages.public.students.public', compact('students'));
    } catch (Exception $e) {
        // If database connection fails, show a simple page
        return view('pages.public.students.public_no_db');
    }
});

Auth::routes();

Route::get('/simple-students', [App\Http\Controllers\SimpleStudentController::class, 'index']);
Route::get('/test', function() {
    return 'Test route is working!';
});

//Route::get('/test', 'TestController@index')->name('test');
Route::get('/privacy-policy', 'HomeController@privacy_policy')->name('privacy_policy');
Route::get('/terms-of-use', 'HomeController@terms_of_use')->name('terms_of_use');


Route::group(['middleware' => 'auth'], function () {

    // Language switch route
    Route::get('lang/{locale}', function ($locale) {
        if (in_array($locale, ['en', 'id'])) {
            session()->put('locale', $locale);
        }
        return redirect()->back();
    })->name('lang.switch');

    Route::get('/', 'HomeController@dashboard')->name('home');
    Route::get('/home', 'HomeController@dashboard')->name('dashboard');
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

    Route::group(['prefix' => 'my_account'], function() {
        Route::get('/', 'MyAccountController@edit_profile')->name('my_account');
        Route::put('/', 'MyAccountController@update_profile')->name('my_account.update');
        Route::put('/change_password', 'MyAccountController@change_pass')->name('my_account.change_pass');
    });

    /*************** Absensi *****************/
    Route::group(['prefix' => 'absensi', 'middleware' => 'teacher'], function(){
        Route::get('/', 'SupportTeam\AttendanceController@index')->name('absensi.rekap');
        Route::get('/create', 'SupportTeam\AttendanceController@create')->name('absensi.create');
        Route::post('/store', 'SupportTeam\AttendanceController@store')->name('absensi.store');
        Route::get('/manage', 'SupportTeam\AttendanceController@manage')->name('absensi.manage');
        Route::post('/manage', 'SupportTeam\AttendanceController@manage')->name('absensi.save');
        Route::get('/show', 'SupportTeam\AttendanceController@show')->name('absensi.show');
        Route::get('/show/export/{class_id}/{date}', 'SupportTeam\AttendanceController@exportDailyAttendance')->name('absensi.show.export');
        Route::get('/class/{class_id}', 'SupportTeam\AttendanceController@classAttendance')->name('absensi.class');
        Route::get('/class/{class_id}/export', 'SupportTeam\AttendanceController@exportClassAttendance')->name('absensi.class.export');
        Route::get('/edit/{class_id}/{date}', 'SupportTeam\AttendanceController@edit')->name('absensi.edit');
        Route::put('/update/{class_id}/{date}', 'SupportTeam\AttendanceController@update')->name('absensi.update');
        Route::get('/recap', 'SupportTeam\AttendanceController@recap')->name('absensi.recap');
        Route::post('/recap/export', 'SupportTeam\AttendanceController@exportRecap')->name('absensi.recap.export');
        Route::post('/recap/update', 'SupportTeam\AttendanceController@updateRecap')->name('absensi.recap.update');
    });

    /*************** Laporan *****************/
    Route::group(['prefix' => 'laporan', 'middleware' => 'teacher'], function(){
        Route::get('/', 'SupportTeam\ReportsController@index')->name('laporan.rekap');
        Route::post('/student', 'SupportTeam\ReportsController@studentReport')->name('laporan.student');
        Route::get('/print/{student_id}', 'SupportTeam\ReportsController@printReport')->name('laporan.print');
        Route::post('/attendance', 'SupportTeam\ReportsController@attendanceReport')->name('laporan.attendance');
        Route::post('/attendance/download', 'SupportTeam\ReportsController@downloadAttendanceReport')->name('laporan.attendance.download');
        Route::post('/student/download', 'SupportTeam\ReportsController@downloadStudentReport')->name('laporan.student.download');
        Route::get('/print/download/{student_id}', 'SupportTeam\ReportsController@downloadPrintReport')->name('laporan.print.download');
    });

    /*************** Backup *****************/
    Route::group(['prefix' => 'backup', 'middleware' => 'teacher'], function(){
        Route::get('/', 'SupportTeam\BackupController@index')->name('backup.index');
        Route::post('/', 'SupportTeam\BackupController@store')->name('backup.store');
        Route::post('/import', 'SupportTeam\BackupController@import')->name('backup.import');
        Route::get('/download/{filename}', 'SupportTeam\BackupController@download')->name('backup.download');
        Route::delete('/{filename}', 'SupportTeam\BackupController@destroy')->name('backup.destroy');
    });

    /*************** Support Team *****************/
    Route::group(['namespace' => 'SupportTeam',], function(){

        /*************** Students *****************/
        Route::group(['prefix' => 'students'], function(){
            Route::get('reset_pass/{st_id}', 'StudentRecordController@reset_pass')->name('st.reset_pass');
            Route::get('graduated', 'StudentRecordController@graduated')->name('students.graduated');
            Route::put('not_graduated/{id}', 'StudentRecordController@not_graduated')->name('st.not_graduated');
            Route::get('list/{class_id}', 'StudentRecordController@listByClass')->name('students.list')->middleware('teamSAT');

            /* Promotions */
            Route::post('promote_selector', 'PromotionController@selector')->name('students.promote_selector');
            Route::get('promotion/manage', 'PromotionController@manage')->name('students.promotion_manage');
            Route::delete('promotion/reset/{pid}', 'PromotionController@reset')->name('students.promotion_reset');
            Route::delete('promotion/reset_all', 'PromotionController@reset_all')->name('students.promotion_reset_all');
            Route::get('promotion/{fc?}/{fs?}/{tc?}/{ts?}', 'PromotionController@promotion')->name('students.promotion');
            Route::post('promote/{fc}/{fs}/{tc}/{ts}', 'PromotionController@promote')->name('students.promote');

        });

        /*************** Users *****************/
        Route::group(['prefix' => 'users'], function(){
            Route::get('reset_pass/{id}', 'UserController@reset_pass')->name('users.reset_pass');
        });

        /*************** TimeTables *****************/
        Route::group(['prefix' => 'timetables'], function(){
            Route::get('/', 'TimeTableController@index')->name('tt.index');

            Route::group(['middleware' => 'teamSA'], function() {
                Route::post('/', 'TimeTableController@store')->name('tt.store');
                Route::put('/{tt}', 'TimeTableController@update')->name('tt.update');
                Route::delete('/{tt}', 'TimeTableController@delete')->name('tt.delete');
            });

            /*************** TimeTable Records *****************/
            Route::group(['prefix' => 'records'], function(){

                Route::group(['middleware' => 'teamSA'], function(){
                    Route::get('manage/{ttr}', 'TimeTableController@manage')->name('ttr.manage');
                    Route::post('/', 'TimeTableController@store_record')->name('ttr.store');
                    Route::get('edit/{ttr}', 'TimeTableController@edit_record')->name('ttr.edit');
                    Route::put('/{ttr}', 'TimeTableController@update_record')->name('ttr.update');
                });

                Route::get('show/{ttr}', 'TimeTableController@show_record')->name('ttr.show');
                Route::get('print/{ttr}', 'TimeTableController@print_record')->name('ttr.print');
                Route::delete('/{ttr}', 'TimeTableController@delete_record')->name('ttr.destroy');

            });

            /*************** Time Slots *****************/
            Route::group(['prefix' => 'time_slots', 'middleware' => 'teamSA'], function(){
                Route::post('/', 'TimeTableController@store_time_slot')->name('ts.store');
                Route::post('/use/{ttr}', 'TimeTableController@use_time_slot')->name('ts.use');
                Route::get('edit/{ts}', 'TimeTableController@edit_time_slot')->name('ts.edit');
                Route::delete('/{ts}', 'TimeTableController@delete_time_slot')->name('ts.destroy');
                Route::put('/{ts}', 'TimeTableController@update_time_slot')->name('ts.update');
            });

        });

        /*************** Payments *****************/
        Route::group(['prefix' => 'payments'], function(){

            Route::get('manage/{class_id?}', 'PaymentController@manage')->name('payments.manage');
            Route::get('invoice/{id}/{year?}', 'PaymentController@invoice')->name('payments.invoice');
            Route::get('receipts/{id}', 'PaymentController@receipts')->name('payments.receipts');
            Route::get('pdf_receipts/{id}', 'PaymentController@pdf_receipts')->name('payments.pdf_receipts');
            Route::post('select_year', 'PaymentController@select_year')->name('payments.select_year');
            Route::post('select_class', 'PaymentController@select_class')->name('payments.select_class');
            Route::delete('reset_record/{id}', 'PaymentController@reset_record')->name('payments.reset_record');
            Route::post('pay_now/{id}', 'PaymentController@pay_now')->name('payments.pay_now');
        });

        /*************** Pins *****************/
        Route::group(['prefix' => 'pins'], function(){
            Route::get('create', 'PinController@create')->name('pins.create');
            Route::get('/', 'PinController@index')->name('pins.index');
            Route::post('/', 'PinController@store')->name('pins.store');
            Route::get('enter/{id}', 'PinController@enter_pin')->name('pins.enter');
            Route::post('verify/{id}', 'PinController@verify')->name('pins.verify');
            Route::delete('/', 'PinController@destroy')->name('pins.destroy');
        });

        /*************** Nilai *****************/
        Route::group(['prefix' => 'nilai', 'middleware' => 'teacher'], function(){
            Route::get('/', 'MarkController@index')->name('nilai.rekap');
            Route::get('manage/{exam}/{class}/{section}/{subject}', 'MarkController@manage')->name('nilai.manage');
            Route::put('update/{exam}/{class}/{section}/{subject}', 'MarkController@update')->name('nilai.update');
            Route::put('comment_update/{exr_id}', 'MarkController@comment_update')->name('nilai.comment_update');
            Route::put('skills_update/{skill}/{exr_id}', 'MarkController@skills_update')->name('nilai.skills_update');
            Route::post('selector', 'MarkController@selector')->name('nilai.selector');
            Route::get('bulk/{class?}/{section?}', 'MarkController@bulk')->name('nilai.create');
            Route::post('bulk', 'MarkController@bulk_select')->name('nilai.bulk_select');
            Route::get('select_year/{id}', 'MarkController@year_selector')->name('nilai.year_selector');
            Route::post('select_year/{id}', 'MarkController@year_selected')->name('nilai.year_select');
            Route::get('show/{id}/{year}', 'MarkController@show')->name('nilai.show');
            Route::get('print/{id}/{exam_id}/{year}', 'MarkController@print_view')->name('nilai.print');
        });

        Route::resource('students', 'StudentRecordController');
        Route::post('students/import', 'StudentRecordController@import')->name('students.import');
        Route::post('students/import_manual', 'StudentRecordController@importManual')->name('students.import_manual');
        Route::get('students/download_template', 'StudentRecordController@downloadTemplate')->name('students.download_template');
        Route::get('download_template_public', function() {
            $path = public_path('templates/student_template.csv');
            if (!file_exists($path)) {
                return back()->with('flash_danger', 'Template file not found.');
            }
            $headers = [
                'Content-Type' => 'text/csv',
            ];
            return response()->download($path, 'student_template.csv', $headers);
        })->name('download_template_public');
        Route::resource('users', 'UserController');
        Route::resource('classes', 'MyClassController');
        Route::delete('classes/bulk_destroy', 'MyClassController@bulkDestroy')->name('classes.bulk_destroy');
        Route::resource('sections', 'SectionController');
        Route::resource('subjects', 'SubjectController');
        Route::resource('grades', 'GradeController');
        Route::resource('exams', 'ExamController');
        Route::resource('dorms', 'DormController');
        Route::resource('payments', 'PaymentController');
        Route::resource('books', 'BookController');
        Route::resource('book_requests', 'BookRequestController');
        Route::resource('sessions', 'SessionController');

    });

    /************************ AJAX ****************************/
    Route::group(['prefix' => 'ajax'], function() {
        Route::get('get_lga/{state_id}', 'AjaxController@get_lga')->name('get_lga');
        Route::get('get_class_sections/{class_id}', 'AjaxController@get_class_sections')->name('get_class_sections');
        Route::get('get_class_subjects/{class_id}', 'AjaxController@get_class_subjects')->name('get_class_subjects');
    });

});

/************************ SUPER ADMIN ****************************/
Route::group(['namespace' => 'SuperAdmin','middleware' => 'super_admin', 'prefix' => 'super_admin'], function(){

    Route::get('/settings', 'SettingController@index')->name('settings');
    Route::put('/settings', 'SettingController@update')->name('settings.update');

});

/************************ PARENT ****************************/
Route::group(['namespace' => 'MyParent','middleware' => 'my_parent',], function(){

    Route::get('/my_children', 'MyController@children')->name('my_children');

});

/************************ LIBRARIAN ****************************/
Route::group(['namespace' => 'SupportTeam', 'middleware' => 'librarian', 'prefix' => 'library'], function(){
    Route::resource('books', 'BookController');
    Route::resource('book_requests', 'BookRequestController');
});

/************************ TEACHER ****************************/
Route::group(['namespace' => 'Teacher', 'middleware' => 'teacher', 'prefix' => 'teacher'], function(){
    Route::resource('students', 'StudentController')->names([
        'index' => 'teacher.students.index',
        'create' => 'teacher.students.create',
        'store' => 'teacher.students.store',
        'show' => 'teacher.students.show',
        'edit' => 'teacher.students.edit',
        'update' => 'teacher.students.update',
        'destroy' => 'teacher.students.destroy'
    ]);
    Route::get('students/list/{class_id}', 'StudentController@listByClass')->name('teacher.students.list');
});
