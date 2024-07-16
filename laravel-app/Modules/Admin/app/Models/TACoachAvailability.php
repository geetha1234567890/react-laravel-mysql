<?php


namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\TaAvailabilityFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class TACoachAvailability extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "ta_coach_availabilities";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "admin_user_id",
        'current_availability',
        'calendar',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected $dates = [
        'calendar', // This attribute will be cast to a Carbon instance
        'created_at', // Automatically handled by Laravel
        'updated_at', // Automatically handled by Laravel
        'deleted_at' // Automatically handled by Laravel (for soft deletes)
    ];

    // Define inverse relationships
    public function adminUser()
    {
        return $this->belongsTo(AdminUsers::class, 'admin_user_id');
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

