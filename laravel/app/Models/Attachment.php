<?php

namespace App\Models;

use App\Policies\PagePolicy;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property int $id
 * @property string $name
 * @property string $extension
 * @property User $users
 * @property \DateTime created_at
 * @property \DateTime updated_at
 */

class Attachment extends Model
{
    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'extension',
    ];

    protected $dates = [
            'created_at',
            'updated_at'
        ];

    /**
     * relationships
     */
    // relationship to users table

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    // page

    // post

    // topic

    // member

}
