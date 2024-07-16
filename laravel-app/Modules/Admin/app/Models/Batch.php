<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\BatchFactory;

class Batch extends Model
{
    use HasFactory;

    protected $table = 'batches';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'name',
        'parent_id',
        'branch',
        'is_active',
        'batch_type',
        'status'
    ];

    public function parent()
    {
        return $this->belongsTo(Batch::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Batch::class, 'parent_id');
    }

    public function taSchedules()
    {
        return $this->belongsToMany(TACoachScheduling::class, 'ta_coach_batch_scheduling', 'batch_id', 'ta_schedule_id');
    }

    public function studentBatchMappings()
    {
        return $this->hasMany(StudentBatchMapping::class, 'batch_id');
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
