<?php

namespace Database\Seeders;

use App\Enums\SectionType;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class GalleryPageSeeder extends Seeder
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
        $galleryPageEnglishAE = PagesTableSeeder::createPage('Gallery',
            Language::whereCode('en')->first()->id,
            Country::whereCode('AE')->first()->id, 'gallery', false);

        $sectionGalleryEnglish = PagesTableSeeder::createSection(
            $galleryPageEnglishAE->id,
            [
                'title' => 'Gallery',
                'description' => 'Gallery',
                'images' => [
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                ],
            ],
            SectionType::GALLERY_PAGE,
            1
        );

        $galleryPageArabicAE = PagesTableSeeder::createPage('المعرض',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('AE')->first()->id, 'gallery', false);

        $sectionGalleryArabic = PagesTableSeeder::createSection(
            $galleryPageArabicAE->id,
            [
                'title' => 'المعرض',
                'description' => 'المعرض',
                'images' => [
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                ],
            ],
            SectionType::GALLERY_PAGE,
            1
        );

        $galleryPageEnglishSA = PagesTableSeeder::createPage('Gallery',
            Language::whereCode('en')->first()->id,
            Country::whereCode('SA')->first()->id, 'gallery', false);

        $sectionGalleryEnglish = PagesTableSeeder::createSection(
            $galleryPageEnglishSA->id,
            [
                'title' => 'Gallery',
                'description' => 'Gallery',
                'images' => [
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                ],
            ],
            SectionType::GALLERY_PAGE,
            1
        );

        $galleryPageArabicSA = PagesTableSeeder::createPage('المعرض',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('SA')->first()->id, 'gallery', false);

        $sectionGalleryArabic = PagesTableSeeder::createSection(
            $galleryPageArabicSA->id,
            [
                'title' => 'المعرض',
                'description' => 'المعرض',
                'images' => [
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                ],
            ],
            SectionType::GALLERY_PAGE,
            1
        );

        $galleryPageEnglishKW = PagesTableSeeder::createPage('Gallery',
            Language::whereCode('en')->first()->id,
            Country::whereCode('KW')->first()->id, 'gallery', false);

        $sectionGalleryEnglish = PagesTableSeeder::createSection(
            $galleryPageEnglishKW->id,
            [
                'title' => 'Gallery',
                'description' => 'Gallery',
                'images' => [
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                ],
            ],
            SectionType::GALLERY_PAGE,
            1
        );

        $galleryPageArabicKW = PagesTableSeeder::createPage('المعرض',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('KW')->first()->id, 'gallery', false);

        $sectionGalleryArabic = PagesTableSeeder::createSection(
            $galleryPageArabicKW->id,
            [
                'title' => 'المعرض',
                'description' => 'المعرض',
                'images' => [
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                ],
            ],
            SectionType::GALLERY_PAGE,
            1
        );

    }
}
