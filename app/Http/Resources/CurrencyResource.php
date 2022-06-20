<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'isoCode' => $this->iso_code,
            'isoNumericCode' => $this->iso_numeric_code,
            'commonName' => $this->common_name,
            'officialName' => $this->official_name,
            'symbol' => $this->symbol,
            'createdAt' =>  $this->created_at->toDateTimeString()
        ];
    }
}
