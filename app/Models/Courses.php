<?php

namespace App\Models;

use Database\Factories\CoursesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    /**
     * @use HasFactory<CoursesFactory>
     */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'school_id',
        'name',
        'slug',
        'description',
        'image',
        'code',
        'deleted_at',
    ];
}
