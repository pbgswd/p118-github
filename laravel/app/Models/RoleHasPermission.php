<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleHasPermission extends Model
{
   protected $table = 'role_has_permissions';

   public function permissions(){
       return $this->has(Permission::class);
   }
}
