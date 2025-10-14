<?php

namespace App\Models;

use Database\Factories\SchoolsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schools extends Model
{
    /**
     * @use HasFactory<SchoolsFactory>
     */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'country',
        'city',
        'full_address',
        'postal_code',
        'slug',
        'description',
        'image',
        'code',
    ];
}
