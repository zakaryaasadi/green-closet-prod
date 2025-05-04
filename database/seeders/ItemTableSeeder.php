<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Item;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ItemTableSeeder extends Seeder
{
    /**
     * @throws FileCannotBeAdded
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function run()
    {
        $UAE = Country::whereCode('AE')->first()->id;
        $KSA = Country::whereCode('SA')->first()->id;
        $KW = Country::whereCode('KW')->first()->id;

        $this->createItem(30, $UAE, [
            'translate' => [
                'title_ar' => 'آلبسة',
                'title_en' => 'Clothes',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/splash.png');

        $this->createItem(10, $UAE, [
            'translate' => [
                'title_ar' => 'احذية',
                'title_en' => 'Shoes',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/splash.png');

        $this->createItem(12, $UAE, [
            'translate' => [
                'title_ar' => 'بلاستيك',
                'title_en' => 'Plastic',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/splash.png');

        $this->createItem(20, $UAE, [
            'translate' => [
                'title_ar' => 'بناطلين',
                'title_en' => 'Pants',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/splash.png');

        $this->createItem(12, $UAE, [
            'translate' => [
                'title_ar' => 'العاب',
                'title_en' => 'Toys',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/splash.png');

        $this->createItem(30, $KSA, [
            'translate' => [
                'title_ar' => 'آلبسة',
                'title_en' => 'Clothes',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/splash.png');

        $this->createItem(10, $KSA, [
            'translate' => [
                'title_ar' => 'احذية',
                'title_en' => 'Shoes',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/splash.png');

        $this->createItem(12, $KSA, [
            'translate' => [
                'title_ar' => 'بلاستيك',
                'title_en' => 'Plastic',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/splash.png');

        $this->createItem(30, $KW, [
            'translate' => ['title_ar' => 'آلبسة', 'title_en' => 'Clothes'],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/splash.png');

        $this->createItem(10, $KW, [
            'translate' => ['title_ar' => 'احذية', 'title_en' => 'Shoes'],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/splash.png');

        $this->createItem(12, $KW, [
            'translate' => [
                'title_ar' => 'بلاستيك',
                'title_en' => 'Plastic',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/splash.png');


    }

    private function createItem($price, $country_id, $meta, $image): Item
    {
        return Item::create([
            'price_per_kg' => $price,
            'country_id' => $country_id,
            'meta' => $meta,
            'image_path' => $image,
        ]);
    }
}
