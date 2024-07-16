<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchCourseMapping extends Model
{
    use HasFactory;

    protected $table = 'batches_course_mapping';

    public $incrementing = false;
    protected $primaryKey = ['batch_id', 'course_id'];

    protected $fillable = [
        'batch_id', 'course_id', 'is_active', 'created_by','updated_by'
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}