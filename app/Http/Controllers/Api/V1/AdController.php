<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAdRequest;
use App\Http\Resources\AdResource;
use App\Services\AdService;

class AdController extends Controller
{
    protected AdService $adService;

    public function __construct(AdService $adService)
    {
        $this->adService = $adService;
    }
    public function store(CreateAdRequest $request)
    {
        $ad = $this->adService->createAd(
            user: $request->user(),
            data: $request->validated()
        );

        return $this->success(
            data: new AdResource($ad),
            message: __('messages.Ad created successfully'),
            statusCode: 201
        );
    }
}
