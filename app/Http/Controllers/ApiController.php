<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Property;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index($slug)
    {
        $property = Property::where('slug', $slug)->firstOrFail();
        $home = $property->toArray();
        $home['service'] = $property->service;
        unset($home['service']['created_at']);
        unset($home['service']['created_at']);
        unset($home['service']['updated_at']);
        unset($home['service']['name']);
        unset($home['service']['id']);
        unset($home['service']['user_id']);

        $home['user'] = $property->user;
        $home['location']['continent'] = $home['continent'];
        $home['count'] = $property->homeReviews->count();
        unset($home['id']);
        unset($home['continent']);
        unset($home['user']['admin']);
        unset($home['user']['avatar']);
        unset($home['user']['created_at']);
        unset($home['user']['custom_fields']);
        unset($home['user']['email_verified_at']);
        unset($home['user']['updated_at']);
        unset($home['service_id']);
        unset($home['user_id']);
        unset($home['created_at']);
        unset($home['updated_at']);
        unset($home['amenities']);
        unset($home['reviews']);
        unset($home['images']);
        unset($home['payment_methods']);
        unset($home['host_id']);
        unset($home['host']['id']);
        unset($home['host']['avatar']);
        unset($home['host']['reviews']);
        unset($home['host']['user_id']);
        unset($home['host']['updated_at']);
        unset($home['host']['created_at']);

        if($home['host']['host_reviews'] != null && count($home['host']['host_reviews'])) {


            foreach($home['host']['host_reviews'] as $key => $review) {

                    unset($home['host']['host_reviews'][$key]['type']);
                    unset($home['host']['host_reviews'][$key]['created_at']);
                    unset($home['host']['host_reviews'][$key]['updated_at']);

                    $home['host']['host_reviews'][$key]['content'] = str_replace('#hostname#', $home['host']['name'], $review['content']);
                    $home['host']['host_reviews'][$key]['content'] = str_replace('#propertyname#', $home['name'], $home['host']['host_reviews'][$key]['content']);
            }

            $home['host']['count'] = count($home['host']['host_reviews']);
        }

        if($home['payment'] != null && count($home['payment'])) {
            foreach($home['payment'] as $key => $payment) {

                unset($home['payment'][$key]['created_at']);
                unset($home['payment'][$key]['updated_at']);
                unset($home['payment'][$key]['logo']);
                unset($home['payment'][$key]['user_id']);

            }
        }
        if($home['home_amenities'] != null && count($home['home_amenities'])) {
            foreach($home['home_amenities'] as $key => $amenity) {
                unset($home['home_amenities'][$key]['created_at']);
                unset($home['home_amenities'][$key]['updated_at']);
                unset($home['home_amenities'][$key]['icon']);
            }
        }

        $home['currency'] = Currency::where('code', $home['accommodation']['currency'])->first()->toArray();
        unset($home['currency']['id']);
        unset($home['currency']['created_at']);
        unset($home['currency']['updated_at']);
        unset($home['accommodation']['currency']);
        return response()->json($home);
    }
}
