<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\LeavesFactory;

class Leaves extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'admin_user_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'approve_status',
        'leave_type',
        'message',
    ];


    /**
     * Define the relationship for the admin user.
     */
    public function adminUser()
    {
        return $this->belongsTo(AdminUsers::class, 'admin_user_id', 'id');
    }


}
