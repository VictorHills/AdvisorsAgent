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
    protected $connection = 'advisor_db';
    protected $table = 'courses';

    public function university(): BelongsTo
    {
        return $this->belongsTo(Universities::class, 'university_id');
    }
}
