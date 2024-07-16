<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\CoachingToolsAssignmentFactory;

class CoachingToolsAssignment extends Model
{
    use HasFactory;

    protected $table = 'coaching_tools_assignments';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'coaching_tool_id',
        'activity_id',
        'assignable_id',
        'assignable_type',
    ];

    public function assignable()
    {
        return $this->morphTo();
    }

    public function coachingTool()
    {
        return $this->belongsTo(CoachingTool::class, 'coaching_tool_id', 'id');
    }
}
