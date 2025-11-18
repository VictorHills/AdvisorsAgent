<?php

namespace App\Models;

use Database\Factories\StudentApplicationsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentApplications extends Model
{
    /**
     * @use HasFactory<StudentApplicationsFactory>
     * */
    use SoftDeletes, HasFactory;

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
        'course_id',
        'student_id',
        'class_of_degree',
        'additional_notes',
        'signature',
        'schools_of_choice',
        'country_of_preference',
        'application_documents',
        'status',
    ];

    protected $casts = [
        'schools_of_choice' => 'array',
        'country_of_preference' => 'array',
        'application_documents' => 'array',
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

    public function bdmOfficer(): BelongsTo
    {
        return $this->belongsTo(BusinessDevelopmentOfficers::class, 'bdm_officer_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Students::class, 'student_id');
    }
}
