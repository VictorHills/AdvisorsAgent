<?php

namespace App\Models;

use Database\Factories\StudentApplicationsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentApplications extends Model
{
    /**
     * @use HasFactory<StudentApplicationsFactory>
     * */
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'agent_id',
        'bdm_officer_id',
        'course_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'email',
        'phone_number',
        'country',
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

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function bdmOfficer()
    {
        return $this->belongsTo(BusinessDevelopmentOfficers::class, 'bdm_officer_id');
    }

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }
}
