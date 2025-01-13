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
        DB::table('system_setting')->insert([
            'key' => "general_setting",
            'value' => json_encode([
                '_token' => '6WshWQMFO0P82oP6HovhuVue1D2EQDFnBldgWoRD',
                'system_name' => 'Vibrant Coders',
                'footer_text' => 'Vibrant Coders',
                'footer_link' => 'https://vibrantcoders.com/',
                'sidebar_navbar_name' => 'Admin Panel',
                'key' => 'general_setting'
            ]),
            'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d h:i:s'),
        ]);

        DB::table('system_setting')->insert([
            'key' => "branding",
            'value' => json_encode([
                '_token'=>'wIy1oD7YKfxntZB5m6bdUu456Vc3WhVr0jjamat6',
                'primary_color'=>'#000000',
                'primary_color_text'=>'#ffffff',
                'key'=>'branding',
                'secondary_color'=>'#000000',
                'secondary_color_text'=>'#000000',
                'tertiary_color'=>'#000000',
                'tertiary_color_text'=>'#000000',
                'sidebar_color'=>'#000000',
                'sidebar_menu_font_color'=>'#e5e1e1',
                'sidebar_active_color'=>'#4e4646',
                'sidebar_active_font_color'=>'#faf9f9',
                'hover_color'=>'#b798dc',
                'avatar_remove'=>null,
                'favicon_icon_name'=>'favicon_icon1720092836.png',
                'login_icon_name'=>'login_icon1720092836.png',
            ]),
            'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d h:i:s'),
        ]);
        DB::table('system_setting')->insert([
            'key' => "email_setting",
            'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d h:i:s'),
        ]);
        DB::table('system_setting')->insert([
            'key' => "sms_whatsapp_setting",
            'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d h:i:s'),
        ]);

    }
}
