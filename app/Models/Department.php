<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function department_type()
    {
        // {{ $subject->department->department_type->department_type_name }}
        return $this->hasOne(DepartmentType::class, 'id', 'department_type_id');
    }
}
