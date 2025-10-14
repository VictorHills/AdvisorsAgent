<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /**
     * @use HasFactory<UserFactory>
     * */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'bdm_officer_id',
        'first_name',
        'last_name',
        'agency_name',
        'business_registration_number',
        'email',
        'role_name',
        'email_verified_at',
        'password',
        'is_terms_and_condition_accepted',
        'is_active',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
        ];
    }

    // Return the unique identifier for the user
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // Return a key-value array, which will be added to the payload of the JWT
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
