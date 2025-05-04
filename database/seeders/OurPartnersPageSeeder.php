<?php

namespace Database\Seeders;

use App\Enums\SectionType;
use App\Enums\TargetType;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Database\Seeder;

class OurPartnersPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ourPartnersPageEnglishAE = PagesTableSeeder::createPage('Partners',
            Language::whereCode('en')->first()->id,
            Country::whereCode('AE')->first()->id, 'partners', false);
        PagesTableSeeder::createSection(
            $ourPartnersPageEnglishAE->id,
            [
                'title' => 'Partners',
                'description' => 'We are pleased to share with you our partners from the charities that we cooperate with to deliver aid to people in need',
                'button' => [
                    'link' => '',
                    'title' => 'Join Us',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OUR_PARTNERS_PAGE,
            1
        );

        $ourPartnersPageArabicAE = PagesTableSeeder::createPage('شركائنا',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('AE')->first()->id, 'partners', false);

        PagesTableSeeder::createSection(
            $ourPartnersPageArabicAE->id,
            [
                'title' => 'شركائنا',
                'description' => 'يسرنا ان يكون نشارككم شركائنا من الجمعيات الخيرية التي نتعاون معهم لايصال المساعدات للاشخاص المحتاجين',
                'button' => [
                    'link' => '',
                    'title' => 'أنضم إلينا',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OUR_PARTNERS_PAGE,
            1
        );



        $ourPartnersPageEnglishSA = PagesTableSeeder::createPage('Partners',
            Language::whereCode('en')->first()->id,
            Country::whereCode('SA')->first()->id, 'partners', false);
        PagesTableSeeder::createSection(
            $ourPartnersPageEnglishSA->id,
            [
                'title' => 'Partners',
                'description' => 'We are pleased to share with you our partners from the charities that we cooperate with to deliver aid to people in need',
                'button' => [
                    'link' => '',
                    'title' => 'Join Us',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OUR_PARTNERS_PAGE,
            1
        );
        $ourPartnersPageArabicSA = PagesTableSeeder::createPage('شركائنا',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('SA')->first()->id, 'partners', false);
        PagesTableSeeder::createSection(
            $ourPartnersPageArabicSA->id,
            [
                'title' => 'شركائنا',
                'description' => 'يسرنا ان يكون نشارككم شركائنا من الجمعيات الخيرية التي نتعاون معهم لايصال المساعدات للاشخاص المحتاجين',
                'button' => [
                    'link' => '',
                    'title' => 'أنضم إلينا',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OUR_PARTNERS_PAGE,
            1
        );

        $ourPartnersPageEnglishKW = PagesTableSeeder::createPage('Partners',
            Language::whereCode('en')->first()->id,
            Country::whereCode('KW')->first()->id, 'partners', false);

        PagesTableSeeder::createSection(
            $ourPartnersPageEnglishKW->id,
            [
                'title' => 'Partners',
                'description' => 'We are pleased to share with you our partners from the charities that we cooperate with to deliver aid to people in need',
                'button' => [
                    'link' => '',
                    'title' => 'Join Us',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OUR_PARTNERS_PAGE,
            1
        );

        $ourPartnersPageArabicKW = PagesTableSeeder::createPage('شركائنا',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('KW')->first()->id, 'partners', false);

        PagesTableSeeder::createSection(
            $ourPartnersPageArabicKW->id,
            [
                'title' => 'شركائنا',
                'description' => 'يسرنا ان يكون نشارككم شركائنا من الجمعيات الخيرية التي نتعاون معهم لايصال المساعدات للاشخاص المحتاجين',
                'button' => [
                    'link' => '',
                    'title' => 'أنضم إلينا',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OUR_PARTNERS_PAGE,
            1
        );

    }
}
