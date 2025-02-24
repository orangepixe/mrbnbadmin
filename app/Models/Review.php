<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Review extends Model
{
    protected $fillable = [
        'name',
        'date',
        'subject',
        'content',
        'rating',
        'avatar',
        'type',
        'user_id',
    ];

    //protected $hidden = ['id', 'created_at', 'updated_at'];


    public function scopeProperty(Builder $query): void
    {
        $query->where('type', 'property');
    }

    public function scopeHost(Builder $query): void
    {
        $query->where('type', 'host');
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
