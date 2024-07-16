<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'course_name', 'is_active', 'created_by', 'updated_by'
    ];

    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'batches_course_mapping', 'course_id', 'batch_id');
    }
}
