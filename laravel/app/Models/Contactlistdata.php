<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contactlistdata extends Model
{
    use HasFactory;

    protected $table = 'contactlistdata';

    protected $fillable = [
        'name',
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
