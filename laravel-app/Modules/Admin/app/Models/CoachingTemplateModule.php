<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoachingTemplateModule extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'coaching_template_modules';

    protected $fillable = [
        'template_id',
        'module_name',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public function template()
    {
        return $this->belongsTo(CoachingTemplate::class, 'template_id','id');
    }

    public function activities()
    {
        return $this->hasMany(CoachingTemplateModuleActivity::class, 'module_id');
    }

    public function prerequisites()
    {
        return $this->hasMany(CoachTemModActPrerequisites::class, 'module_id');
    }
}
