<?php

namespace App\Actions;

use App\Http\Requests\FileUploadRequest;
use App\Models\Country;
use Exception;
use Illuminate\Support\Facades\DB;

class UploadCountriesAction
{
    public function handle(FileUploadRequest $request)
    {
        try {
            if ($file = fopen($request->file, 'r')) {
                readContents($file)->current();

                DB::beginTransaction();

                foreach (readContents($file) as $index => $records) {

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
                    logger($index);
                }
                DB::commit();
                fclose($file);
                return true;
            }else{
                return false;
            }
        } catch (Exception $exception) {
            report($exception);
            DB::rollBack();
        }
    }

}






