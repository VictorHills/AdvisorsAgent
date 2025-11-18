<?php

namespace App\Http\Controllers;

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
}
