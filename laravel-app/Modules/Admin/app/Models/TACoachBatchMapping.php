<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\TACoachBatchMappingFactory;


class TACoachBatchMapping extends Model
{
    use HasFactory;
    
    protected $table = 'ta_coach_batch_mappings';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'admin_user_id',
        'batch_id',
        'student_id',
        'is_active',
        'is_deleted',
        'created_by',
        'updated_by'
    ];

    // Define relationships
    public function AdminUsers()
    {
        return $this->belongsTo(AdminUsers::class, 'admin_user_id');
    }
    
    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(AdminUsers::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(AdminUsers::class, 'updated_by');
    }
}
