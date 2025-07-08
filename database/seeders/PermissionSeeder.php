<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'create-team', 'update-team', 'delete-team', 'view-team','mange-team-member',

            'create-project', 'update-project', 'delete-project', 'view-project','mange-project-member','read-project',

            'create-task', 'update-task', 'delete-task', 'view-task',

            'add-comment', 'update-comment', 'delete-comment',

            'add-attachment', 'delete-attachment',

            'invite-user', 'remove-user', 'view-users',

            'view-notifications',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
