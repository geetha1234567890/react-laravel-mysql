<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\WOLTestConfigFactory;

class WOLTestConfig extends Model
{
    use HasFactory;

    protected $table = 'wol_test_configs';


    protected $fillable = ['number_of_categories'];

    public function testCategories()
    {
        return $this->hasMany(WOLTestCategory::class, 'wol_test_config_id');
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
