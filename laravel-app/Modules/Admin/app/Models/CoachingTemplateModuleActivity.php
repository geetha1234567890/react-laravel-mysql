<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoachingTemplateModuleActivity extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'coaching_template_module_activities';

    protected $fillable = [
        'module_id',
        'activity_type_id',
        'activity_url',
        'activity_name',
        'due_date',
        'points',
        'after_due_date',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public function module()
    {
        return $this->belongsTo(CoachingTemplateModule::class, 'module_id','id');
    }

    public function activityType()
    {
        return $this->belongsTo(CoachingTemplateActivityType::class, 'activity_type_id','id');
    }

    public function dependencies()
    {
        return $this->hasMany(CoachTemplActivityDependencies::class, 'activity_id','id');
    }

    public function taCoachSlots()
    {
        return $this->hasOne(TACoachSlots::class, 'activity_id','id');
    }
}
