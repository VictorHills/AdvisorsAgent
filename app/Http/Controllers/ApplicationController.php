<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStudentApplicationRequest;
use App\Http\Requests\UpdateStudentApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\StudentApplications;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $agentId = auth()->id();
        $query = StudentApplications::where('agent_id', $agentId);

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhereHas('course', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            });
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Course filter
        if ($request->has('course_id') && $request->course_id) {
            $query->whereHas('course', function ($q) use ($request) {
                $q->where('id', 'like', '%' . $request->course_id . '%');
            });
        }

        // Country filter
        if ($request->has('country') && $request->country) {
            $query->where('country', $request->country);
        }

        $perPage = $request->get('per_page', 10);
        $applications = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return ApplicationResource::collection($applications);
    }

    public function show($id)
    {
        $agentId = auth()->id();
        $application = StudentApplications::where('agent_id', $agentId)
            ->with(['course', 'agent', 'bdmOfficer'])
            ->findOrFail($id);

        return $this->respondSuccessWithData(message: 'Application created successfully', data: new ApplicationResource($application));
    }

    /**
     * @throws Throwable
     */
    public function store(CreateStudentApplicationRequest $createStudentApplicationRequest)
    {
        return DB::transaction(function () use ($createStudentApplicationRequest) {
            $student = Students::create($createStudentApplicationRequest->validated());
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

            //TODO: Send emails to the following (The Student, BDM Officer, TGM Admin and Agent)

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
}
