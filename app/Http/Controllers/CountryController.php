<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 100);
        $search = $request->input('search', $request->input('term', ''));

        $query = Countries::query();

        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }

        $countries = $query->orderBy('name')
            ->select(['id', 'name', 'description', 'currency'])
            ->paginate($per_page);

        return $this->respondSuccessWithData(
            message: 'Countries fetched successfully',
            data: $countries
        );
    }


    public function show($id)
    {
        $country = Countries::findOrFail($id);
        return $this->respondSuccessWithData(message: 'Country fetched successfully', data: $country);
    }
}
