<?php

namespace App\Models;

use App\Models\User;
use App\Models\Property;
use App\Models\Scopes\MultipleScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guest extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'password_text',
        'phone',
        'address',
        'country',
        'user_id',
        'property_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new MultipleScope);
    }
}
