<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\WOLOptionConfigScaleWiseFactory;

class WOLOptionConfigScaleWise extends Model
{
    use HasFactory;

    protected $table = 'wol_option_config_scale_wises';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'point',
        'text',
        'image',
        'wol_option_id',
    ];

    public function WOLOptionConfig()
    {
        return $this->hasMany(WOLOptionConfig::class, 'wol_option_id', 'id');
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
}
