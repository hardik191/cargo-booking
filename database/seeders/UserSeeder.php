<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $superAdminRole = Role::firstOrCreate(['name' => 'super admin']);
        // Create a superadmin user and assign role
        $superAdmin = User::firstOrCreate([
            'name' => 'Super Admin',
            'email' => 'superadmin@admin.com',
            'phone_no' => null,
            'password' => bcrypt('Master@1234'),
        ]);
        $superAdmin->assignRole($superAdminRole);

        $superAdminRole = Role::firstOrCreate(['name' => 'user']);
        // Create a superadmin user and assign role
        $superAdmin = User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'phone_no' => null,
            'password' => bcrypt('Master@1234'),
        ]);
        $superAdmin->assignRole($superAdminRole);
    }
}
