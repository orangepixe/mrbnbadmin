<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [

        ];
        $this->command->info('Seeding a sample payment method...');
        PaymentMethod::insert([
            'label' => 'Cryptocurrency',
            'description' => 'Pay with your favorite cryptocurrency',
            'instructions' => 'Wallet address: b680210c-d27e-4931-8724-692508f139bc',
            'gateway' => 'crypto',
            'logo' => 'https://res.cloudinary.com/dxhg3kkia/image/upload/v1/misterbnb/bitcoin-logo.svg',
            'user_id' => 1,
            'created_at' => '2025-02-08 11:04:56',
            'updated_at' => '2025-02-08 11:04:56',
        ]);
        PaymentMethod::insert([
            'label' => 'Cryptocurrency',
            'description' => 'Pay with your favorite cryptocurrency',
            'instructions' => 'Wallet address: b680210c-d27e-4931-8724-692508f139bc',
            'gateway' => 'crypto',
            'logo' => 'https://res.cloudinary.com/dxhg3kkia/image/upload/v1/misterbnb/bitcoin-logo.svg',
            'user_id' => 2,
            'created_at' => '2025-02-08 11:04:56',
            'updated_at' => '2025-02-08 11:04:56',
        ]);
        $this->command->info('Done seeding payment method!');
        $this->command->info('===========================================');
    }
}
