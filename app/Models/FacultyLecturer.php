<?php

namespace App\Models;

use App\Models\Faculty;
use App\Models\TimeTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyLecturer extends Model
{
    use HasFactory;

    protected $fillable = ['time_table_id', 'faculty_id','lab_name'];
    public function faculty()
    {
        return $this->hasOne(Faculty::class, 'id', 'faculty_id');
    }

    public function faculties()
    {
        return $this->hasMany(Faculty::class, 'id', 'faculty_id');
    }

    public function time_table()
    {
        return $this->hasMany(TimeTable::class, 'id', 'time_table_id');
    }

    public function getIsLab()
    {
        return $this->is_lab;
    }
}
