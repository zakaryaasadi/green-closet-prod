<?php

namespace Database\Seeders;

use App\Enums\SectionType;
use App\Enums\TargetType;
use App\Models\Country;
use App\Models\Language;
use App\Models\Page;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class PagesTableSeeder extends Seeder
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

        $newsPageEnglishAE = $this->createPage('News Page',
            Language::whereCode('en')->first()->id,
            Country::whereCode('AE')->first()->id, 'news', false);
        $this->createSection(
            $newsPageEnglishAE->id,
            [
                'title' => 'News',
                'description' => 'News',
                'component_target' => TargetType::SELF,
            ],

            SectionType::NEWS_PAGE,
            1
        );

        $newsPageArabicAE = $this->createPage('صفحةالأخبار',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('AE')->first()->id, 'news', false);
        $this->createSection(
            $newsPageArabicAE->id,
            [
                'title' => 'الاخبار',
                'description' => 'اخر الاخبار',
                'component_target' => TargetType::SELF,
            ],
            SectionType::NEWS_PAGE,
            1
        );

        $blogsPageArabicAE = $this->createPage('صفحة المقالات',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('AE')->first()->id, 'blogs', false);
        $this->createSection(
            $blogsPageArabicAE->id,
            [
                'title' => 'المقالات',
                'description' => 'اخر المقالات',
            ],
            SectionType::BLOGS_PAGE,
            1
        );


        $newsPageEnglishSA = $this->createPage('News Page',
            Language::whereCode('en')->first()->id,
            Country::whereCode('SA')->first()->id, 'news', false);
        $this->createSection(
            $newsPageEnglishSA->id,
            [
                'title' => 'News',
                'description' => 'News',
                'component_target' => TargetType::SELF,
            ],

            SectionType::NEWS_PAGE,
            1
        );

        $newsPageArabicSA = $this->createPage('صفحةالأخبار',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('SA')->first()->id, 'news', false);
        $this->createSection(
            $newsPageArabicSA->id,
            [
                'title' => 'الاخبار',
                'description' => 'اخر الاخبار',
                'component_target' => TargetType::SELF,
            ],
            SectionType::NEWS_PAGE,
            1
        );

        $newsPageEnglishKW = $this->createPage('News Page',
            Language::whereCode('en')->first()->id,
            Country::whereCode('KW')->first()->id, 'news', false);
        $this->createSection(
            $newsPageEnglishKW->id,
            [
                'title' => 'News',
                'description' => 'News',
                'component_target' => TargetType::SELF,
            ],

            SectionType::NEWS_PAGE,
            1
        );

        $newsPageArabicKW = $this->createPage('صفحةالأخبار',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('KW')->first()->id, 'news', false);
        $this->createSection(
            $newsPageArabicKW->id,
            [
                'title' => 'الاخبار',
                'description' => 'اخر الاخبار',
                'component_target' => TargetType::SELF,
            ],
            SectionType::NEWS_PAGE,
            1
        );

        $this->createPage('Thanks page',
            Language::whereCode('en')->first()->id,
            Country::whereCode('AE')->first()->id, 'thank-you', false);

        $this->createPage('Thanks page',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('AE')->first()->id, 'thank-you', false);

        $this->createPage('Thanks page',
            Language::whereCode('en')->first()->id,
            Country::whereCode('SA')->first()->id, 'thank-you', false);

        $this->createPage('Thanks page',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('SA')->first()->id, 'thank-you', false);

        $this->createPage('Thanks page',
            Language::whereCode('en')->first()->id,
            Country::whereCode('KW')->first()->id, 'thank-you', false);

        $this->createPage('Thanks page',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('KW')->first()->id, 'thank-you', false);
    }

    public static function createPage($name, $languageId, $countryId, $slug, $isHome): Page
    {
        return Page::create([
            'title' => $name,
            'default_page_title' => 'default_page_title',
            'is_home' => $isHome,
            'slug' => $slug,
            'meta_tags' => [
                'seo_title' => 'title',
                'slug' => 'slug',
                'meta_description' => 'Meta Description',
            ],
            'meta_tags_arabic' => [
                'seo_title' => 'المعرض',
                'slug' => 'slug',
                'meta_description' => 'مجموعة صور',
            ],
            'country_id' => $countryId,
            'language_id' => $languageId,
            'custom_scripts' => '<script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>
                 <script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>',

        ]);

    }

    public static function createSection($pageId, $structure, $type, $sort, $active = true): Section
    {
        return Section::create([
            'page_id' => $pageId,
            'structure' => $structure,
            'type' => $type,
            'sort' => $sort,
            'active' => $active,
        ]);
    }
}
