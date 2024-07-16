<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\CallRequestFactory;

class CallRequest extends Model
{
    use HasFactory;

    protected $table = 'call_requests';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'sender_id', 
        'receiver_id', 
        'meeting_link', 
        'meeting_time', 
        'created_by', 
        'updated_by'
    ];

}
