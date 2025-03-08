<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContainersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('containers')->truncate();

        DB::table('containers')->insert([
            [
                'container_type' => '20FT',
                'max_container' => 400,
                'max_capacity' => 28000,
                'capacity_unit' => 1, // Tons
                'base_price' => 1500.00,
                'status' => 1, // Active
                'add_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'container_type' => '40FT',
                'max_container' => 400,
                'max_capacity' => 32000,
                'capacity_unit' => 2, // KG
                'base_price' => 2500.00,
                'status' => 1, // Active
                'add_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'container_type' => '45FT',
                'max_container' => 400,
                'max_capacity' => 36000,
                'capacity_unit' => 2, // Tons
                'base_price' => 3000.00,
                'status' => 1, // Active
                'add_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'container_type' => 'Reefer 20FT',
                'max_container' => 400,
                'max_capacity' => 10000,
                'capacity_unit' => 2, // Tons
                'base_price' => 3500.00,
                'status' => 1,
                'add_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'container_type' => 'Reefer 40FT',
                'max_capacity' => 10000,
                'max_container' => 400,
                'capacity_unit' => 2, // Tons
                'base_price' => 4000.00,
                'status' => 1,
                'add_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
