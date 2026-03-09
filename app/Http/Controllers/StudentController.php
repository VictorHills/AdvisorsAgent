<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStudentRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Requests\ValidateStudentRequest;
use App\Http\Resources\StudentsResource;
use App\Models\Students;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $agentId = auth()->id();
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 10);
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $students = Students::where('agent_id', $agentId)
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('first_name', 'LIKE', "%$search%")
                        ->orWhere('last_name', 'LIKE', "%$search%")
                        ->orWhere('middle_name', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%")
                        ->orWhere('phone_number', 'LIKE', "%$search%")
                        ->orWhere('country', 'LIKE', "%$search%");
                });
            })
            ->when($start_date, function ($query) use ($start_date) {
                $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                $query->whereDate('created_at', '<=', $end_date);
            })
            ->orderBy('created_at', 'desc')->paginate($perPage);

        return StudentsResource::collection($students);
    }

    public function show($id)
    {
        $agentId = auth()->id();
        $student = Students::where('agent_id', $agentId)
            ->where('id', $id)
            ->first();

        return $this->respondSuccessWithData(message: "Student retrieved successfully", data: new StudentsResource($student));
    }

    public function store(CreateStudentRequest $createStudentRequest): JsonResponse
    {
        $student = Students::create($createStudentRequest->validated());
        return $this->respondSuccessWithData(message: 'Student created successfully', data: new StudentsResource($student));
    }

    public function validateStudent(ValidateStudentRequest $validateStudentRequest, AuthController $authController): JsonResponse
    {
        $check_student = Students::where('email', $validateStudentRequest->email)
            ->first();

        if ($check_student) {
            return $this->respondSuccessWithData(message: 'Student exists', data: new StudentsResource($check_student));
        } else {
            $resetPasswordRequest = new ResetPasswordRequest();
            $resetPasswordRequest['email'] = $validateStudentRequest->email;
            $authController->sendOtp($resetPasswordRequest);

            return $this->respondBadRequest(message: 'Student not found, OTP sent to Email for verification');
        }
    }

    public function update(string $id, UpdateStudentRequest $updateStudentRequest): JsonResponse
    {
        $agentId = auth()->id();
        $student = Students::where('agent_id', $agentId)
            ->where('id', $id)
            ->first();

        if (!$student) {
            return $this->respondWithError(message: 'Student not found');
        }

        $student->update($updateStudentRequest->validated());

        return $this->respondSuccessWithData(message: 'Student updated successfully', data: new StudentsResource($student));
    }
}
