<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks before truncating
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate(); // Truncate the users table
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Re-enable foreign key checks

        DB::table('user_details')->truncate(); // Clear user_details table
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $customerRole = Role::firstOrCreate(['name' => 'Customer']);
        $logisticsManagerRole = Role::firstOrCreate(['name' => 'Logistics Manager']);
        $cargoCoordinatorRole = Role::firstOrCreate(['name' => 'Cargo Coordinator']);
        $warehouseManagerRole = Role::firstOrCreate(['name' => 'Warehouse/Storage Manager']);

        // Cargo Booking Officer/Agent
        // Cargo Coordinator
        // Logistics Manager
        // Warehouse/Storage Manager:

        // Create a superadmin user and assign role
        $superAdmin = User::firstOrCreate([
            'name' => 'Super Admin',
            'email' => 'superadmin@admin.com',
            'phone_no' => null,
            'password' => bcrypt('Master@1234'),
        ]);
        $superAdmin->assignRole($superAdminRole);

        $superAdminRole = Role::firstOrCreate(['name' => 'Customer']);
        // Create a superadmin user and assign role
        // Create Customer user
        $customer = User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'country_code' => '91',
            'phone_no' => '1234567890',
            'password' => bcrypt('Master@1234'),
        ]);
        $customer->assignRole($customerRole);
        UserDetail::create([
            'user_id' => $customer->id,
            'user_code' => generateCustomerCode(),
            'add_by' => 1,
            'updated_by' => 1,
        ]);
    }
}



// 1 ) Cargo Booking Officer/Agent:
// Responsible for managing and processing cargo booking requests from clients or customers.
// Ensures that bookings are entered into the system accurately and efficiently.

// 2) Freight Forwarder:
// Acts as an intermediary between the shipper and the carrier.
// Coordinates and arranges the transportation of goods, including cargo booking.

// 3) Cargo Coordinator:
// Manages the flow of goods from the point of origin to the destination.
// Ensures proper documentation and booking for shipment.

// 4) Shipper
// The party that books cargo for transportation, usually the seller or consignor.
// Responsible for providing accurate details about the shipment to the booking agent.

// 5) Carrier Representative:
// Represents the shipping company that will transport the cargo.
// Works with the booking agent to confirm the availability of space and equipment.

// 6) Shipping Line/Carrier:
// The actual company or entity that is responsible for transporting the cargo via sea, air, or land.
// Provides the transport options and finalizes bookings.

// 7)Logistics Manager:
// Oversees the logistics operations, including cargo booking, to ensure timely and cost-effective delivery.
// Coordinates between different departments and external partners.

// 8) Customs Broker:
// Assists in clearing the cargo through customs by ensuring that all regulatory requirements are met.
// Involved in cargo bookings that cross international borders.

// 9) Operations Manager:
// Manages the day-to-day operations of cargo handling and booking, ensuring compliance with internal and external regulations.

// 10 ) Customer Service Representative:
// Handles inquiries from customers regarding booking status, shipping schedules, and related information.
// Works closely with the cargo booking team to resolve issues and provide updates.

// 11) Documentation Officer:
// Responsible for preparing and handling all required documentation (e.g., Bill of Lading, shipping instructions).
// Ensures that all required documents are complete for successful booking.

// 12) Warehouse/Storage Manager:
// Manages storage facilities and ensures the cargo is ready for transportation as per the booking arrangement.
// Works closely with the cargo booking team to ensure availability of space.

// 13) Supply Chain Manager:
// Ensures that the cargo booking process is aligned with the overall supply chain strategy.
// Coordinates among multiple stakeholders to optimize the movement of goods.
