<?php

namespace App\Http\Resources;

use App\Models\Countries;
use App\Models\Universities;
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

        $response['bdmOfficer'] = $this->bdmOfficer;
        $response['universities'] = Universities::whereIn('id', $this->schools_of_choice)->get(['id', 'name']);
        $response['countries'] = Countries::whereIn('id', $this->country_of_preference)->get(['id', 'name']);

        $response['agent'] = [
            'id' => $this->agent->id ?? null,
            'first_name' => $this->agent->first_name ?? null,
            'last_name' => $this->agent->last_name ?? null,
            'agency_name' => $this->agent->agency_name ?? null,
            'phone' => $this->agent->phone ?? null,
            'email' => $this->agent->email ?? null,
        ];

        $response['course'] = [
            'id' => $this->course->id ?? null,
            'name' => $this->course->name ?? null,
        ];

        return $response;
    }
}
