<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoachTemplActivityDependencies extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'coach_templ_activity_dependencies';

    protected $fillable = [
        'student_id',
        'activity_id',
        'prerequisite_id',
        'dependency_type',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public function activity()
    {
        return $this->belongsTo(CoachingTemplateModuleActivity::class, 'activity_id');
    }

    public function prerequisite()
    {
        return $this->belongsTo(CoachTemModActPrerequisites::class, 'prerequisite_id');
    }
}
