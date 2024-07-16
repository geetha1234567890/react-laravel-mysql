<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoachingTemplateActivityType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'coaching_template_activity_types';

    protected $fillable = [
        'type_name',
        'is_active',
    ];

    public function activities()
    {
        return $this->hasMany(CoachingTemplateModuleActivity::class, 'activity_type_id','id');
    }
}
