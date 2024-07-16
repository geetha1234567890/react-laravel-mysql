<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoachingTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'coaching_templates';

    protected $fillable = [
        'name',
        'duration',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public function modules()
    {
        return $this->hasMany(CoachingTemplateModule::class, 'template_id','id');
    }

    public function coachingTemplateAssignment()
    {
        return $this->hasMany(CoachingTemplateAssignment::class, 'template_id', 'id');
    }
}
