<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property boolean $live
 * @property User $users
 * @property \DateTime created_at
 * @property \DateTime updated_at
 */
class Meeting extends Model
{
    use Sortable;
}
