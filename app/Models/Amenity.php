<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Amenity extends Model
{
    //protected $hidden = ['id', 'icon', 'created_at', 'updated_at'];
    protected $fillable = [
        'name',
        'value',
        'icon',
    ];

    protected $appends = ['logo'];

    public function getLogoAttribute()
    {
        return Storage::url($this->icon);
    }
}
