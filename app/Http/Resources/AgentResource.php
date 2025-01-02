<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response['id'] = $this->id;
        $response['first_name'] = $this->first_name;
        $response['last_name'] = $this->last_name;
        $response['agency_name'] = $this->agency_name;
        $response['email'] = $this->email;
        $response['phone'] = $this->phone;
        $response['business_registration_number'] = $this->business_registration_number;
        $response['is_active'] = $this->is_active;
        $response['created_at'] = $this->created_at;

        $response['bdm_officer_details'] = [
            'id' => $this->bdm_officer->id ?? null,
            'full_name' => ($this->bdm_officer->first_name ?? null) . ' ' . ($this->bdm_officer->last_name ?? null),
            'email' => $this->bdm_officer->email ?? null,
            'phone' => $this->bdm_officer->phone ?? null
        ];

        $response['total_students'] = $this->students()->count();
        $response['total_applications'] = $this->applications()->count();

        return $response;
    }
}
