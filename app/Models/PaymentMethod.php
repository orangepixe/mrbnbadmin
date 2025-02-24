<?php

namespace App\Models;
use App\Models\Scopes\MultipleScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PaymentMethod extends Model
{

    //protected $hidden = ['user_id', 'id', 'logo', 'created_at', 'updated_at'];
    protected $fillable = [
        'label',
        'description',
        'instructions',
        'gateway',
        'logo',
        'user_id',
    ];

    protected $appends = ['icon'];
    public function getIconAttribute()
    {
        return Storage::url($this->logo);
    }

    public function user()
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
