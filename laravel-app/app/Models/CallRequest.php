<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallRequest extends Model
{
    use HasFactory;

    protected $table = 'call_requests';

    protected $fillable = [
        'sender_id', 'receiver_id', 'meeting_link', 'meeting_time', 'created_by', 'updated_by'
    ];
}
