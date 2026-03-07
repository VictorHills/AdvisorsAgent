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
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $students = Students::query()
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
            ->latest()->paginate($perPage);

        return StudentsResource::collection($students);
    }

    public function show(int $id)
    {
        $student = Students::where('id', $id)
            ->first();

        return $this->respondSuccessWithData(message: "Student retrieved successfully", data: new StudentsResource($student));
    }
}
