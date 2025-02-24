<?php

namespace App\Models;

use App\Models\Host;
use App\Models\User;
use App\Models\Amenity;
use App\Models\PaymentMethod;
use App\Models\Scopes\MultipleScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Property extends Model
{
    protected $appends = ['host', 'home_reviews', 'payment', 'home_amenities', 'photos', 'expired', 'continent'];
    protected $fillable = [
        'name',
        'description',
        'slug',
        'images',
        'accommodation',
        'rates',
        'amenities',
        'location',
        'host_id',
        'payment_methods',
        'reviews',
        'user_id',
        'service_id',
        'property_url',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'accommodation' => 'array',
            'rates' => 'array',
            'amenities' => 'array',
            'payment_methods' => 'array',
            'images' => 'array',
            'reviews' => 'array',
            'location' => 'array',
            'active' => 'boolean',
            'service_id' => 'integer',
        ];
    }

    public function getContinentAttribute()
    {
        $country = Country::where('name', $this->location['country'])->first();
        return $country->continent->name;
    }
    public function getExpiredAttribute()
    {
        return $this->user->expired;
    }
    public function getPaymentAttribute()
    {
        return PaymentMethod::find($this->payment_methods);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function getHostAttribute()
    {
        return Host::find($this->host_id);
    }

    public function getPhotosAttribute()
    {
        $images = [];
        foreach ($this->images as $image) {
            $images[] = Storage::url($image);
        }

        return $images;
    }
    public function getHomeReviewsAttribute()
    {
        if($this->reviews != null && count($this->reviews)) {
            return Review::find($this->reviews);
        }
    }

    public function getHomeAmenitiesAttribute()
    {
        return Amenity::whereIn('value', $this->amenities)->get();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            static::addGlobalScope('limit-views', function(Builder $builder) {
                $builder->where('user_id', Auth::id());
            });
        }
    }
    // public function payment_methods(): HasMany
    // {
    //     return $this->hasMany(PaymentMethod::class);
    // }

    // public function amenities(): HasMany
    // {
    //     return $this->hasMany(Amenity::class);
    // }
}
