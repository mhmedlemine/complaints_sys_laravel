<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $adminRole = Role::create(['name' => 'admin']);
        $agentRole = Role::create(['name' => 'agent']);
        $fieldAgentRole = Role::create(['name' => 'fieldagent']);

        $permissions = [
            'manage users',
            'manage roles',
            'manage wilayas',
            'manage moughataas',
            'manage municipalities',
            'manage neighbourhoods',
            'manage consumers',
            'manage merchants',
            'manage entreprises',
            'manage complaints',
            'manage infractions',
            'manage summons',
            'manage fines',
            'app agent',
            'app fieldagent'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $adminRole->givePermissionTo(Permission::all());

        $agentRole->givePermissionTo([
            'app agent',
        ]);

        $fieldAgentRole->givePermissionTo([
            'app fieldagent',
        ]);
    }
}
