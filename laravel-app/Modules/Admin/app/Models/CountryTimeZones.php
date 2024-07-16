<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\CountryTimeZonesFactory;

class CountryTimeZones extends Model
{
    use HasFactory;

    protected $table = 'country_time_zones';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): CountryTimeZonesFactory
    {
        //return CountryTimeZonesFactory::new();
    }
}
