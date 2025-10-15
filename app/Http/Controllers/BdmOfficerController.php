<?php

namespace App\Http\Controllers;

use App\Models\BusinessDevelopmentOfficers;
use Illuminate\Http\Request;

class BdmOfficerController extends Controller
{
    public function index(Request $request)
    {
        $query = BusinessDevelopmentOfficers::query();

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        $officers = $query->orderBy('created_at', 'desc')->get();

        return response()->json(['data' => $officers]);
    }

    public function show($id)
    {
        $officer = BusinessDevelopmentOfficers::findOrFail($id);
        return response()->json(['officer' => $officer]);
    }
}
