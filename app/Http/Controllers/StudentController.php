<?php

namespace App\Http\Controllers;

use App\Models\StudentApplications;
use Illuminate\Http\Request;

class StudentController extends Controller
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
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Course filter
        if ($request->has('course') && $request->course) {
            $query->whereHas('course', function ($q) use ($request) {
                $q->where('name', 'like', "%$request->course%");
            });
        }

        // Country filter
        if ($request->has('country') && $request->country) {
            $query->where('country', $request->country);
        }

        $perPage = $request->get('per_page', 10);
        $students = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json($students);
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
