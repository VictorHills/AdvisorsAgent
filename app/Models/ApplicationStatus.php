<?php

namespace App\Models;

use Database\Factories\ApplicationStatusFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationStatus extends Model
{
    /**
     * @use HasFactory<ApplicationStatusFactory>
     * */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'status_code',
        'status_name'
    ];

    /**
     * The attributes that should be mutated to date.
     *
     * @var array
     */
    protected array $dates = [
        'deleted_at'
    ];
}
