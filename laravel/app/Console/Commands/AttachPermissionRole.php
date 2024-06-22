<?php

namespace App\Console\Commands;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AttachPermissionRole extends AccessControl
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:attach_permission {permission_name? : The name of an existing permission.} {role_name? : The name of an existing role.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attach a given [permission] to an existing [role].';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        if ($this->argument('permission_name') || $this->argument('role_name')) {
            $permission = Permission::where('name', $this->argument('permission_name'))->first();
            $role = Role::where('name', $this->argument('role_name'))->first();
            if (! $permission || ! $role) {
                $this->error('Invalid permission or role name.');
            } else {
                $role->givePermissionTo($permission);
            }
        }
        $this->listArgumentOptions();
    }
}
