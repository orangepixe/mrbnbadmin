<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Webpatser\Countries\Countries;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // $this->call(GeneralSettingsTableSeeder::class);
        // $this->call(PropertiesTableSeeder::class);
        // $this->call(HostsTableSeeder::class);
        // $this->call(AmenitiesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(ContinentsTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
    }
}
