<?php

namespace App\Models;

use Database\Factories\CoursesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courses extends Model
{
    /**
     * @use HasFactory<CoursesFactory>
     */
    use HasFactory, SoftDeletes;

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

    public function school(): BelongsTo
    {
        return $this->belongsTo(Schools::class, 'school_id');
    }

    public function applications(): Courses|HasMany
    {
        return $this->hasMany(StudentApplications::class, 'course_id');
    }
}
