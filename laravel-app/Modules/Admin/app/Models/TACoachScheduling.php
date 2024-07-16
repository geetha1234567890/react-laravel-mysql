<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\TACoachSchedulingFactory;

class TACoachScheduling extends Model
{
    use HasFactory;

    protected $table = 'ta_coach_scheduling';

    protected $fillable = [
        'admin_user_id', 
        'meeting_name', 
        'meeting_url',
        'date',
        'slot_id',
        'start_time',
        'end_time',
        'time_zone',
        'event_status',
        'is_active',
        'series',
        'created_by',
        'updated_by'
    ];


    public function parentSchedules()
    {
        return $this->belongsTo(TACoachScheduling::class, 'series', 'id');
    }

    /**
     * Define the relationship for the child slots.
     */
    public function childSchedules()
    {
        return $this->hasMany(TACoachScheduling::class, 'series', 'id');
    }

     /**
     * Define the relationship for the admin user.
     */
    public function adminUser()
    {
        return $this->belongsTo(AdminUsers::class, 'admin_user_id', 'id');
    }

    /**
     * Define the relationship for the creator (created_by).
     */
    public function creator()
    {
        return $this->belongsTo(AdminUsers::class, 'created_by', 'id');
    }

    /**
     * Define the relationship for the updater (updated_by).
     */
    public function updater()
    {
        return $this->belongsTo(AdminUsers::class, 'updated_by', 'id');
    }


    public function students()
    {
        return $this->belongsToMany(Student::class, 'ta_coach_student_scheduling', 'ta_schedule_id', 'student_id');
    }

    public function batch()
    {
        return $this->belongsToMany(Batch::class, 'ta_coach_batch_scheduling', 'ta_schedule_id', 'batch_id');
    }

    public function scheduleBatch()
    {
        return $this->hasMany(TACoachBatchScheduling::class, 'ta_schedule_id','id');
    }
    public function scheduleStudent()
    {
        return $this->hasMany(TACoachStudentScheduling::class, 'ta_schedule_id','id');
    }

    

    public function taCoachSlots()
    {
        return $this->belongsTo(TACoachSlots::class, 'slot_id', 'id');
    }
}
