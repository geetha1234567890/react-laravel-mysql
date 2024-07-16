<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachScheduling extends Model
{
    use HasFactory;

    protected $table = 'coach_scheduling';

    protected $fillable = [
        'coach_id', 'active_students', 'is_active', 'active_batches', 
        'created_by','updated_by'
    ];

    public function coach()
    {
        return $this->belongsTo(TACoach::class, 'coach_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'id', 'active_students');
    }

    public function batches()
    {
        return $this->hasMany(Batch::class, 'id', 'active_batches');
    }
}
