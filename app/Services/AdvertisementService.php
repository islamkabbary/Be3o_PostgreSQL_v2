<?php

namespace App\Services;

use App\Interfaces\AdvertisementRepositoryInterface;

class AdvertisementService
{
    protected $advertisementServiceInterface;

    public function __construct(AdvertisementRepositoryInterface $advertisementServiceInterface)
    {
        $this->advertisementServiceInterface = $advertisementServiceInterface;
    }
}
