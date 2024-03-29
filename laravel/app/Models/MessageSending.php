<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageSending extends Model
{
    use HasFactory;

    protected $table = 'message_sending';

    protected $fillable = [
        'message_id',
        'send_priority',
        'send_status_now',
        'send_status_daily',
        'send_status_weekly',
    ];
}
