<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TAAvailability extends Model
{
    use HasFactory;

    protected $table = 'ta_availability';

    protected $fillable = [
        'ta_id', 'current_availability', 'calendar', 
        'created_by','updated_by'
    ];

    public function taCoach()
    {
        return $this->belongsTo(TACoach::class, 'ta_id');
    }
}
