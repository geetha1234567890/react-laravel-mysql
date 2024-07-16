<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'parent_id',
        'PSIS_Key',
        'node_level',
        'is_active',
        'batch_type',
        'status'
    ];

    public function parent()
    {
        return $this->belongsTo(Batch::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Batch::class, 'parent_id');
    }
}
