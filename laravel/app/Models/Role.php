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
     * belongs to many Permissions
     */

    public function role_has_permissions()
    {
        // return $this->hasMany(RoleHasPermission::class);

        return $this->hasManyThrough('App\Models\RoleHasPermission', 'App\Models\Permission', 'id', 'permission_id', 'id');
    }

    // role has permission on permission
    // hasOne permission_id == id, I want the name column

}


