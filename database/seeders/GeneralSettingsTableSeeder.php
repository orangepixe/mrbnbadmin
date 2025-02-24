<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneralSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('general_settings')->delete();

        DB::table('general_settings')->insert([
            'site_name' => 'mrbnb',
            'site_description' => 'Mrb&b admin area',
            'theme_color' => '#1d2538',
            'support_email' => 'admin@gmail.com',
            'support_phone' => '+447512233345',
            'google_analytics_id' => 'UA-123456789-1',
            'posthog_html_snippet' => '<script src=\'https://app.posthog.com/123456789.js\'></script>',
            'seo_title' => 'mrbnb',
            'seo_keywords' => 'Mrb&b admin area',
            'seo_metadata' => '[]',
            'email_settings' => '{"default_email_provider":"smtp","smtp_host":"mail.example.com","smtp_port":"587","smtp_encryption":"ssl","smtp_timeout":"30","smtp_username":"username","smtp_password":"password","mailgun_domain":null,"mailgun_secret":null,"mailgun_endpoint":null,"postmark_token":null,"amazon_ses_key":null,"amazon_ses_secret":null,"amazon_ses_region":null}',
            'email_from_address' => 'mailfrom@gmail.com',
            'email_from_name' => 'Mailfrom',
            'social_network' => '{"whatsapp":"https:\\/\\/whatsapp.com\\/40716623341","facebook":"https:\\/\\/facebook.com\\/mrbnb","instagram":"https:\\/\\/instagram.com\\/mrbnb","x_twitter":"https:\\/\\/x.com\\/mrbnb","youtube":"https:\\/\\/youtube.com\\/mrbnb","linkedin":"https:\\/\\/linkedin.com\\/mrbnb","tiktok":"https:\\/\\/tiktok.com\\/mrbnb","pinterest":"https:\\/\\/pinterest.com\\/mrbnb"}',
            'more_configs' => NULL,
            'site_logo' => 'assets/site_logo.png',
            'site_favicon' => 'assets/site_favicon.ico',
            'created_at' => '2025-02-08 11:04:56',
            'updated_at' => '2025-02-08 11:04:56',
        ]);


    }
}
