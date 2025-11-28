<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CheckSetup extends Command
{
    protected $signature = 'check:setup';
    protected $description = 'Check if roles and permissions are properly set up';

    public function handle()
    {
        $this->info('Checking role and permission setup...');

        // Check roles
        $roles = Role::all();
        $this->info('Roles found: ' . $roles->count());
        foreach ($roles as $role) {
            $this->line("- {$role->name} with " . $role->permissions->count() . " permissions");
        }

        // Check permissions
        $permissions = Permission::all();
        $this->info('Permissions found: ' . $permissions->count());

        // Check if admin role has all permissions
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $this->info("Admin role has {$adminRole->permissions->count()} permissions");
        }

        $this->info('Setup check completed.');
    }
}
