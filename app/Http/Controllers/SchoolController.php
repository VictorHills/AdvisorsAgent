<?php

namespace App\Http\Controllers;

use App\Models\Universities;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 100);
        $search = $request->input('search', $request->input('term', ''));

        $query = Universities::query();

        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }

        $schools = $query->orderBy('name')
            ->select(['id', 'name', 'logo', 'country_id'])
            ->paginate($per_page);

        return $this->respondSuccessWithData(
            message: 'Universities fetched successfully',
            data: $schools
        );
    }

    public function show($id)
    {
        $school = Universities::findOrFail($id);
        return $this->respondSuccessWithData(message: 'University fetched successfully', data: $school);
    }
}
