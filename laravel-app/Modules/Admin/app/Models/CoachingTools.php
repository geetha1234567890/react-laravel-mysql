<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\CoachingToolsFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoachingTools extends Model
{
    
    use HasFactory, SoftDeletes;

    protected $table = 'coaching_tools';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'is_active',
    ];

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

    public function assignments()
    {
        return $this->hasMany(CoachingToolAssignment::class, 'coaching_tool_id', 'id');
    }
}
