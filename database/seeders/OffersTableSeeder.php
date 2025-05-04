<?php

namespace Database\Seeders;

use App\Enums\OfferType;
use App\Models\Country;
use App\Models\Offer;
use App\Models\Partner;
use Illuminate\Database\Seeder;

class OffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function run()
    {
        $UAE = Country::whereCode('AE')->first()->id;
        $KSA = Country::whereCode('SA')->first()->id;
        $KW = Country::whereCode('KW')->first()->id;
        $partnerUAE = Partner::whereCountryId($UAE)->first()->id;
        $partnerKSA = Partner::whereCountryId($KSA)->first()->id;
        $partnerKW = Partner::whereCountryId($KW)->first()->id;
        $offer = $this->createOffer(30, $partnerUAE, OfferType::PERCENT, $UAE, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون',
                'name_en' => 'Offer from Noon',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer1.png');


        $offer = $this->createOffer(20, $partnerUAE, OfferType::PERCENT, $UAE, [
            'translate' => [
                'name_ar' => 'حسم مقدم من سبلاش',
                'name_en' => 'Offer from Splash',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer2.png');


        $offer = $this->createOffer(2, $partnerUAE, OfferType::FIXED, $UAE, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون على كل كنزة خصم',
                'name_en' => 'A discount offered by Noon on each sweater',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer3.png');


        $offer = $this->createOffer(20, $partnerUAE, OfferType::PERCENT, $UAE, [
            'translate' => [
                'name_ar' => 'حسم مقدم من سبلاش',
                'name_en' => 'Offer from Splash',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer4.png');


        $offer = $this->createOffer(30, $partnerUAE, OfferType::PERCENT, $UAE, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون',
                'name_en' => 'Offer from Noon',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer1.png');


        $offer = $this->createOffer(30, $partnerUAE, OfferType::PERCENT, $UAE, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون',
                'name_en' => 'Offer from Noon',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer5.png');


        $offer = $this->createOffer(30, $partnerUAE, OfferType::PERCENT, $UAE, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون',
                'name_en' => 'Offer from SIVVI',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer5.png');


        $offer = $this->createOffer(30, $partnerUAE, OfferType::PERCENT, $UAE, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون',
                'name_en' => 'Offer from SIVVI',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer5.png');


        $offer = $this->createOffer(30, $partnerUAE, OfferType::PERCENT, $UAE, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون',
                'name_en' => 'Offer from SIVVI',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer5.png');


        $offer = $this->createOffer(30, $partnerKSA, OfferType::PERCENT, $KSA, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون',
                'name_en' => 'Offer from Noon',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer1.png');


        $offer = $this->createOffer(20, $partnerKSA, OfferType::PERCENT, $KSA, [
            'translate' => [
                'name_ar' => 'حسم مقدم من سبلاش',
                'name_en' => 'Offer from Splash',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer2.png');


        $offer = $this->createOffer(2, $partnerKSA, OfferType::FIXED, $KSA, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون على كل كنزة خصم',
                'name_en' => 'A discount offered by Noon on each sweater',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer3.png');


        $offer = $this->createOffer(20, $partnerKSA, OfferType::PERCENT, $KSA, [
            'translate' => [
                'name_ar' => 'حسم مقدم من سبلاش',
                'name_en' => 'Offer from Splash',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer4.png');


        $offer = $this->createOffer(30, $partnerKSA, OfferType::PERCENT, $KSA, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون',
                'name_en' => 'Offer from Noon',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer1.png');



        $offer = $this->createOffer(30, $partnerKSA, OfferType::PERCENT, $KSA, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون',
                'name_en' => 'Offer from Noon',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer5.png');



        $offer = $this->createOffer(30, $partnerKSA, OfferType::PERCENT, $KSA, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون',
                'name_en' => 'Offer from SIVVI',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer5.png');


        $offer = $this->createOffer(30, $partnerKSA, OfferType::PERCENT, $KSA, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون',
                'name_en' => 'Offer from SIVVI',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer5.png');


        $offer = $this->createOffer(30, $partnerKSA, OfferType::PERCENT, $KSA, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون',
                'name_en' => 'Offer from SIVVI',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer5.png');



        $offer = $this->createOffer(30, $partnerKW, OfferType::PERCENT, $KW, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون',
                'name_en' => 'Offer from Noon',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer1.png');


        $offer = $this->createOffer(20, $partnerKW, OfferType::PERCENT, $KW, [
            'translate' => [
                'name_ar' => 'حسم مقدم من سبلاش',
                'name_en' => 'Offer from Splash',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer2.png');


        $offer = $this->createOffer(2, $partnerKW, OfferType::FIXED, $KW, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون على كل كنزة خصم',
                'name_en' => 'A discount offered by Noon on each sweater',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer3.png');


        $offer = $this->createOffer(20, $partnerKW, OfferType::PERCENT, $KW, [
            'translate' => [
                'name_ar' => 'حسم مقدم من سبلاش',
                'name_en' => 'Offer from Splash',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer4.png');


        $offer = $this->createOffer(30, $partnerKW, OfferType::PERCENT, $KW, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون',
                'name_en' => 'Offer from Noon',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer1.png');

        $offer = $this->createOffer(30, $partnerKW, OfferType::PERCENT, $KW, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون',
                'name_en' => 'Offer from Noon',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer5.png');

        $offer = $this->createOffer(30, $partnerKW, OfferType::PERCENT, $KW, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون',
                'name_en' => 'Offer from SIVVI',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer5.png');

        $offer = $this->createOffer(30, $partnerKW, OfferType::PERCENT, $KW, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون',
                'name_en' => 'Offer from SIVVI',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer5.png');


        $offer = $this->createOffer(30, $partnerKW, OfferType::PERCENT, $KW, [
            'translate' => [
                'name_ar' => 'حسم مقدم من نون',
                'name_en' => 'Offer from SIVVI',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/offers/offer5.png');

    }

    private function createOffer($value, $partner_id, $type, $country_id, $meta, $image): Offer
    {
        return Offer::create([
            'value' => $value,
            'type' => $type,
            'country_id' => $country_id,
            'alt' => 'test Offer image',
            'meta' => $meta,
            'image_path' => $image,
            'partner_id' => $partner_id,
        ]);
    }
}
