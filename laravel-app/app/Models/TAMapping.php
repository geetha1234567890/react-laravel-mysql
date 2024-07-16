<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TAMapping extends Model
{
    use HasFactory;

    protected $table = 'ta_mapping';

    protected $fillable = [
        'ta_id', 'active_students', 'active_batches',
        'created_by', 'updated_by'
    ];

    public function taCoach()
    {
        return $this->belongsTo(TACoach::class, 'ta_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'id', 'active_students');
    }

    public function batches()
    {
        return $this->hasMany(BatchCourseMapping::class, 'batch_id', 'active_batches');
    }
}
