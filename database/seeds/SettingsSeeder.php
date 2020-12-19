<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {

        saveSetting('site_name', 'site_name');
        saveSetting('address', 'فلسطين -غزة – دوار أنصار');
        saveSetting('logo', 'logo');
        saveSetting('bannerFile', 'bannerFile');
        saveSetting('adFile', 'adFile');
        saveSetting('occasions', 'occasions');
        saveSetting('about_us_footer', 'about_us_footer');
        saveSetting('facebook', 'facebook');
        saveSetting('twitter', 'twitter');
        saveSetting('instagram', 'instagram');
        saveSetting('youtube', 'youtube');
        saveSetting('linkedin', 'linkedin');
        saveSetting('email', 'creativity.ps.studies@gmail.com');
//        saveSetting('sharing and distributing:', 'creativity.ps.studies@gmail.com');
        saveSetting('phone', '0592888592');
        saveSetting('about_us_image', 'about_us_image');
        saveSetting('footer_long_description', 'footer_long_description');
        saveSetting('facebook_likes', '0');
        saveSetting('twitter_likes', '0');
        saveSetting('youtube_likes', '0');
    }
}
