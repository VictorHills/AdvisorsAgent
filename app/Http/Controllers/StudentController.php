<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStudentRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ValidateStudentRequest;
use App\Http\Resources\StudentsResource;
use App\Models\StudentApplications;
use App\Models\Students;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $agentId = auth()->id();
        $query = Students::where('agent_id', $agentId);

        $perPage = $request->get('per_page', 10);
        $students = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return StudentsResource::collection($students);
    }

    public function show($id)
    {
        $agentId = auth()->id();
        $student = StudentApplications::where('agent_id', $agentId)
            ->with(['course', 'agent', 'bdmOfficer'])
            ->findOrFail($id);

        return response()->json(['student' => $student]);
    }

    public function store(CreateStudentRequest $createStudentRequest)
    {
        $student = Students::create([$createStudentRequest->validated()]);
        return $this->respondSuccessWithData(message: 'Student created successfully', data: new StudentsResource($student));
    }

    public function validateStudent(ValidateStudentRequest $validateStudentRequest)
    {
        $check_student = Students::where('email', $validateStudentRequest->email)
            ->first();

        if ($check_student) {
            return $this->respondSuccessWithData(message: 'Student exists', data: new StudentsResource($check_student));
        } else {
            $resetPasswordRequest = new ResetPasswordRequest();
            $resetPasswordRequest['email'] = $validateStudentRequest->email;

            $authController = new AuthController();
            $authController->sendOtp($resetPasswordRequest);

            return $this->respondBadRequest(message: 'Student not found, OTP sent to Email for verification');
        }
    }
}
