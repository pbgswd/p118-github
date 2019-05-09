<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Role extends Model
{

    use Sortable;

    public $sortable = [
        'id',
        'name',
        'guard_name',
        'created_at',
        'updated_at',
    ];


    protected $dates =
        [
            'created_at',
            'updated_at'
        ];


    /**************************************************************************
     *
     *  Relationships
     *
     *************************************************************************/

    /**
     * belongs to one Permission
     */

    public function role_has_permissions()
    {
        return $this->belongsToMany('App\Models\RoleHasPermission', 'role_has_permissions',
            'permission_id', 'role_id');
    }

}
