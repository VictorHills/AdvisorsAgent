<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentsResource;
use App\Models\Students;
use Illuminate\Http\Request;

class AdminStudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Students::first();

        $perPage = $request->get('per_page', 10);
        $students = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return StudentsResource::collection($students);
    }

    public function show(int $id)
    {
        $student = Students::where('id', $id)
            ->first();

        return $this->respondSuccessWithData(message: "Student retrieved successfully", data: new StudentsResource($student));
    }
}
