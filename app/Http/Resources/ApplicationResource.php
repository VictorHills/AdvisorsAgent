<?php

namespace App\Http\Resources;

use App\Models\Countries;
use App\Models\Universities;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = parent::toArray($request);
        $response['student'] = $this->student;
        $response['bdmOfficer'] = $this->bdmOfficer;

        $response['course'] = [
            'id' => $this->course->id ?? null,
            'name' => $this->course->name ?? null,
        ];

        $response['agent'] = [
            'id' => $this->agent->id ?? null,
            'name' => $this->agent->first_name ?? null . ' ' . $this->agent->last_name ?? null,
            'email' => $this->agent->email ?? null,
            'phone' => $this->agent->phone ?? null,
        ];

        $response['schools_of_choice_details'] = Universities::whereIn('id', $this->schools_of_choice ?? [])
            ->get(['id', 'name', 'logo']);

        $response['country_of_preference_details'] = Countries::whereIn('id', $this->country_of_preference ?? [])
            ->get(['id', 'name', 'currency']);

        return $response;
    }
}
