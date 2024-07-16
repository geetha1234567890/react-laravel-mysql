<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\WOLTestConfigWithQuestionFactory;

class WOLTestConfigWithQuestion extends Model
{
    use HasFactory;

    protected $table = 'wol_test_config_with_questions';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'wol_category_id',
        'wol_questions_id',
    ];

    public function WOLCategory()
    {
        return $this->hasMany(WOLCategory::class, 'wol_category_id', 'id');
    }
    public function WOLQuestions()
    {
        return $this->hasMany(WOLQuestion::class, 'wol_questions_id', 'id');
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
