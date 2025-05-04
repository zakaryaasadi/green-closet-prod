<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Country;
use Illuminate\Database\Seeder;

class BlogTableSeeder extends Seeder
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
        $this->createBlog($UAE, [
            'translate' => [
                'title_ar' => 'خبر 1 ',
                'title_en' => 'خبر 1 ',
                'description_ar' => '<p>خبر 1 </p>',
                'description_en' => '<h1>"Charity sdfsdfsdfsdf sdf dsf \ign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createBlog($UAE, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createBlog($UAE, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createBlog($UAE, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);


        $this->createBlog($UAE, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createBlog($UAE, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createBlog($UAE, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createBlog($UAE, [
            'translate' => [
                'title_ar' => 'خبر 7.',
                'title_en' => 'news 1 ',
                'description_ar' => 'سيبسيبسيبسيبسيبسيبسيب',
                'description_en' => '<h1 style="color: red;font-weight: bold">Test TesTest TesTest TesTest Tes</h1>',
            ],
        ]);


        $this->createBlog($UAE, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);


        $this->createBlog($KSA, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createBlog($KSA, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createBlog($KSA, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createBlog($KSA, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);


        $this->createBlog($KSA, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);


        $this->createBlog($KSA, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);


        $this->createBlog($KSA, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createBlog($KSA, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createBlog($KW, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createBlog($KW, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createBlog($KW, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createBlog($KW, [
            'translate' => [
                'title_ar' => '" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => '<p>" الخيرية لصعوبات التعلم "، و" مؤسسة جرين كلوزيت " توقعان مذكرة تفاهم</p>',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);


        $this->createBlog($KW, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);


        $this->createBlog($KW, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createBlog($KW, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

        $this->createBlog($KW, [
            'translate' => [
                'title_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'title_en' => '"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding',
                'description_ar' => 'وقعت الجمعية الخيرية لصعوبات التعلم امس الأول. الأربعاء مذكرة تفاهم مع مؤسسة ...',
                'description_en' => '<h1>"Charity for Learning Disabilities" and "Kiswa Foundation" sign a memorandum of understanding</h1>',
            ],
        ]);

    }

    private function createBlog($country_id, $meta): void
    {
        $blog = Blog::create([
            'country_id' => $country_id,
            'meta' => $meta,
            'image' => 'https://kiswauae.com/assets/img/m3.jpg',
            'alt' => 'test Blog image',
        ]);
        $blog->slug = strtolower(explode(' ', trim($blog->meta['translate']['title_en']))[0] . $blog->id);
        $blog->save();
        $blog->refresh();

    }
}
