<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractRequest;
use App\Http\Resources\AgentResource;
use App\Models\User;
use Illuminate\Http\Request;

class AdminAgentController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $term = $request->get('term', '');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $agents = User::query()
            ->when($term, function ($query) use ($term) {
                $query->where(function ($q) use ($term) {
                    $q->where('first_name', 'like', '%' . $term . '%')
                        ->orWhere('last_name', 'like', '%' . $term . '%')
                        ->orWhere('agency_name', 'like', '%' . $term . '%')
                        ->orWhere('email', 'like', '%' . $term . '%')
                        ->orWhere('phone', 'like', '%' . $term . '%');
                });
            })
            ->when($start_date, function ($query) use ($start_date) {
                $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                $query->whereDate('created_at', '<=', $end_date);
            })
            ->where('role_name', 'agent')
            ->latest()->paginate($perPage);

        return AgentResource::collection($agents);
    }

    public function sendContract(ContractRequest $contractRequest)
    {

    }

    public function confirmContractSent(ContractRequest $contractRequest)
    {
        $user = User::find($contractRequest->agent_id);

        if (!$user->is_contract_sent) {
            return $this->respondUnprocessed('Please send contract before confirming');
        }

        if ($user->is_contract_signed) {
            return $this->respondSuccess('Contract already confirmed');
        }

        $user->update([
            'is_contract_signed' => true,
            'contract_signed_at' => now()
        ]);

        return $this->respondSuccess('Contract confirmed');
    }
}
