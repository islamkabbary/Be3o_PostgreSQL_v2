<?php

namespace App\Services;

use App\Interfaces\AdRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdService
{
    protected $adRepository;

    public function __construct(AdRepositoryInterface $adRepository)
    {
        $this->adRepository = $adRepository;
    }
    
    public function createAd(User $user, array $data)
    {
        return DB::transaction(function () use ($user, $data) {
            $ad = $this->adRepository->createBaseAd($user->id, $data);

            if (!empty($data['attributes'])) {
                $this->adRepository->saveAttributes($ad->id, $data['attributes']);
            }

            if (!empty($data['images'])) {
                $this->adRepository->saveImages($ad->id, $data['images']);
            }

            return $ad->load(['images', 'attributes']);
        });
    }
}
