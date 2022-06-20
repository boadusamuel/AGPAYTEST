<?php

namespace App\Actions;

use App\Http\Requests\FileUploadRequest;
use App\Models\Currency;
use Exception;
use Illuminate\Support\Facades\DB;

class UploadCurrenciesAction
{
    public function handle(FileUploadRequest $request)
    {
        try {
            if ($file = fopen($request->file, 'r')) {
                readContents($file)->current();

                DB::beginTransaction();

                foreach (readContents($file) as $index => $records) {

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
                return false;
            }
        } catch (Exception $exception) {
            report($exception);
            DB::rollBack();
        }
    }

}






