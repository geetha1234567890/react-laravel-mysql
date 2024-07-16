<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TACoach extends Model
{
    use HasFactory;

    protected $table = 'ta_coach';

    protected $fillable = [
        'name', 'username', 'password', 'location', 'time_zone', 'gender',
        'date_of_birth', 'highest_qualification', 'profile_picture', 'profile',
        'about_me', 'is_active', 'created_date', 'created_by', 'updated_date', 'updated_by'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function taAvailability()
    {
        return $this->hasOne(TAAvailability::class, 'ta_id');
    }

    public function taScheduling()
    {
        return $this->hasOne(TAScheduling::class, 'ta_id');
    }

    public function taMapping()
    {
        return $this->hasOne(TAMapping::class, 'ta_id');
    }

    public function coachAvailability()
    {
        return $this->hasOne(CoachAvailability::class, 'coach_id');
    }

    public function coachScheduling()
    {
        return $this->hasOne(CoachScheduling::class, 'coach_id');
    }

    public function coachMapping()
    {
        return $this->hasOne(CoachMapping::class, 'coach_id');
    }
}
