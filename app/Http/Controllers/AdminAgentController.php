<?php

namespace App\Http\Controllers;

use App\Http\Resources\AgentResource;
use App\Models\User;
use Illuminate\Http\Request;

class AdminAgentController extends Controller
{
    //
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $term = $request->get('term', '');

        $agents = User::query()
            ->when($term, function ($query) use ($term) {
                $query->where('first_name', 'like', '%' . $term . '%')
                    ->orWhere('last_name', 'like', '%' . $term . '%')
                    ->orWhere('agency_name', 'like', '%' . $term . '%')
                    ->orWhere('email', 'like', '%' . $term . '%')
                    ->orWhere('phone', 'like', '%' . $term . '%');
            })
            ->where('role_name', 'agent')
            ->latest()->paginate($perPage);

        return AgentResource::collection($agents);
    }
}
