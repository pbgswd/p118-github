<?php

namespace App\Console\Commands;

use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignRoleUser extends AccessControl
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:assign {role_name? : The name of an existing role to assign.} {email? : The email of an existing user.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign a given role to a user.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if ($this->argument('email') || $this->argument('role_name')) {
            $user = User::where('email', $this->argument('email'))->first();
            $role = Role::where('name', $this->argument('role_name'))->first();
            if (! $user || ! $role) {
                $this->error('Invalid role name or email.');
            } else {
                $user->assignRole($role);
            }
        }
        $this->listArgumentOptions();
    }
}
