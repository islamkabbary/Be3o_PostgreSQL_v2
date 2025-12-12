<?php

namespace App\Repositories;

use App\Interfaces\AdRepositoryInterface;
use App\Models\Ad;
use App\Models\AdAttribute;
use App\Models\AdImage;
use App\Traits\FileManagerTrait;
use Illuminate\Support\Facades\DB;

class AdRepository implements AdRepositoryInterface
{
    use FileManagerTrait;
    public function createBaseAd(int $userId, array $data): Ad
    {
        return Ad::create([
            'user_id'       => $userId,
            'category_id'   => $data['category_id'],
            'title'         => $data['title'],
            'description'   => $data['description'],
            'price'         => $data['price'] ?? null,
            'currency'      => $data['currency'] ?? 'EGP',
            'condition'     => $data['condition'] ?? null,

            // location
            'governorate'   => $data['location']['governorate'],
            'city'          => $data['location']['city'],
            'area'          => $data['location']['area'] ?? null,
            'latitude'      => $data['location']['latitude'] ?? null,
            'longitude'     => $data['location']['longitude'] ?? null,

            // PostGIS
            'location'      => isset($data['location']['latitude'])
                ? $this->makePoint($data['location'])
                : null,

            'status'        => 'active',
            'ad_type'       => 'sell',
        ]);
    }

    private function makePoint($location)
    {
        $lat = $location['latitude'];
        $lng = $location['longitude'];

        return DB::raw("ST_SetSRID(ST_MakePoint($lng, $lat), 4326)");
    }

    public function saveAttributes(int $adId, array $attributes)
    {
        foreach ($attributes as $attr) {

            $attributeId = $attr['id'];
            $value = $attr['value'];

            $data = [
                'ad_id'        => $adId,
                'attribute_id' => $attributeId,
            ];

            if (is_string($value)) {
                $data['value_text'] = $value;
            } elseif (is_numeric($value)) {
                $data['value_number'] = $value;
            } elseif (is_bool($value) || $value === '1' || $value === '0') {
                $data['value_boolean'] = (bool)$value;
            } elseif (is_array($value)) {
                $data['value_json'] = $value;
            } elseif (strtotime($value)) {
                $data['value_date'] = $value;
            }

            AdAttribute::create($data);
        }
    }

    public function saveImages(int $adId, array $images, array $options = [])
    {
        $i = 0;

        foreach ($images as $image) {
            if (!$image instanceof \Illuminate\Http\UploadedFile || !$image->isValid()) {
                continue;
            }

            $path = $this->uploadFile($image, 'ads', $options);

            if ($path) {
                AdImage::create([
                    'ad_id'      => $adId,
                    'image_url'  => $path,
                    'is_primary' => $i === 0,
                    'sort_order' => $i,
                ]);

                $i++;
            }
        }
    }
}
