<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AccessControl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'access_control';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Show the site's access permissions and roles for users.";


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->listArgumentOptions();
    }


    protected function listArgumentOptions($showPermissions = true, $showRoles = true, $showUsers = true)
    {
        if ($showPermissions)
        {
            $permissionsData = array();
            $permissions = Permission::with('roles')->get(['id', 'name', 'guard_name'])->toArray();
            foreach ($permissions as $key => $perm)
            {
                $roles = Arr::pluck($perm['roles'], 'name');
                $permissionsData[$key] = [$perm['name'], $perm['guard_name'], join(', ', $roles)];
            }
            $this->info("\nPermissions");
            $this->table(['Name', 'Guard Name', 'Roles'], $permissionsData);
        }

        if ($showRoles)
        {
            $rolesData = array();
            $roles = Role::with('users')->get(['id', 'name', 'guard_name'])->toArray();
            foreach ($roles as $key => $role)
            {
                $users = Arr::pluck($role['users'], 'email');
                $rolesData[$key] = [$role['name'],  $role['guard_name'], join(', ', $users) ];
            }
            $this->info("\nRoles");
            $this->table(['Name', 'Guard Name', 'Users'], $rolesData);
        }

        if ($showUsers)
        {
            $usersData = array();
            $users = User::has('roles')->with('roles')->get(['id', 'email'])->toArray();
            foreach ($users as $key => $user)
            {
                $roles = Arr::pluck($user['roles'], 'name');
                $usersData[$key] = [$user['email'], join(', ', $roles)];
            }
            $this->info("\nUsers");
            $this->table(['Email', 'Roles'], $usersData);
        }
    }
}
