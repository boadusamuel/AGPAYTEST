<?php

namespace App\Actions;

use App\Http\Requests\FileUploadRequest;
use App\Models\Currency;
use Exception;
use Illuminate\Support\Facades\DB;

class UploadCurrenciesAction
{
    public function handle(FileUploadRequest $request): bool
    {
        try {
            $rowNumber = 1;
            if ($file = fopen($request->file, 'r')) {
                $heading = readContents($file)->current();

                if(!$this->validateHeaders($heading)) return false;

                DB::beginTransaction();

                foreach (readContents($file) as $index => $records) {
                        $rowNumber++;
                     Currency::create([
                        'iso_code' => $records[0],
                        'iso_numeric_code' => $records[1],
                        'common_name' => $records[2],
                        'official_name' => $records[3],
                        'symbol' => $records[4],
                    ]);
                }
                DB::commit();
                fclose($file);
                return true;
            }else{
                errorResponse('File cannot to opened');
                return false;
            }
        } catch (Exception $exception) {
            report($exception);
            errorResponse("File not uploaded, Something went wrong on row number $rowNumber");
            DB::rollBack();
        }
        errorResponse();
        return false;
    }

    private function validateHeaders(array $heading): bool
    {
        if($heading[0] !== 'iso_code'){
            errorResponse($this->getHeaderValidationMessage(1));
            return false;
        }
        if($heading[1] !== 'iso_numeric_code'){
            errorResponse($this->getHeaderValidationMessage(2));
            return false;
        }
        if($heading[2] !== 'common_name'){
            errorResponse($this->getHeaderValidationMessage(3));
            return false;
        }
        if($heading[3] !== 'official_name'){
            errorResponse($this->getHeaderValidationMessage(4));
            return false;
        }
        if($heading[4] !== 'symbol'){
            errorResponse($this->getHeaderValidationMessage(5));
            return false;
        }

        return true;
    }

    private function getHeaderValidationMessage(int $number): string
    {
        return "heading $number is incorrect";
    }

}






