<?php

namespace App\Http\Controllers;

use App\Actions\UploadCountriesAction;
use App\Actions\UploadCurrenciesAction;
use App\Http\Requests\FileUploadRequest;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use PhpParser\Builder;

class CountryController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $data = Country::query()->
        when($request->search, function ($query) use ($request) {
            $query->where('common_name', 'LIKE', '%' . $request->search . '%')->
            orWhere('official_name', 'LIKE', '%' . $request->search . '%')->first();
        })->
        simplePaginate(20);

        return CountryResource::collection($data);
    }

    public function show(Country $country): CountryResource
    {
        return new CountryResource($country);
    }

    public function create()
    {
        return view('countries');
    }

    public function store(FileUploadRequest $request, UploadCountriesAction $uploadCountriesAction): RedirectResponse
    {
        if ($uploadCountriesAction->handle($request)) {
            successResponse('file uploaded successfully');
        }
        return redirect()->back();
    }
}
