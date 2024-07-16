<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\WOLOptionConfigFactory;

class WOLOptionConfig extends Model
{
    use HasFactory;

    protected $table = 'wol_option_configs';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'minimum_scale',
        'maximum_scale',
    ];

    /**
     * Define the relationship for the creator (created_by).
     */
    
    public function GetConfigDetails()
    {
        return $this->hasMany(WOLOptionConfigScaleWise::class, 'wol_option_id');
    }
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
}
