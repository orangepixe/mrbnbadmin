<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('services')->delete();

        DB::table('services')->insert([
            'label' => 'Tripadvisor self-hosted #1',
            'appname' => 'tripadvisor',
            'appurl' => 'http://my-trip-reviews/ta-reviews/',
            'mode' => 'review',
            'website_name' => 'Example Inc.',
            'website_logo' => '/misterbnb/logos/emag_logo.png',
            'user_id' => 1,
            'created_at' => '2025-02-09 18:29:55',
            'updated_at' => '2025-02-09 18:29:55',
        ]);

        DB::table('services')->insert([
            'label' => 'Airbnb Booking #1',
            'appname' => 'tripadvisor',
            'user_id' => 1,
            'appurl' => 'http://my-airbnbclone/ta-reviews/',
            'mode' => 'booking',
            'created_at' => '2025-02-09 18:29:55',
            'updated_at' => '2025-02-09 18:29:55',
        ]);

        DB::table('services')->insert([
            'label' => 'Longterm Airbnb #2',
            'appname' => 'tripadvisor',
            'user_id' => 1,
            'appurl' => 'http://my-airbnbclone/ta-reviews/',
            'mode' => 'longterm',
            'created_at' => '2025-02-09 18:29:55',
            'updated_at' => '2025-02-09 18:29:55',
        ]);

        DB::table('services')->insert([
            'label' => 'Tripadvisor self-hosted #2',
            'appname' => 'tripadvisor',
            'appurl' => 'http://my-trip-reviews/ta-reviews/',
            'mode' => 'review',
            'website_name' => 'Example Inc.',
            'website_logo' => '/misterbnb/logos/emag_logo.png',
            'user_id' => 2,
            'created_at' => '2025-02-09 18:29:55',
            'updated_at' => '2025-02-09 18:29:55',
        ]);

        DB::table('services')->insert([
            'label' => 'Airbnb Booking #2',
            'appname' => 'tripadvisor',
            'user_id' => 2,
            'appurl' => 'http://my-airbnbclone/ta-reviews/',
            'mode' => 'booking',
            'created_at' => '2025-02-09 18:29:55',
            'updated_at' => '2025-02-09 18:29:55',
        ]);

        DB::table('services')->insert([
            'label' => 'Longterm Airbnb #3',
            'appname' => 'tripadvisor',
            'user_id' => 2,
            'appurl' => 'http://my-airbnbclone/ta-reviews/',
            'mode' => 'longterm',
            'created_at' => '2025-02-09 18:29:55',
            'updated_at' => '2025-02-09 18:29:55',
        ]);
    }
}
