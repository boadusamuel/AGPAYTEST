<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'continentCode' => $this->continent_code,
            'currencyCode' => $this->currency_code,
            'iso2Code' => $this->iso2_code,
            'iso3Code' => $this->iso3_code,
            'isoNumericCode' => $this->iso_numeric_code,
            'fipsCode' => $this->fips_code,
            'callingCode' => $this->calling_code,
            'commonName' => $this->common_name,
            'officialName' => $this->official_name,
            'endonym' => $this->endonym,
            'demonym' => $this->demonym,
            'createdAt' => $this->created_at->toDateTimeString()
        ];
    }
}
