<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ActivityLog extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'activity_log';

    public array $sortable = [
        'id',
        'activity',
        'ip_address',
        'user_agent',
        'model',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'activity',
        'ip_address',
        'user_agent',
        'model',
        'created_at',
        'updated_at',
    ];
}
