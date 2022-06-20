<?php

namespace App\Http\Controllers;

use App\Actions\UploadCurrenciesAction;
use App\Http\Requests\FileUploadRequest;
use App\Http\Resources\CountryResource;
use App\Http\Resources\CurrencyResource;
use App\Models\Currency;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CurrencyController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $data = Currency::query()->
        when($request->search, function ($query) use ($request) {
            $query->where('common_name', 'LIKE', '%' . $request->search . '%')->
            orWhere('official_name', 'LIKE', '%' . $request->search . '%')->first();
        })->
        simplePaginate(20);

        return CurrencyResource::collection($data);

    }

    public function create()
    {
        return view('currencies');
    }

    public function show(Currency $currency): CurrencyResource
    {
        return new CurrencyResource($currency);
    }

    public function store(FileUploadRequest $request, UploadCurrenciesAction $uploadCurrenciesAction): RedirectResponse
    {
        if ($uploadCurrenciesAction->handle($request)) {
            successResponse('file uploaded successfully');
        }
        return redirect()->back();
    }
}

