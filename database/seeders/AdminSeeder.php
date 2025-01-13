<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super admin']);
        // Create a superadmin user and assign role
        $superAdmin = Admin::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@admin.com',
            'password' => bcrypt('Master@1234'),
        ]);
        $superAdmin->assignRole($superAdminRole);
    }
}
