<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('ports')->truncate();

        $ports = [
            ['port_name' => 'Cochin Port', 'location' => 'Southwest coast of India'],
            ['port_name' => 'Mundra Port', 'location' => 'Gujarat'],
            ['port_name' => 'Syama Prasad Mookerjee Port', 'location' => 'Kolkata'],
            ['port_name' => 'Jawaharlal Nehru Port', 'location' => 'Navi Mumbai'],
            ['port_name' => 'Deendayal Port', 'location' => 'Kandla'],
            ['port_name' => 'Mormugao Port', 'location' => 'Goa'],
            ['port_name' => 'Mumbai Port', 'location' => 'Maharashtra'],
            ['port_name' => 'Chennai Port', 'location' => 'Tamil Nadu'],
            ['port_name' => 'Mangalore Port', 'location' => 'Karnataka'],
            ['port_name' => 'Visakhapatnam Port', 'location' => 'East coast'],
            ['port_name' => 'Paradip Port', 'location' => 'East coast'],
            ['port_name' => 'Tuticorin Port', 'location' => 'East coast'],
            ['port_name' => 'Ennore Port', 'location' => 'East coast'],
        ];

        $timestamp = Carbon::now();
        $userId = 1; // Assuming user ID 1 is the admin or default user

        foreach ($ports as &$port) {
            $port['status'] = 1; // Active
            $port['add_by'] = $userId;
            $port['updated_by'] = $userId;
            $port['created_at'] = $timestamp;
            $port['updated_at'] = $timestamp;
        }

        DB::table('ports')->insert($ports);
    }
}
