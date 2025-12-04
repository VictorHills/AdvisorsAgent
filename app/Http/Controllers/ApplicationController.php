<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStudentApplicationRequest;
use App\Http\Requests\UpdateStudentApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Mail\CreateApplicationEmail;
use App\Models\ApplicationStatus;
use App\Models\StudentApplications;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $agentId = auth()->id();
        $query = StudentApplications::where('agent_id', $agentId);

        $perPage = $request->get('per_page', 10);
        $applications = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return ApplicationResource::collection($applications);
    }

    public function show($id)
    {
        $agentId = auth()->id();
        $application = StudentApplications::where('agent_id', $agentId)
            ->findOrFail($id);

        return $this->respondSuccessWithData(message: 'Application created successfully', data: new ApplicationResource($application));
    }

    /**
     * @throws Throwable
     */
    public function store(CreateStudentApplicationRequest $createStudentApplicationRequest)
    {
        return DB::transaction(function () use ($createStudentApplicationRequest) {
            $student = Students::where('email', $createStudentApplicationRequest->validated('email'))->first();

            if (!$student) {
                $studentData = $createStudentApplicationRequest->only([
                    'first_name',
                    'middle_name',
                    'last_name',
                    'gender',
                    'email',
                    'phone_number',
                    'country',
                    'birth_date',
                    'class_of_degree',
                ]);

                $student = Students::create($studentData);
            }

            $checkStudentApplication = StudentApplications::where('student_id', $student->id)
                ->count();

            if ($checkStudentApplication >= 4) {
                return $this->respondError(message: 'A student can have only a maximum of 4 applications.');
            }

            $application = StudentApplications::create($createStudentApplicationRequest->validated() + ['student_id' => $student->id]);

            $filePaths = [];
            if ($createStudentApplicationRequest->hasFile('application_documents')) {
                foreach ($createStudentApplicationRequest->file('application_documents') as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('uploads', 'public');
                        $filePaths[] = $path;
                    }
                }

                $application->update([
                    'application_documents' => $filePaths
                ]);
            }

            $application->refresh();
            Mail::to($student->email)->cc([config('app.admin_email'), config('app.counselor_email')])
                ->send(new CreateApplicationEmail($application));

            return $this->respondSuccessWithData(message: 'Application created successfully', data: new ApplicationResource($application));
        });
    }

    public function update(UpdateStudentApplicationRequest $updateStudentApplicationRequest, $id)
    {
        $agentId = auth()->id();
        $application = StudentApplications::where('agent_id', $agentId)->findOrFail($id);
        $data = $updateStudentApplicationRequest->validated();

        if ($updateStudentApplicationRequest->hasFile('application_documents')) {
            $filePaths = [];

            foreach ($updateStudentApplicationRequest->file('application_documents') as $file) {
                if ($file->isValid()) {
                    $path = $file->store("uploads/applications/$application->id", 'public');
                    $filePaths[] = $path;
                }
            }

            $existingDocuments = $application->application_documents ?? [];
            $data['application_documents'] = array_merge($existingDocuments, $filePaths);
        }

        $application->update($data);
        return $this->respondSuccessWithData(message: 'Application updated successfully', data: new ApplicationResource($application));
    }

    public function destroy($id)
    {
        $agentId = auth()->id();
        $application = StudentApplications::where('agent_id', $agentId)->findOrFail($id);
        $application->delete();

        return $this->respondSuccess(message: 'Application deleted successfully');
    }

    public function getApplicationStatus()
    {
        $applicationStatuses = ApplicationStatus::get(['id', 'status_name', 'status_code']);
        return $this->respondSuccessWithData(message: 'Application statuses retrieved successfully', data: $applicationStatuses);
    }
}
