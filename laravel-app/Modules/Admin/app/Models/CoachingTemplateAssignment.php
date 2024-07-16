<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\CoachingTemplateAssignmentFactory;

class CoachingTemplateAssignment extends Model
{
    use HasFactory;

    protected $table = 'coaching_template_assignments';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'template_id',
        'assignable_id',
        'assignable_type'
    ];


    public function assignable()
    {
        return $this->morphTo();
    }

    public function template()
    {
        return $this->belongsTo(CoachingTemplate::class, 'template_id', 'ID');
    }

}
