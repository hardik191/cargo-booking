<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('system_setting')->truncate();

        DB::table('system_setting')->insert([
            'key' => "general_setting",
            'value' => json_encode([
                '_token' => '6WshWQMFO0P82oP6HovhuVue1D2EQDFnBldgWoRD',
                'system_name' => 'Cargo Booking',
                'footer_text' => 'Cargo Booking 2025',
                'footer_link' => 'https://cargo-booking.com/',
                'sidebar_navbar_name' => 'Admin Panel',
                'user_sidebar_navbar_name' => 'Customer Panel',
                'key' => 'general_setting'
            ]),
            'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d h:i:s'),
        ]);
        
        DB::table('system_setting')->insert([
            'key' => "branding",
            'value' => json_encode([
                '_token' => 'tEXzYp7ny9S28j69RKZNLjAjOSlMdkTBOqH1sjP2',
                'primary_color' => '#3341ff',
                'primary_color_text' => '#ffffff',
                'key' => 'branding',
                'secondary_color' => '#000000',
                'secondary_color_text' => '#ffffff',
                'tertiary_color' => '#000000',
                'tertiary_color_text' => '#ffffff',
                'table_color' => '#70bcff',
                'table_color_text' => '#000000',
                'card_color' => '#d1d1d1',
                'card_color_text' => '#000000',
                'sidebar_color' => '#000000',
                'sidebar_menu_font_color' => '#e5e1e1',
                'sidebar_active_color' => '#1949f9',
                'sidebar_active_font_color' => '#ffffff',
                'hover_color' => '#f566ff',
                'hover_font_color' => '#000000',
                'favicon_icon' => null,
                'avatar_remove' => null,
                'login_icon' => null,
                'favicon_icon_name' => 'favicon_icon1720092836.jpg',
                'login_icon_name' => 'login_icon1720092836.jpg'
            ]),
            'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d h:i:s'),
        ]);
        // DB::table('system_setting')->insert([
        //     'key' => "email_setting",
        //     'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d h:i:s'),
        // ]);
        // DB::table('system_setting')->insert([
        //     'key' => "sms_whatsapp_setting",
        //     'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d h:i:s'),
        // ]);

    }
}
