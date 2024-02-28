<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    public function timetable()
    {
        return $this->hasOne(TimeTable::class, 'id', 'time_table_id');
    }
}
