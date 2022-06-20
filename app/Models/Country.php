<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'continent_code',
        'currency_code',
        'iso2_code',
        'iso3_code',
        'iso_numeric_code',
        'fips_code',
        'calling_code',
        'common_name',
        'official_name',
        'endonym',
        'demonym',
    ];

    public function setOfficialNameAttribute(string $name)
    {
        $this->attributes['official_name'] = base64_encode($name);
    }

    public function getOfficialNameAttribute(): string
    {
        return mb_check_encoding(base64_decode($this->attributes['official_name']), 'UTF-8') ?  base64_decode($this->attributes['official_name']) : '';
    }

    public function setEndonymAttribute(string $name)
    {
        $this->attributes['endonym'] = base64_encode($name);
    }

    public function getEndonymAttribute(): string
    {
        return mb_check_encoding(base64_decode($this->attributes['endonym']), 'UTF-8') ?  base64_decode($this->attributes['endonym']) : '';
    }
}
