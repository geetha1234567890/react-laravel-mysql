<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\APIKeyFactory;

class APIKey extends Model
{
    use HasFactory;

    protected $table = "api_keys";
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'key'
    ];
}
