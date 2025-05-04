<?php

namespace Database\Seeders;

use App\Enums\SectionType;
use App\Enums\TargetType;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Database\Seeder;

class OffersPageSeeder extends Seeder
{
    public function run()
    {
        $offersPageEnglishAE = PagesTableSeeder::createPage('Offers',
            Language::whereCode('en')->first()->id,
            Country::whereCode('AE')->first()->id, 'offers', false);

        PagesTableSeeder::createSection(
            $offersPageEnglishAE->id,
            [
                'title' => 'Offers from KISWA',
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OFFER_PAGE,
            1
        );

        $offersPageArabicAE = PagesTableSeeder::createPage('العروض',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('AE')->first()->id, 'offers', false);

        PagesTableSeeder::createSection(
            $offersPageArabicAE->id,
            [
                'title' => 'العروض من كسوة',
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OFFER_PAGE,
            1
        );

        $offersPageEnglishSA = PagesTableSeeder::createPage('Offers',
            Language::whereCode('en')->first()->id,
            Country::whereCode('SA')->first()->id, 'offers', false);

        PagesTableSeeder::createSection(
            $offersPageEnglishSA->id,
            [
                'title' => 'Offers from KISWA',
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OFFER_PAGE,
            1
        );

        $offersPageArabicSA = PagesTableSeeder::createPage('العروض',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('SA')->first()->id, 'offers', false);

        PagesTableSeeder::createSection(
            $offersPageArabicSA->id,
            [
                'title' => 'العروض من كسوة',
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OFFER_PAGE,
            1
        );

        $offersPageEnglishKW = PagesTableSeeder::createPage('Offers',
            Language::whereCode('en')->first()->id,
            Country::whereCode('KW')->first()->id, 'offers', false);

        PagesTableSeeder::createSection(
            $offersPageEnglishKW->id,
            [
                'title' => 'Offers from KISWA',
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OFFER_PAGE,
            1
        );

        $offersPageArabicKW = PagesTableSeeder::createPage('العروض',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('KW')->first()->id, 'offers', false);

        PagesTableSeeder::createSection(
            $offersPageArabicKW->id,
            [
                'title' => 'العروض من كسوة',
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OFFER_PAGE,
            1
        );

    }
}
