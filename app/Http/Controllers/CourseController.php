<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', $request->input('term', ''));
        $query = Courses::query();

        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }

        $courses = $query->orderBy('name')
            ->select(['id', 'name', 'university_id', 'description'])
            ->get();

        return $this->respondSuccessWithData(message: 'Courses fetched successfully', data: $courses);
    }

    public function show($id)
    {
        $course = Courses::with('university')->findOrFail($id);
        return $this->respondSuccessWithData(message: 'Course fetched successfully', data: $course);
    }
}
