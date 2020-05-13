<?php

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use Illuminate\Database\Seeder;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Create Roles
        Role::create([
            'id' => config('access.roles.admin'),
            'name' => 'Administrator',
        ]);

        Role::create([
            'id' => config('access.roles.default'),
            'name' => 'Member',
        ]);

        // Non Grouped Permissions
        Permission::create([
            'name' => 'view backend',
            'description' => 'Access Administration',
        ]);

        Permission::create([
            'name' => 'dashboard',
            'description' => 'Dashboard',
            'sort' => 2,
        ]);

        // Access master category
        $access = Permission::create([
            'name' => 'access.*',
            'description' => 'Access',
        ]);

        // Users category
        Permission::create([
            'parent_id' => $access->id,
            'name' => 'access.users.*',
            'description' => 'All Users',
        ])->children()->saveMany([
            new Permission([
                'name' => 'access.users.read',
                'description' => 'View Users',
            ]),
            new Permission([
                'name' => 'access.users.create',
                'description' => 'Create Users',
                'sort' => 2,
            ]),
            new Permission([
                'name' => 'access.users.update',
                'description' => 'Update Users',
                'sort' => 3,
            ]),
            new Permission([
                'name' => 'access.users.delete',
                'description' => 'Delete Users',
                'sort' => 4,
            ]),
        ]);

        // Roles category
        Permission::create([
            'parent_id' => $access->id,
            'name' => 'access.roles.*',
            'description' => 'All Roles',
            'sort' => 2,
        ])->children()->saveMany([
            new Permission([
                'name' => 'access.roles.read',
                'description' => 'View Roles',
            ]),
            new Permission([
                'name' => 'access.roles.create',
                'description' => 'Create Roles',
                'sort' => 2,
            ]),
            new Permission([
                'name' => 'access.roles.update',
                'description' => 'Update Roles',
                'sort' => 3,
            ]),
            new Permission([
                'name' => 'access.roles.delete',
                'description' => 'Delete Roles',
                'sort' => 4,
            ]),
        ]);

        // Assign Permissions to other Roles
        // Note: Admin (User 1) Has all permissions via a gate in the AuthServiceProvider
        // $user->givePermissionTo('view backend');

        $this->enableForeignKeys();
    }
}
