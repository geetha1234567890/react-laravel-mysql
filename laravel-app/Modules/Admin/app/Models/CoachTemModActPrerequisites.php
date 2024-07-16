<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoachTemModActPrerequisites extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'coach_tem_mod_act_prerequisites';

    protected $fillable = [
        'module_id',
        'activity_id',
        'template_id',
        'lock_until_date',
        'time',
        'is_locked',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public function module()
    {
        return $this->belongsTo(CoachingTemplateModule::class, 'module_id');
    }

    public function activity()
    {
        return $this->belongsTo(CoachingTemplateModuleActivity::class, 'activity_id');
    }

    public function dependencies()
    {
        return $this->hasMany(CoachTemplActivityDependencies::class, 'prerequisite_id');
    }
}
