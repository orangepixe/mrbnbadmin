<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('users')->delete();

        DB::table('users')->insert([
            'name' => 'System Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => '2025-02-08 11:04:56',
            'password' => '$2y$12$nj94vXsNBBlTkUpGBzAvyuuMr4GWYUnpjXUEFfLRTcY833869LXoi',
            'avatar' => 'misterbnb/avatars/_profile.jpg',
            'admin' => 1,
            'custom_fields' => '{"clone_url":"https://misterbnb.com","expires_at":"2100-12-31 00:00:00"}',
            'remember_token' => 'gh4e1N0Djp',
            'created_at' => '2025-02-08 11:04:56',
            'updated_at' => '2025-02-08 11:04:56',
        ]);
        DB::table('users')->insert([
            'name' => 'Demo User',
            'email' => 'demo@gmail.com',
            'email_verified_at' => '2025-02-08 11:04:56',
            'password' => Hash::make('demo'),
            'avatar' => 'misterbnb/avatars/_profile.jpg',
            'admin' => 0,
            'custom_fields' => '{"clone_url":"https://misterbnb.com","expires_at":"2100-12-31 00:00:00"}',
            'remember_token' => 'gh4e1N0Djp',
            'created_at' => '2025-02-08 11:04:56',
            'updated_at' => '2025-02-08 11:04:56',
        ]);
    }
}
