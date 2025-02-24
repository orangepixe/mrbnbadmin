<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('properties')->delete();

        DB::table('properties')->insert( [
            'name' => 'Amazing view Penthouse - pool and free parking',
            'description' => '<p>This unique place has a style all its own.<br>Sunny and panoramic penthouse offers the most spectacular views of Boka Bay. You can enjoy the stunning blues and greens of the sea and mountains from all the rooms - including the bathroom!<br>If you want to Chill out by the pool, or enjoy your aperitivo on the large terrace, or just read a great book by the windows- and still be mesmerised by the nature - this is the place for you!</p><h2>The space</h2><p>The modern and breezy penthouse has a opens space living room, with a sofa, which expends into a comfortable bed, dining area and kitchen with direct access to the large terrace.<br><br>The bedroom is separate and has the large 180x200 cm king size bed.<br><br>The terrace is equipped with outdoor furniture.</p><h2>Guest access</h2><p>Free and reserved parking spot is available for our guests.<br>The pool is shared with other apartments in the complex.</p><h2>Other things to note</h2><p>The penthouse is situated in a beautiful Mediterranean style complex, on the elevated position, above the Bay, offering the unbeatable views. The penthouse itself is on the top floor of one of the four buildings, meaning that our guests will need to climb stairs to arrive to the penthouse, so please have that in mind when booking. Also please note that the pool is shared with other apartments in the complex.</p>',
            'slug' => 'amazing-view-penthouse-pool-and-free-parking',
            'images' => '["misterbnb\\/01JKF593Z2BCRP3F0CRKXVHHMB.jpg","misterbnb\\/01JKF5HJ2WEXX6EDBPVRRZ1G1D.jpg","misterbnb\\/01JKF5HMFJ1MTD35QVMRKH90HN.jpg","misterbnb\\/01JKF5HPBZT3RRVAHFQYB1RH6J.jpg","misterbnb\\/01JKF5HRAFAKD88VHANMYD15VJ.jpg"]',
            'accommodation' => '{"type":"apartment","size":"60 m\\u00b2","guests":5,"minimum":5,"bedrooms":2,"beds":2,"sofas":0,"bathrooms":1,"policy":"flexible","currency":"EUR"}',
            'rates' => '{"rate":2400,"deposit":600,"cleaning":0,"service":14,"installments":0}',
            'amenities' => '["cctv","bathtub","air_conditioner","coffee_maker","curtains","dishwasher","eco_friendly"]',
            'reviews' => '[1,2]',
            'payment_methods' => '["1"]',
            'location' => '{"address":"2-4 Av. Octave Gr\\u00e9ard, 75007 Paris","city":"Paris","state":"\\u00cele-de-France","zip":"75007","country":"France","lat":48.8588443,"lng":2.2943506}',
            'user_id' => 1,
            'host_id' => 1,
            'active' => 1,
            'service_id' => 3,
            'property_url' => 'https://google.co',
            'created_at' => '2025-02-08 11:04:56',
            'updated_at' => '2025-02-08 11:04:56',
        ]);


        DB::table('properties')->insert([
            'name' => 'Amazing Luxury Penthouse',
            'description' => '<p>This unique place has a style all its own.<br>Sunny and panoramic penthouse offers the most spectacular views of Boka Bay. You can enjoy the stunning blues and greens of the sea and mountains from all the rooms - including the bathroom!<br>If you want to Chill out by the pool, or enjoy your aperitivo on the large terrace, or just read a great book by the windows- and still be mesmerised by the nature - this is the place for you!</p><h2>The space</h2><p>The modern and breezy penthouse has a opens space living room, with a sofa, which expends into a comfortable bed, dining area and kitchen with direct access to the large terrace.<br><br>The bedroom is separate and has the large 180x200 cm king size bed.<br><br>The terrace is equipped with outdoor furniture.</p><h2>Guest access</h2><p>Free and reserved parking spot is available for our guests.<br>The pool is shared with other apartments in the complex.</p><h2>Other things to note</h2><p>The penthouse is situated in a beautiful Mediterranean style complex, on the elevated position, above the Bay, offering the unbeatable views. The penthouse itself is on the top floor of one of the four buildings, meaning that our guests will need to climb stairs to arrive to the penthouse, so please have that in mind when booking. Also please note that the pool is shared with other apartments in the complex.</p>',
            'slug' => 'amazing-luxury-penthouse-1234',
            'images' => '["misterbnb\\/01JKF593Z2BCRP3F0CRKXVHHMB.jpg","misterbnb\\/01JKF5HJ2WEXX6EDBPVRRZ1G1D.jpg","misterbnb\\/01JKF5HMFJ1MTD35QVMRKH90HN.jpg","misterbnb\\/01JKF5HPBZT3RRVAHFQYB1RH6J.jpg","misterbnb\\/01JKF5HRAFAKD88VHANMYD15VJ.jpg"]',
            'accommodation' => '{"type":"apartment","size":"60 m\\u00b2","guests":5,"minimum":5,"bedrooms":2,"beds":2,"sofas":0,"bathrooms":1,"policy":"flexible","currency":"EUR"}',
            'rates' => '{"rate":2400,"deposit":600,"cleaning":0,"service":14,"installments":0}',
            'amenities' => '["cctv","bathtub","air_conditioner","coffee_maker","curtains","dishwasher","eco_friendly"]',
            'reviews' => '[3,4]',
            'payment_methods' => '["2"]',
            'location' => '{"address":"2-4 Av. Octave Gr\\u00e9ard, 75007 Paris","city":"Paris","state":"\\u00cele-de-France","zip":"75007","country":"France","lat":48.8588443,"lng":2.2943506}',
            'user_id' => 2,
            'host_id' => 1,
            'active' => 1,
            'service_id' => 4,
            'property_url' => 'https://google.co',
            'created_at' => '2025-02-08 11:04:56',
            'updated_at' => '2025-02-08 11:04:56',
        ]);
    }
}
