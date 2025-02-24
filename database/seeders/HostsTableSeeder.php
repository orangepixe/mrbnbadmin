<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HostsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('hosts')->delete();

        DB::table('hosts')->insert([
            'name' => 'Mario',
            'about' => 'It\'s me Mario!',
            'avatar' => NULL,
            'reviews' => '["3","6"]',
            'superhost' => 1,
            'url' => 'https://google.com',
            'user_id' => 1,
            'created_at' => '2025-02-07 02:25:49',
            'updated_at' => '2025-02-07 04:09:29',
        ]);

        DB::table('hosts')->insert([
            'name' => 'Luigi',
            'about' => 'It\'s me Marios brother!',
            'avatar' => NULL,
            'reviews' => '["3","6"]',
            'superhost' => 1,
            'url' => 'https://google.com',
            'user_id' => 2,
            'created_at' => '2025-02-07 02:25:49',
            'updated_at' => '2025-02-07 04:09:29',
        ]);


    }
}
