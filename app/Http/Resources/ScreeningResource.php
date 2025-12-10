<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScreeningResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'date_of_birth' => $this->date_of_birth->toDateString(),
            'age' => $this->age,
            'headache_frequency' => $this->headache_frequency->value,
            'daily_frequency' => $this->daily_frequency,
            'eligible' => $this->eligible,
            'cohort' => $this->cohort,
            'result_message' => $this->result_message,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
