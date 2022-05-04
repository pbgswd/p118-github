<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Model
{
    use HasRoles;
    use HasFactory;
    // nothing here but there could be, such as some overall stats or activity about the website to present.
}
