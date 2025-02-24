<?php

namespace App\Models;

use App\Models\Scopes\MultipleScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Host extends Model
{
    protected $appends = ['host_reviews', 'date', 'photo'];
    //protected $hidden = ['id', 'user_id', 'created_at', 'updated_at', 'avatar'];

    protected $fillable = [
        'name',
        'about',
        'avatar',
        'reviews',
        'superhost',
        'url',
        'user_id',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'superhost' => 'boolean',
            'reviews' => 'array',
        ];
    }

    public function getDateAttribute()
    {
        return $this->created_at->format('F Y');
    }

    public function getPhotoAttribute()
    {
        return $this->avatar != null ? Storage::url($this->avatar) : "https://i.pravatar.cc/150?img=1" . $this->id;
    }

    public function getHostReviewsAttribute()
    {
        if($this->reviews != null && count($this->reviews)) {
            return Review::find($this->reviews);
        }

    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
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
}
