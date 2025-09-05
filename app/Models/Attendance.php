<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'my_class_id',
        'date',
        'status',
        'remark',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function myClass()
    {
        return $this->belongsTo(MyClass::class, 'my_class_id');
    }
}