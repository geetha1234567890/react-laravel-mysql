<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'name', 'student_lms_id', 'email', 'class_id', 'board_id', 'stream_id', 
        'phone', 'primary_phone', 'primary_email', 'is_active',
        'created_by', 'updated_by'
    ];

    public function coachScheduling()
    {
        return $this->hasMany(CoachScheduling::class, 'active_students', 'id');
    }

    public function taScheduling()
    {
        return $this->hasMany(TAScheduling::class, 'active_students', 'id');
    }

    public function coachMapping()
    {
        return $this->hasMany(CoachMapping::class, 'active_students', 'id');
    }

    public function taMapping()
    {
        return $this->hasMany(TAMapping::class, 'active_students', 'id');
    }
    public function activities()
    {
        return $this->hasMany(Activity::class); // Assuming you have an Activity model
    }
}
