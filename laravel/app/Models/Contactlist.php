<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contactlist extends Model
{
    use HasFactory;

    protected $table = 'contactlist';

    protected $fillable = [
        'title',
        'street1',
        'street2',
        'city',
        'province',
        'postal_code',
        'country',
        'phone',
        'email',
        'website',
        'notes',
        'access_level',
        'live',
        'contact',
    ];

}
