<?php

namespace App\Models;

use App\Models\Property;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $appends = ['cont'];
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function getContAttribute()
    {
        return $this->continent->name;
    }

    public function continent(): BelongsTo
    {
        return $this->belongsTo(Continent::class);
    }
}
