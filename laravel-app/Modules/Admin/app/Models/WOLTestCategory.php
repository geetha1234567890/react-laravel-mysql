<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\WOLTestCategoryFactory;

class WOLTestCategory extends Model
{
    use HasFactory;
    protected $table = 'wol_test_categories';
    protected $fillable = ['wol_test_config_id', 'wol_category_id', 'number_of_questions'];

    public function testConfig()
    {
        return $this->belongsTo(WOLTestConfig::class, 'wol_test_config_id');
    }

    public function category()
    {
        return $this->belongsTo(WOLCategory::class, 'wol_category_id');
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
