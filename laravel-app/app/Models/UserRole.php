<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $primaryKey = ['user_id', 'role_id'];
    public $incrementing = false;

    protected $fillable = ['user_id', 'role_id'];

    public function user()
    {
        return $this->belongsTo(TACoach::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}