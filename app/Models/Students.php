<?php

namespace App\Models;

use Database\Factories\StudentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Students extends Model
{
    /**
     * @use HasFactory<StudentsFactory>
     * */
    use HasFactory, softDeletes;

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->agent_id = auth()->id();
        });
    }

    protected $fillable = [
        'agent_id',
        'bdm_officer_id',
        'first_name',
        'middle_name',
        'last_name',
        'phone_number',
        'email',
        'gender',
        'birth_date',
        'country',
    ];

    /**
     * The attributes that should be mutated to date.
     *
     * @var array
     */
    protected array $dates = [
        'deleted_at'
    ];

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(StudentApplications::class, 'student_id');
    }
}
