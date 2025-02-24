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
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('continents', function (Blueprint $table): void {
            $table->id();
		    $table->string('code', 2)->default('');
		    $table->string('name', 255)->default('');
        });

        Schema::create('countries', function (Blueprint $table): void {
            $table->id();
		    $table->string('code', 2)->default('');
		    $table->string('continent_code', 3)->nullable('');
		    $table->string('name', 255)->default('');
		    $table->string('iso3', 3)->nullable('');
		    $table->string('number', 3)->nullable('');
		    $table->string('full_name', 255)->nullable();
		    $table->string('flag', 6)->nullable();
            $table->bigInteger('continent_id')->unsigned()->nullable();
        });

        Artisan::call('db:seed', [
            '--class' => 'CountryTableSeeder',
            '--force' => true,
        ]);

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('countries', function(): void {
            DB::raw("ALTER TABLE countries MODIFY country_code VARCHAR(3) NOT NULL DEFAULT ''");
            DB::raw("ALTER TABLE countries MODIFY iso_3166_2 VARCHAR(2) NOT NULL DEFAULT ''");
            DB::raw("ALTER TABLE countries MODIFY iso_3166_3 VARCHAR(3) NOT NULL DEFAULT ''");
            DB::raw("ALTER TABLE countries MODIFY region_code VARCHAR(3) NOT NULL DEFAULT ''");
            DB::raw("ALTER TABLE countries MODIFY sub_region_code VARCHAR(3) NOT NULL DEFAULT ''");
        });

		Schema::drop('countries');
	}

};
