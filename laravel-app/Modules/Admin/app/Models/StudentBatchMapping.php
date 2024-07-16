<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\StudentBatchMappingFactory;

class StudentBatchMapping extends Model
{
    use HasFactory;

    protected $table = 'student_batch_mapping';

    protected $fillable = [
        'student_id',
        'batch_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
}