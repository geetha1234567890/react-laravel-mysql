<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateStructure extends Model
{
    use HasFactory;

    protected $table = 'template_structures';

    protected $fillable = [
        'template_id', 'module_name', 'activity_name', 'due_date', 
        'link_activity', 'points', 'prerequisites', 'after_due_date', 
        'is_active', 'created_by', 'updated_by'
    ];

    public function coachingTemplate()
    {
        return $this->belongsTo(CoachingTemplate::class, 'template_id', 'id');
    }
}
