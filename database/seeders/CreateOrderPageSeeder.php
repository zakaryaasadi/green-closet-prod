<?php

namespace Database\Seeders;

use App\Enums\SectionType;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Database\Seeder;

class CreateOrderPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

//        AE
        $createOrderPageEnglishAE = PagesTableSeeder::createPage('Create order',
            Language::whereCode('en')->first()->id,
            Country::whereCode('AE')->first()->id, 'create-order', false);
        PagesTableSeeder::createSection(
            $createOrderPageEnglishAE->id,
            [],
            SectionType::CREATE_ORDER,
            1
        );

        $createOrderPageArabicAE = PagesTableSeeder::createPage('انشاء طلب تبرع',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('AE')->first()->id, 'create-order', false);
        PagesTableSeeder::createSection(
            $createOrderPageArabicAE->id,

            [],
            SectionType::CREATE_ORDER,
            1
        );

        $createOrderPageEnglishSA = PagesTableSeeder::createPage('Create order',
            Language::whereCode('en')->first()->id,
            Country::whereCode('SA')->first()->id, 'create-order', false);
        PagesTableSeeder::createSection(
            $createOrderPageEnglishSA->id,
            [],
            SectionType::CREATE_ORDER,
            1
        );

        $createOrderPageArabicSA = PagesTableSeeder::createPage('انشاء طلب تبرع',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('SA')->first()->id, 'create-order', false);
        PagesTableSeeder::createSection(
            $createOrderPageArabicSA->id,

            [],
            SectionType::CREATE_ORDER,
            1
        );

        $createOrderPageEnglishKW = PagesTableSeeder::createPage('Create order',
            Language::whereCode('en')->first()->id,
            Country::whereCode('KW')->first()->id, 'create-order', false);
        PagesTableSeeder::createSection(
            $createOrderPageEnglishKW->id,

            [],
            SectionType::CREATE_ORDER,
            1
        );

        $createOrderPageArabicKW = PagesTableSeeder::createPage('انشاء طلب تبرع',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('KW')->first()->id, 'create-order', false);
        PagesTableSeeder::createSection(
            $createOrderPageArabicKW->id,

            [],
            SectionType::CREATE_ORDER,
            1
        );
    }
}
