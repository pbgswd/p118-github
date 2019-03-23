<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $dates =
        [
            'created_at',
            'updated_at'
        ];

    protected $casts =
        [
            'in_menu'           => 'boolean',
            'allow_comments'    => 'boolean',
            'live'              => 'boolean',
        ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =
        [
            'name',
            'description',
            'content',
            'image',
            'scope',
            'sort_order',
            'live',
            'in_menu',
            'allow_comments',
        ];

}