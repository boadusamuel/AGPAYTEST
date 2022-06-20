<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'iso_code',
        'iso_numeric_code',
        'common_name',
        'official_name',
        'symbol'
    ];

    public function setSymbolAttribute(string $name)
    {
        $this->attributes['symbol'] = base64_encode($name);
    }

    public function getSymbolAttribute(): string
    {
        return mb_check_encoding(base64_decode($this->attributes['symbol']), 'UTF-8') ?  base64_decode($this->attributes['symbol']) : '';
    }
}
