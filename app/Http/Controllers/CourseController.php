<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Courses::with('school');

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', "%
            $request->search%");
        }

        $courses = $query->orderBy('name')->get();

        return response()->json(['data' => $courses]);
    }

    public function show($id)
    {
        $course = Courses::with('school')->findOrFail($id);
        return response()->json(['course' => $course]);
    }
}
