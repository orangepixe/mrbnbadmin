<?php

use App\Models\Amenity;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Vormkracht10\FilamentMails\Facades\FilamentMails;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/amenities', function () {
//     $imagefiles = Storage::disk('public')->files('amenities');

//     $amenities = [];
//     foreach($imagefiles as $key => $svg) {
//         $name = str_replace('.svg', '', basename($svg));
//         $value = str_replace(' ', '_', strtolower($name));
//         $icon = 'misterbnb/' . str_replace(' ', '_', $svg);
//         $amenities[] = [
//             'name' => $name,
//             'value' => $value,
//             'icon' => $icon,
//         ];
//     }

//     return $amenities;
//     Amenity::insert($amenities);

//     return Amenity::all();
// });

FilamentMails::routes();


