<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;
    protected $table = 'faculties';


    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }
}
