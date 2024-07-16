<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\TACoachBatchSchedulingFactory;

class TACoachBatchScheduling extends Model
{
    use HasFactory;

    protected $table = 'ta_coach_batch_scheduling';

    protected $fillable = [
        'ta_schedule_id', 'batch_id', 'is_active', 'is_deleted',
        'created_by', 'updated_by'
    ];

    public function taCoachScheduling()
    {
        return $this->belongsTo(TACoachScheduling::class, 'ta_schedule_id','id');
    }
}
