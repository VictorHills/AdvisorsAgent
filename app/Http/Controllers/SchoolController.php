<?php

namespace App\Http\Controllers;

use App\Models\Schools;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        $query = Schools::query();

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', "%$request->search%");
        }

        $schools = $query->orderBy('name')->get();

        return response()->json(['data' => $schools]);
    }

    public function show($id)
    {
        $school = Schools::findOrFail($id);
        return response()->json(['school' => $school]);
    }
}
