<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('properties', function (Blueprint $table) {
            $accommodation = json_encode([
                'type' => '',
                'size' => '',
                'guests' => 5,
                'minimum' => 3,
                'bedrooms' => 2,
                'bathrooms' => 2,
                'sofas' => 0,
                'beds' => 2,
                'policy' => 'flexible',
                'currency' => 'EUR',
            ]);

            $rates = json_encode([
                'rate' => 2400,
                'deposit' => 600,
                'cleaning' => 0,
                'service' => 14,
                'installments' => 0,
            ]);

            $location = json_encode([
                'address' => '2-4 Av. Octave Gréard, 75007 Paris',
                'city' => 'Paris',
                'state' => 'Île-de-France',
                'zip' => '75007',
                'country' => 'France',
                'continent' => 'Europe',
                'lat' => 48.8588443,
                'lng' => 2.2943506,
            ]);

            $amenities = json_encode([1,2,3,4,5,6,7]);
            $reviews = json_encode([1,2]);

            $table->id()->from(42600500);
            $table->string('slug');
            $table->string('name');
            $table->longText('description');
            $table->longText('images');
            $table->longText('accommodation')->default("{$accommodation}");
            $table->longText('rates')->default("{$rates}");
            $table->longText('amenities')->default("{$amenities}");
            $table->longText('reviews')->default("{$reviews}");
            $table->longText('payment_methods')->default("");
            $table->longText('location')->default("{$location}");
            $table->string('property_url')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('host_id')->constrained()->onDelete('cascade');
            $table->bigInteger('service_id')->unsigned()->nullable();
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->integer('active')->default(1);
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'PropertiesTableSeeder',
            '--force' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
