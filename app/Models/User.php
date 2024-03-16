<?php

namespace App\Models;

use App\Casts\Json;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\UserPosition;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'position',
        'password',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'position' => UserPosition::class,
    ];

        /**
     * Checks if a user can access a panel based on their email and email verification status.
     *
     * @param Panel $panel The panel object that the user is trying to access.
     * @return bool Returns a boolean value indicating if the user can access the panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return in_array($this->user_role, ['superAdmin', 'admin']);
        }

        if ($panel->getId() === 'user') {
            return in_array($this->user_role, ['superAdmin', 'admin','customer']);
        }
    }

    /**
     * Get all of the Order for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}
