<?php

namespace App\Console\Commands;


use Spatie\Permission\Models\Permission;

class DeletePermission extends AccessControl
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:delete {permission_name? : The name of the existing permission.}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete an existing permission.';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->argument('permission_name'))
        {
            $perm = Permission::where('name', $this->argument('permission_name'))->first();
            if (!$perm)
            {
                $this->error('Invalid permission name.');
            }
            else
            {
                $perm->delete();
            }
        }
        $this->listArgumentOptions(true, false, false);
    }
}
