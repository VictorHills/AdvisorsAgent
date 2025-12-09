<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class BdmOfficerController extends Controller
{
    public function index(Request $request)
    {
        $bdmOfficers = User::where('role_name', 'bdm-officer')
            ->get(['id', 'first_name', 'last_name', 'email', 'phone']);

        return $this->respondSuccessWithData('BDM Officers fetched successfully', $bdmOfficers);
    }

    public function show($id)
    {
        $bdmOfficer = User::find($id);
        if (is_null($bdmOfficer)) {
            return $this->respondWithError("User does not exist");
        }

        return $this->respondSuccessWithData('BDM Officer fetched successfully', $bdmOfficer);
    }
}
