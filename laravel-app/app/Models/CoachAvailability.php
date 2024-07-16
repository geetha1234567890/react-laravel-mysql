<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachAvailability extends Model
{
    use HasFactory;

    protected $table = 'coach_availability';

    protected $fillable = [
        'coach_id', 'current_availability', 'calendar', 
        'created_by', 'updated_by'
    ];

    public function coach()
    {
        return $this->belongsTo(TACoach::class, 'coach_id');
    }
}
