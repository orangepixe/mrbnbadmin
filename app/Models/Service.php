<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Service extends Model
{
    protected $fillable = [
        'label',
        'appname',
        'appurl',
        'website_name',
        'website_logo',
        'user_id',
        'mode'
    ];

    protected $appends = ['logo'];
    protected $casts = [
       'redirect' => 'boolean',
    ];

    public function getLogoAttribute()
    {
        return $this->website_logo ? Storage::url($this->website_logo) : null;
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
