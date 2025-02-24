<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmenitiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('amenities')->delete();
        $amenities = '[{"name":"Air conditioner","value":"air_conditioner","icon":"misterbnb\/amenities\/Air_conditioner.svg"},{"name":"Alexa","value":"alexa","icon":"misterbnb\/amenities\/Alexa.svg"},{"name":"App","value":"app","icon":"misterbnb\/amenities\/App.svg"},{"name":"Bathtub","value":"bathtub","icon":"misterbnb\/amenities\/Bathtub.svg"},{"name":"Camera","value":"camera","icon":"misterbnb\/amenities\/Camera.svg"},{"name":"Cctv","value":"cctv","icon":"misterbnb\/amenities\/Cctv.svg"},{"name":"Cloud","value":"cloud","icon":"misterbnb\/amenities\/Cloud.svg"},{"name":"Coffee maker","value":"coffee_maker","icon":"misterbnb\/amenities\/Coffee_maker.svg"},{"name":"Communications","value":"communications","icon":"misterbnb\/amenities\/Communications.svg"},{"name":"Curtain","value":"curtain","icon":"misterbnb\/amenities\/Curtain.svg"},{"name":"Dial","value":"dial","icon":"misterbnb\/amenities\/Dial.svg"},{"name":"Dishwasher","value":"dishwasher","icon":"misterbnb\/amenities\/Dishwasher.svg"},{"name":"Door knob","value":"door_knob","icon":"misterbnb\/amenities\/Door_knob.svg"},{"name":"Door","value":"door","icon":"misterbnb\/amenities\/Door.svg"},{"name":"Eco friendly","value":"eco_friendly","icon":"misterbnb\/amenities\/Eco_friendly.svg"},{"name":"Electricity","value":"electricity","icon":"misterbnb\/amenities\/Electricity.svg"},{"name":"Fan","value":"fan","icon":"misterbnb\/amenities\/Fan.svg"},{"name":"Faucet","value":"faucet","icon":"misterbnb\/amenities\/Faucet.svg"},{"name":"Fire alarm","value":"fire_alarm","icon":"misterbnb\/amenities\/Fire_alarm.svg"},{"name":"Garage","value":"garage","icon":"misterbnb\/amenities\/Garage.svg"},{"name":"Garbage","value":"garbage","icon":"misterbnb\/amenities\/Garbage.svg"},{"name":"Gate","value":"gate","icon":"misterbnb\/amenities\/Gate.svg"},{"name":"Home theater","value":"home_theater","icon":"misterbnb\/amenities\/Home_theater.svg"},{"name":"Illumination","value":"illumination","icon":"misterbnb\/amenities\/Illumination.svg"},{"name":"Intercom","value":"intercom","icon":"misterbnb\/amenities\/Intercom.svg"},{"name":"Key card","value":"key_card","icon":"misterbnb\/amenities\/Key_card.svg"},{"name":"Lamp","value":"lamp","icon":"misterbnb\/amenities\/Lamp.svg"},{"name":"Lock","value":"lock","icon":"misterbnb\/amenities\/Lock.svg"},{"name":"Low battery","value":"low_battery","icon":"misterbnb\/amenities\/Low_battery.svg"},{"name":"Maps","value":"maps","icon":"misterbnb\/amenities\/Maps.svg"},{"name":"Off","value":"off","icon":"misterbnb\/amenities\/Off.svg"},{"name":"On","value":"on","icon":"misterbnb\/amenities\/On.svg"},{"name":"Password","value":"password","icon":"misterbnb\/amenities\/Password.svg"},{"name":"Plant","value":"plant","icon":"misterbnb\/amenities\/Plant.svg"},{"name":"Plug","value":"plug","icon":"misterbnb\/amenities\/Plug.svg"},{"name":"Power socket","value":"power_socket","icon":"misterbnb\/amenities\/Power_socket.svg"},{"name":"Power supply","value":"power_supply","icon":"misterbnb\/amenities\/Power_supply.svg"},{"name":"Power","value":"power","icon":"misterbnb\/amenities\/Power.svg"},{"name":"Projector","value":"projector","icon":"misterbnb\/amenities\/Projector.svg"},{"name":"Protect","value":"protect","icon":"misterbnb\/amenities\/Protect.svg"},{"name":"Refrigerator","value":"refrigerator","icon":"misterbnb\/amenities\/Refrigerator.svg"},{"name":"Remote","value":"remote","icon":"misterbnb\/amenities\/Remote.svg"},{"name":"Robot vacuum","value":"robot_vacuum","icon":"misterbnb\/amenities\/Robot_vacuum.svg"},{"name":"Room heater","value":"room_heater","icon":"misterbnb\/amenities\/Room_heater.svg"},{"name":"Router","value":"router","icon":"misterbnb\/amenities\/Router.svg"},{"name":"Safe box","value":"safe_box","icon":"misterbnb\/amenities\/Safe_box.svg"},{"name":"Save water","value":"save_water","icon":"misterbnb\/amenities\/Save_water.svg"},{"name":"Setting","value":"setting","icon":"misterbnb\/amenities\/Setting.svg"},{"name":"Signal","value":"signal","icon":"misterbnb\/amenities\/Signal.svg"},{"name":"Sink","value":"sink","icon":"misterbnb\/amenities\/Sink.svg"},{"name":"Smart home","value":"smart_home","icon":"misterbnb\/amenities\/Smart_home.svg"},{"name":"Smart lock","value":"smart_lock","icon":"misterbnb\/amenities\/Smart_lock.svg"},{"name":"Smart tv","value":"smart_tv","icon":"misterbnb\/amenities\/Smart_tv.svg"},{"name":"Smartphone","value":"smartphone","icon":"misterbnb\/amenities\/Smartphone.svg"},{"name":"Smartwatch","value":"smartwatch","icon":"misterbnb\/amenities\/Smartwatch.svg"},{"name":"Smoke detector","value":"smoke_detector","icon":"misterbnb\/amenities\/Smoke_detector.svg"},{"name":"Socket","value":"socket","icon":"misterbnb\/amenities\/Socket.svg"},{"name":"Solar panel","value":"solar_panel","icon":"misterbnb\/amenities\/Solar_panel.svg"},{"name":"Speaker","value":"speaker","icon":"misterbnb\/amenities\/Speaker.svg"},{"name":"Sprinkle","value":"sprinkle","icon":"misterbnb\/amenities\/Sprinkle.svg"},{"name":"Stove","value":"stove","icon":"misterbnb\/amenities\/Stove.svg"},{"name":"Switch","value":"switch","icon":"misterbnb\/amenities\/Switch.svg"},{"name":"Temperature","value":"temperature","icon":"misterbnb\/amenities\/Temperature.svg"},{"name":"Toilet","value":"toilet","icon":"misterbnb\/amenities\/Toilet.svg"},{"name":"Touch screen","value":"touch_screen","icon":"misterbnb\/amenities\/Touch_screen.svg"},{"name":"Trash","value":"trash","icon":"misterbnb\/amenities\/Trash.svg"},{"name":"View","value":"view","icon":"misterbnb\/amenities\/View.svg"},{"name":"Washing machine","value":"washing_machine","icon":"misterbnb\/amenities\/Washing_machine.svg"},{"name":"Water dispenser","value":"water_dispenser","icon":"misterbnb\/amenities\/Water_dispenser.svg"}]';
        DB::table('amenities')->insert(json_decode($amenities, true));


    }
}
