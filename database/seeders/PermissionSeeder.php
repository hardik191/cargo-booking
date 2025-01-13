<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // permissions table

        // Truncate tables
        // DB::table('role_has_permissions')->truncate(); //role_has_permissions table
        DB::table('permissions')->truncate();

        // Re-enable foreign key checks
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;'); //role_has_permissions table

        $sqlFile = database_path('seeder_data/permissions.sql');
        // Read the SQL file content
        $sql = file_get_contents($sqlFile);
        // Execute the SQL queries
        DB::unprepared($sql);

        $superAdminRole = Role::firstOrCreate(['name' => 'super admin']);
        $permissions = Permission::all();
        $superAdminRole->givePermissionTo($permissions);

    }
}
