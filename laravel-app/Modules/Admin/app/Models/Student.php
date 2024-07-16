<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\StudentFactory;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'student_lms_id',
        'email',
        'academic_term',
        'class_id',
        'board_id',
        'stream_id',
        'phone',
        'primary_phone',
        'primary_email',
        'is_active',
        'created_by',
        'updated_by'
    ];


    public function taSchedules()
    {
        return $this->belongsToMany(TACoachScheduling::class, 'ta_coach_student_scheduling', 'student_id', 'ta_schedule_id');
    }

    public function studentBatchMappings()
    {
        return $this->hasMany(StudentBatchMapping::class, 'student_id');
    }

    public function templateAssignments()
    {
        return $this->morphMany(TemplateAssignment::class, 'assignable');
    }

    public function coachingToolAssignments()
    {
        return $this->morphMany(CoachingToolAssignment::class, 'assignable');
    }
}
