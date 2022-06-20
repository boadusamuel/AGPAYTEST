<?php

namespace App\Actions;

use App\Http\Requests\FileUploadRequest;
use App\Models\Country;
use Exception;
use Illuminate\Support\Facades\DB;

class UploadCountriesAction
{
    public function handle(FileUploadRequest $request): bool
    {
        try {
            $rowNumber = 1;
            if ($file = fopen($request->file, 'r')) {

                $heading = readContents($file)->current();

                if (!$this->validateHeaders($heading)) return false;

                DB::beginTransaction();

                foreach (readContents($file) as $index => $records) {
                    $rowNumber++;
                    Country::create([
                        'continent_code' => $records[0],
                        'currency_code' => $records[1],
                        'iso2_code' => $records[2],
                        'iso3_code' => $records[3],
                        'iso_numeric_code' => $records[4],
                        'fips_code' => $records[5],
                        'calling_code' => $records[6],
                        'common_name' => $records[7],
                        'official_name' => $records[8],
                        'endonym' => $records[9],
                        'demonym' => $records[10],
                    ]);
                }
                DB::commit();
                fclose($file);
                return true;
            } else {
                errorResponse('File cannot to opened');
                return false;
            }
        } catch (Exception $exception) {
            report($exception);
            errorResponse("File not uploaded, Something went wrong on row number $rowNumber");
            DB::rollBack();
            return false;
        }
    }

    private function validateHeaders(array $heading): bool
    {
        if ($heading[0] !== 'continent_code') {
            errorResponse($this->getHeaderValidationMessage(1));
            return false;
        }
        if ($heading[1] !== 'currency_code') {
            errorResponse($this->getHeaderValidationMessage(2));
            return false;
        }
        if ($heading[2] !== 'iso2_code') {
            errorResponse($this->getHeaderValidationMessage(3));
            return false;
        }
        if ($heading[3] !== 'iso3_code') {
            errorResponse($this->getHeaderValidationMessage(4));
            return false;
        }
        if ($heading[4] !== 'iso_numeric_code') {
            errorResponse($this->getHeaderValidationMessage(5));
            return false;
        }
        if ($heading[5] !== 'fips_code') {
            errorResponse($this->getHeaderValidationMessage(6));
            return false;
        }
        if ($heading[6] !== 'calling_code') {
            errorResponse($this->getHeaderValidationMessage(7));
            return false;
        }
        if ($heading[7] !== 'common_name') {
            errorResponse($this->getHeaderValidationMessage(8));
            return false;
        }
        if ($heading[8] !== 'official_name') {
            errorResponse($this->getHeaderValidationMessage(9));
            return false;
        }
        if ($heading[9] !== 'endonym') {
            errorResponse($this->getHeaderValidationMessage(10));
            return false;
        }
        if ($heading[10] !== 'demonym') {
            errorResponse($this->getHeaderValidationMessage(11));
            return false;
        }


        return true;
    }

    private function getHeaderValidationMessage(int $number): string
    {
        return "heading $number is incorrect";
    }

}






