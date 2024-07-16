<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachingTemplate extends Model
{
    use HasFactory;

    protected $table = 'coaching_templates';

    protected $fillable = [
        'template_name', 'duration', 'activities', 'assigned_to', 'status', 
        'is_active','created_by','updated_by'
    ];

    public function templateStructures()
    {
        return $this->hasMany(TemplateStructure::class, 'template_id', 'id');
    }
}