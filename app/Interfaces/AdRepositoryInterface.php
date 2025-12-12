<?php

namespace App\Interfaces;

use App\Models\Ad;

interface AdRepositoryInterface
{
    /**
     * Create base ad row (without attributes or images)
     */
    public function createBaseAd(int $userId, array $data): Ad;

    /**
     * Save dynamic category attributes for the ad
     */
    public function saveAttributes(int $adId, array $attributes);

    /**
     * Save uploaded images for an ad
     */
    public function saveImages(int $adId, array $images);

    // /**
    //  * Find ad by ID
    //  */
    // public function find(int $id): ?Ad;

    // /**
    //  * Delete an ad by ID
    //  */
    // public function delete(int $id): bool;

    // /**
    //  * Update ad data (title, description, etc)
    //  */
    // public function updateBaseAd(Ad $ad, array $data): Ad;

    // /**
    //  * Update dynamic attributes (replace or append)
    //  */
    // public function updateAttributes(int $adId, array $attributes): void;

    // /**
    //  * Remove all images then re-add (for update)
    //  */
    // public function replaceImages(int $adId, array $images): void;

    // /**
    //  * List ads with pagination + filters (category, location, price...)
    //  */
    // public function filter(array $filters, int $perPage = 20);

    // /**
    //  * Get user's ads
    //  */
    // public function getUserAds(int $userId, int $perPage = 20);
}
