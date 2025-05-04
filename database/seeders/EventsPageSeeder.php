<?php

namespace Database\Seeders;

use App\Enums\SectionType;
use App\Enums\TargetType;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class EventsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws FileCannotBeAdded
     */
    public function run()
    {
        $eventsPageEnglishAE = PagesTableSeeder::createPage('Events',
            Language::whereCode('en')->first()->id,
            Country::whereCode('AE')->first()->id, 'events', false);

        PagesTableSeeder::createSection(
            $eventsPageEnglishAE->id,
            [
                'title' => 'Events',
                'description' => 'Events',
                'button' => [
                    'title' => 'Back',
                    'icon' => '/images/arrow.png',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::SELF,
            ],
            SectionType::EVENTS_PAGE,
            1
        );


        $eventsPageArabicAE = PagesTableSeeder::createPage('الفعاليات',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('AE')->first()->id, 'events', false);

        PagesTableSeeder::createSection(
            $eventsPageArabicAE->id,
            [
                'title' => 'الفعاليات',
                'description' => 'الفعاليات',
                'button' => [
                    'Back' => 'العودة',
                    'icon' => '/images/arrow.png',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::SELF,
            ],
            SectionType::EVENTS_PAGE,
            1
        );

        $eventsPageEnglishSA = PagesTableSeeder::createPage('Events',
            Language::whereCode('en')->first()->id,
            Country::whereCode('SA')->first()->id, 'events', false);

        PagesTableSeeder::createSection(
            $eventsPageEnglishSA->id,
            [
                'title' => 'Events',
                'description' => 'Events',
                'button' => [
                    'title' => 'Back',
                    'icon' => '/images/arrow.png',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::SELF,
            ],
            SectionType::EVENTS_PAGE,
            1
        );


        $eventsPageArabicSA = PagesTableSeeder::createPage('الفعاليات',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('SA')->first()->id, 'events', false);

        PagesTableSeeder::createSection(
            $eventsPageArabicSA->id,
            [
                'title' => 'الفعاليات',
                'description' => 'الفعاليات',
                'button' => [
                    'Back' => 'العودة',
                    'icon' => '/images/arrow.png',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::SELF,
            ],
            SectionType::EVENTS_PAGE,
            1
        );

        $eventsPageEnglishKW = PagesTableSeeder::createPage('Events',
            Language::whereCode('en')->first()->id,
            Country::whereCode('KW')->first()->id, 'events', false);

        PagesTableSeeder::createSection(
            $eventsPageEnglishKW->id,
            [
                'title' => 'Events',
                'description' => 'Events',
                'button' => [
                    'title' => 'Back',
                    'icon' => '/images/arrow.png',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::SELF,
            ],
            SectionType::EVENTS_PAGE,
            1
        );


        $eventsPageArabicKW = PagesTableSeeder::createPage('الفعاليات',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('KW')->first()->id, 'events', false);

        PagesTableSeeder::createSection(
            $eventsPageArabicKW->id,
            [
                'title' => 'الفعاليات',
                'description' => 'الفعاليات',
                'button' => [
                    'Back' => 'العودة',
                    'icon' => '/images/arrow.png',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::SELF,
            ],
            SectionType::EVENTS_PAGE,
            1
        );


    }
}
