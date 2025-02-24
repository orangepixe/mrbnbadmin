<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('guests', function (Blueprint $table) {
        //     $password = Str::random(12);
        //     $table->id();
        //     $table->string('first_name');
        //     $table->string('last_name');
        //     $table->string('email')->unique();
        //     $table->string('password')->default(Hash::make($password));
        //     $table->string('password_text')->default($password);
        //     $table->string('phone')->nullable();
        //     $table->string('address')->nullable();
        //     $table->string('country')->nullable();
        //     $table->foreignId('user_id')->constrained()->onDelete('cascade');
        //     $table->foreignId('property_id')->constrained()->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
