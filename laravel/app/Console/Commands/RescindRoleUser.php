<?php

namespace App\Console\Commands;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RescindRoleUser extends AccessControl
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:rescind {role_name? : The name of an existing role to rescind.} {email? : The email of an existing user.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rescind a given role from a user.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        if ($this->argument('email') || $this->argument('role_name')) {
            $user = User::where('email', $this->argument('email'))->first();
            $role = Role::where('name', $this->argument('name'))->first();
            if (! $user || ! $role) {
                $this->error('Invalid role name or email.');
            } else {
                $user->removeRole($role);
            }
        }
        $this->listArgumentOptions();
    }
}
