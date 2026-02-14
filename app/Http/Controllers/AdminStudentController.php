<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentsResource;
use App\Models\Students;
use Illuminate\Http\Request;

class AdminStudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 10);

        $query = Students::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('middle_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone_number', 'LIKE', "%{$search}%")
                    ->orWhere('country', 'LIKE', "%{$search}%");
            });
        }

        $students = $query->latest()->paginate($perPage);

        return StudentsResource::collection($students);
    }

    public function show(int $id)
    {
        $student = Students::where('id', $id)
            ->first();

        return $this->respondSuccessWithData(message: "Student retrieved successfully", data: new StudentsResource($student));
    }
}
