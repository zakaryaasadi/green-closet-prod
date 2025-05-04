<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\News;
use Illuminate\Database\Seeder;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $UAE = Country::whereCode('AE')->first()->id;
        $KSA = Country::whereCode('SA')->first()->id;
        $KW = Country::whereCode('KW')->first()->id;
        $this->createNews(1, $UAE, [
            'translate' => [
                'title_ar' => 'خبر 1 ',
                'title_en' => 'خبر 1 ',
                'description_ar' => '<p>خبر 1 </p>',
                'description_en' => '<h1>"Charity sdfsdfsdfsdf sdf dsf \ign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createNews(2, $UAE, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createNews(3, $UAE, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createNews(4, $UAE, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);


        $this->createNews(5, $UAE, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createNews(6, $UAE, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createNews(7, $UAE, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createNews(8, $UAE, [
            'translate' => [
                'title_ar' => 'خبر 7.',
                'title_en' => 'news 1 ',
                'description_ar' => 'سيبسيبسيبسيبسيبسيبسيب',
                'description_en' => '<h1 style="color: red;font-weight: bold">Test TesTest TesTest TesTest Tes</h1>',
            ],
        ]);


        $this->createNews(9, $UAE, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);


        $this->createNews(1, $KSA, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createNews(2, $KSA, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createNews(3, $KSA, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createNews(4, $KSA, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);


        $this->createNews(5, $KSA, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);


        $this->createNews(6, $KSA, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);


        $this->createNews(7, $KSA, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createNews(8, $KSA, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createNews(1, $KW, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createNews(2, $KW, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createNews(3, $KW, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createNews(4, $KW, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);


        $this->createNews(5, $KW, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);


        $this->createNews(6, $KW, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createNews(7, $KW, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createNews(8, $KW, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Green Closet Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

    }

    private function createNews($displayOrder, $country_id, $meta): News
    {
        $news = News::create([
            'link' => 'https://twitter.com/kiswaksa?lang=en',
            'display_order' => $displayOrder,
            'alt' => 'Test Test Test',
            'country_id' => $country_id,
            'meta' => $meta,
            'thumbnail' => 'https://kiswauae.com/assets/img/m3.jpg',
            'scripts' => '<script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>
                 <script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>',
        ]);
        $news->slug = strtolower(explode(' ', trim($news->meta['translate']['title_en']))[0] . $news->id);
        $news->save();
        $news->refresh();

        return $news;
    }
}
