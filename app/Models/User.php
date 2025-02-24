<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Filament\Panel;
use App\Models\Guest;
use App\Models\Property;
use App\Models\Scopes\MultipleScope;
use Illuminate\Support\Facades\Storage;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use phpDocumentor\Reflection\Types\Boolean;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'admin',
        'password',
        'custom_fields'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'admin' => 'boolean',
            'custom_fields' => 'array',
            'custom_fields.expires_at' => 'array'
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * Check if the user has expired.
     *
     * @return string
     */
    public function getExpiredAttribute(): bool
    {
        if(isset($this->custom_fields['expires_at']))
            $parsed = Carbon::parse($this->custom_fields['expires_at']);
        else
            $parsed = Carbon::now();

        return $parsed->isPast();
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar ? Storage::url("$this->avatar") : null;
    }

    public function getFilamentName(): string
    {
        return $this->first_name;
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope(new MultipleScope);
    // }
}
