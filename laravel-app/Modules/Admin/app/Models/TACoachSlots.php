<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\TACoachSlotsFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TACoachSlots extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ta_coach_slots';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'admin_user_id',
        'activity_id',
        'slot_date',
        'from_time',
        'to_time',
        'timezone',
        'series',
        'created_by',
        'updated_by',
    ];

    /**
     * Define the relationship for the parent slot.
     */
    public function parentSlot()
    {
        return $this->belongsTo(TACoachSlots::class, 'series', 'id');
    }

    /**
     * Define the relationship for the child slots.
     */
    public function childSlots()
    {
        return $this->hasMany(TACoachSlots::class, 'series', 'id');
    }

     /**
     * Define the relationship for the admin user.
     */
    public function adminUser()
    {
        return $this->belongsTo(AdminUsers::class, 'admin_user_id', 'id');
    }

    /**
     * Define the relationship for the creator (created_by).
     */
    public function creator()
    {
        return $this->belongsTo(AdminUsers::class, 'created_by', 'id');
    }

    /**
     * Define the relationship for the updater (updated_by).
     */
    public function updater()
    {
        return $this->belongsTo(AdminUsers::class, 'updated_by', 'id');
    }

    public function taCoachScheduling()
    {
        return $this->hasMany(TACoachScheduling::class, 'slot_id', 'id');
    }

    public function coachingTemplateModuleActivity()
    {
        return $this->belongsTo(CoachingTemplateModuleActivity::class, 'activity_id','id');
    }
}
