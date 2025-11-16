<?php

namespace App\Models;

use Database\Factories\BusinessDevelopmentOfficersFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessDevelopmentOfficers extends Model
{
    /**
     * @use HasFactory<BusinessDevelopmentOfficersFactory>
     * */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'status',
        'region',
    ];

    /**
     * The attributes that should be mutated to date.
     *
     * @var array
     */
    protected array $dates = [
        'deleted_at'
    ];

    public function applications(): BusinessDevelopmentOfficers|HasMany
    {
        return $this->hasMany(StudentApplications::class, 'bdm_officer_id');
    }

    public function agents(): BusinessDevelopmentOfficers|HasMany
    {
        return $this->hasMany(User::class, 'bdm_officer_id');
    }
}
