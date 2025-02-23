<?php

namespace Database\Seeders;

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
        $ports = [
            ['name' => 'Cochin Port', 'location' => 'Southwest coast of India'],
            ['name' => 'Mundra Port', 'location' => 'Gujarat'],
            ['name' => 'Syama Prasad Mookerjee Port', 'location' => 'Kolkata'],
            ['name' => 'Jawaharlal Nehru Port', 'location' => 'Navi Mumbai'],
            ['name' => 'Deendayal Port', 'location' => 'Kandla'],
            ['name' => 'Mormugao Port', 'location' => 'Goa'],
            ['name' => 'Mumbai Port', 'location' => 'Maharashtra'],
            ['name' => 'Chennai Port', 'location' => 'Tamil Nadu'],
            ['name' => 'Mangalore Port', 'location' => 'Karnataka'],
            ['name' => 'Visakhapatnam Port', 'location' => 'East coast'],
            ['name' => 'Paradip Port', 'location' => 'East coast'],
            ['name' => 'Tuticorin Port', 'location' => 'East coast'],
            ['name' => 'Ennore Port', 'location' => 'East coast'],
        ];

        DB::table('ports')->insert($ports);
    }
}
