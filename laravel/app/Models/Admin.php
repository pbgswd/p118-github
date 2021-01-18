<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Model
{
    use HasRoles;
    // nothing here but there could be, such as some overall stats or activity about the website to present.
}
