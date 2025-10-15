<?php

namespace App\Http\Controllers;

use App\Models\StudentApplications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $agentId = auth()->id();
        $query = StudentApplications::where('agent_id', $agentId)
            ->with(['course', 'agent', 'bdmOfficer']);

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Course filter
        if ($request->has('course_id') && $request->course_id) {
            $query->where('course_id', $request->course_id);
        }

        // Country filter
        if ($request->has('country') && $request->country) {
            $query->where('country', $request->country);
        }

        $perPage = $request->get('per_page', 10);
        $applications = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json($applications);
    }

    public function show($id)
    {
        $agentId = auth()->id();
        $application = StudentApplications::where('agent_id', $agentId)
            ->with(['course', 'agent', 'bdmOfficer'])
            ->findOrFail($id);

        return response()->json(['application' => $application]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|in:Male,Female,Other',
            'email' => 'required|email|unique:student_applications,email',
            'phone_number' => 'required|string|unique:student_applications,phone_number',
            'country' => 'required|string|max:255',
            'class_of_degree' => 'required|string|max:255',
            'schools_of_choice' => 'required|array',
            'country_of_preference' => 'required|array',
            'additional_notes' => 'nullable|string',
            'signature' => 'nullable|string',
            'application_documents' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $application = StudentApplications::create([
            'agent_id' => auth()->id(),
            'bdm_officer_id' => auth()->user()->bdm_officer_id,
            'course_id' => $request->course_id,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'country' => $request->country,
            'class_of_degree' => $request->class_of_degree,
            'schools_of_choice' => json_encode($request->schools_of_choice),
            'country_of_preference' => json_encode($request->country_of_preference),
            'additional_notes' => $request->additional_notes,
            'signature' => $request->signature,
            'application_documents' => json_encode($request->application_documents ?? []),
            'status' => 'Pending',
        ]);

        return response()->json([
            'application' => $application,
            'message' => 'Application created successfully'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $agentId = auth()->id();
        $application = StudentApplications::where('agent_id', $agentId)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|in:Male,Female,Other',
            'email' => 'required|email|unique:student_applications,email,' . $id,
            'phone_number' => 'required|string|unique:student_applications,phone_number,' . $id,
            'country' => 'required|string|max:255',
            'class_of_degree' => 'required|string|max:255',
            'schools_of_choice' => 'required|array',
            'country_of_preference' => 'required|array',
            'additional_notes' => 'nullable|string',
            'signature' => 'nullable|string',
            'application_documents' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $application->update([
            'course_id' => $request->course_id,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'country' => $request->country,
            'class_of_degree' => $request->class_of_degree,
            'schools_of_choice' => json_encode($request->schools_of_choice),
            'country_of_preference' => json_encode($request->country_of_preference),
            'additional_notes' => $request->additional_notes,
            'signature' => $request->signature,
            'application_documents' => json_encode($request->application_documents ?? []),
        ]);

        return response()->json([
            'application' => $application,
            'message' => 'Application updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $agentId = auth()->id();
        $application = StudentApplications::where('agent_id', $agentId)->findOrFail($id);
        $application->delete();

        return response()->json(['message' => 'Application deleted successfully']);
    }
}
