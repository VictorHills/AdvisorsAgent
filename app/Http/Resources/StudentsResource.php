<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = parent::toArray($request);
        $response['bdmOfficer'] = $this->bdmOfficer ?? null;
        $response['applications'] = ApplicationResource::collection($this->applications) ?? null;

        $response['agent'] = [
            'id' => $this->agent->id ?? null,
            'first_name' => $this->agent->first_name ?? null,
            'last_name' => $this->agent->last_name ?? null,
            'agency_name' => $this->agent->agency_name ?? null,
            'phone' => $this->agent->phone ?? null,
            'email' => $this->agent->email ?? null,
        ];

        return $response;
    }
}
