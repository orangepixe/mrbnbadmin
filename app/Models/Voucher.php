<?php

namespace App\Models;

use App\Models\Scopes\MultipleScope;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new MultipleScope);
    }
}
