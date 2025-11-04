<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->per_page ?? 100;
        $query = Countries::query();

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', "%
            $request->search%");
        }

        $countries = $query->orderBy('name')->select([
            'id',
            'name',
            'description',
            'currency',
        ])->paginate($per_page);

        return $this->respondSuccessWithData(message: 'Countries fetched successfully', data: $countries);
    }

    public function show($id)
    {
        $country = Countries::findOrFail($id);
        return $this->respondSuccessWithData(message: 'Country fetched successfully', data: $country);
    }
}
