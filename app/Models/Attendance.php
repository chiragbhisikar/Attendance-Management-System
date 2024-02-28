<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function student()
    {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }

    public function lecture()
    {
        return $this->hasOne(Lecture::class, 'id', 'lecture_id');
    }
}
