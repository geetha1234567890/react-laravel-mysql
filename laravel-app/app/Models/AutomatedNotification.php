<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutomatedNotification extends Model
{
    use HasFactory;

    protected $table = 'automated_notifications';

    protected $fillable = [
        'notification_type', 'content', 'recipient', 'message', 'date_sent', 'created_by', 'updated_by'
    ];
}