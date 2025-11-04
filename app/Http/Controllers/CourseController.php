<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->per_page ?? 100;
        $query = Courses::query();

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', "%
            $request->search%");
        }

        $courses = $query->orderBy('name')->select([
            'id',
            'name',
            'university_id',
            'description',
        ])->paginate($per_page);

        return $this->respondSuccessWithData(message: 'Courses fetched successfully', data: $courses);
    }

    public function show($id)
    {
        $course = Courses::with('university')->findOrFail($id);
        return $this->respondSuccessWithData(message: 'Course fetched successfully', data: $course);
    }
}
