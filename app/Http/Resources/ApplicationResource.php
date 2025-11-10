<?php

namespace App\Http\Resources;

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
        $response['course'] = $this->course;
        $response['agent'] = $this->agent;
        $response['bdmOfficer'] = $this->bdmOfficer;

        return $response;
    }
}
