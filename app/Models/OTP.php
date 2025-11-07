<?php

namespace App\Models;

use Database\Factories\OTPFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OTP extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'email',
        'token',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
        ];
    }

    /**
     * Return the instance of the model's corresponding factory
     *
     * @return OTPFactory
     */
    protected static function newFactory(): OTPFactory
    {
        return OTPFactory::new();
    }
}
