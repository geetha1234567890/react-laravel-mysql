<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\WOLQuestionFactory;

class WOLQuestion extends Model
{
    use HasFactory;

    protected $table = 'wol_questions';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'question',
        'wol_category_id',
    ];
    public function WOLTollsCategory()
    {
        return $this->hasMany(WOLCategory::class, 'wol_category_id', 'id');
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
