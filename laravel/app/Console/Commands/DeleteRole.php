<?php

namespace App\Console\Commands;

use Spatie\Permission\Models\Role;

class DeleteRole extends AccessControl
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:delete {role_name? : The name of the existing role.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete an existing role.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->argument('role_name')) {
            $role = Role::where('name', $this->argument('role_name'))->first();
            if (! $role) {
                $this->error('Invalid role name.');
            } else {
                $role->delete();
            }
        }
        $this->listArgumentOptions(false, true, false);
    }
}
