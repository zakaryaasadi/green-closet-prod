<?php

namespace Database\Seeders;

use App\Enums\CardType;
use App\Enums\MediaType;
use App\Enums\SectionType;
use App\Enums\TargetType;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Database\Seeder;

class HomePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $homePageArabicAE = PagesTableSeeder::createPage('الصفحة الرئيسية ',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('AE')->first()->id, '/', true);


        PagesTableSeeder::createSection(
            $homePageArabicAE->id,
            [
                'image' => '/images/sliders/slider2.png',
                'rtl' => false,
                'alt' => 'altsss',
                'title' => 'About Us',
                'contents' => [
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                ],
            ],
            SectionType::IMAGE_CONTENT_SECTION,
            44
        );
        PagesTableSeeder::createSection(
            $homePageArabicAE->id,
            [
                'image' => '/images/sliders/slider2.png',
                'alt' => 'altsss',
                'rtl' => true,
                'title' => 'About Us',
                'contents' => [
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                ],
            ],
            SectionType::IMAGE_CONTENT_SECTION,
            45
        );
        PagesTableSeeder::createSection(
            $homePageArabicAE->id,
            [
                'image' => '/images/sliders/slider2.png',
                'rtl' => false,
                'alt' => 'altsss',
                'title' => 'About Us',
                'contents' => [
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                ],
            ],
            SectionType::IMAGE_CONTENT_SECTION,
            46
        );


        PagesTableSeeder::createSection(
            $homePageArabicAE->id,
            [
                'type' => MediaType::IMAGE,
                'sliders' => [
                    [
                        'src' => '/images/sliders/slider1.png',
                        'title' => 'title slider1',
                        'sub_title' => 'sub_title slider1 ',
                    ],
                    [
                        'src' => 'https://kiswame.com/storage/all_media/croppedImage_20230131132111000.png',
                        'title' => 'title slider 2',
                        'sub_title' => 'sub_title slider 2 ',
                    ],
                    [
                        'src' => '/images/sliders/slider1.png',
                        'title' => 'title slider 3',
                        'sub_title' => 'sub_title slider 3 ',
                    ],

                ],

            ],
            SectionType::CREATE_ORDER_COMPONENT,
            1,
        );
        PagesTableSeeder::createSection(
            $homePageArabicAE->id,
            [
                'title' => 'الاخبار',
                'description' => 'اخر الاخبار',
                'button' => [
                    'title' => 'المزيد من الاخبار',
                    'link' => '/news',
                    'target' => TargetType::SELF,
                ],
                'count' => 8,
                'component_target' => TargetType::SELF,
            ],
            SectionType::NEWS_HOME,
            6
        );
        PagesTableSeeder::createSection(
            $homePageArabicAE->id,
            [
                'title' => 'الأسئلة الشائعة',
                'description' => 'يمكنك التواصل مع فريق خدمة العملاء اذا لم تجد جوابك لسؤالك من الأسئلة الشائعة',
                'faqs' => [
                    [
                        'question' => 'ماهي المدن المتواجدين فيها؟',
                        'answer' => 'جميع أنواع الملابس والأقمشة المستعملة أو التالفة مهما كانت حالتها بالإضافة الى الشنط والأحذية والاكسسوارات والالعاب.',
                    ],
                    [
                        'question' => 'ماهي آلية عمل جرين كلوزيت؟',
                        'answer' => 'جميع أنواع الملابس والأقمشة المستعملة أو التالفة مهما كانت حالتها بالإضافة الى الشنط والأحذية والاكسسوارات والالعاب.',
                    ],
                    [
                        'question' => 'لدي ملابس قديمة جداً او تالفة هل يمكن استقبالها؟',
                        'answer' => 'جميع أنواع الملابس والأقمشة المستعملة أو التالفة مهما كانت حالتها بالإضافة الى الشنط والأحذية والاكسسوارات والالعاب.',
                    ],
                    [
                        'question' => 'لقد ارسلت طلب تبرّع و لم يصل المندوب حتى الآن؟',
                        'answer' => 'جميع أنواع الملابس والأقمشة المستعملة أو التالفة مهما كانت حالتها بالإضافة الى الشنط والأحذية والاكسسوارات والالعاب.',
                    ],
                    [
                        'question' => 'هل أنتم جهة رسمية؟',
                        'answer' => 'جميع أنواع الملابس والأقمشة المستعملة أو التالفة مهما كانت حالتها بالإضافة الى الشنط والأحذية والاكسسوارات والالعاب.',
                    ],
                ],
            ],
            SectionType::FAQS,
            8
        );
        PagesTableSeeder::createSection(
            $homePageArabicAE->id,
            [
                'background' => '/images/About-us-BG.png',
                'title' => 'ساهم معنا في التطلع لحياه افضل',
                'description' => 'حمّل تطبيق جرين كلوزيت الان',
                'apps' => [
                    [
                        'link' => 'android app url',
                        'icon' => '/images/Google_Play_Store_badge_EN 1.png',
                        'target' => TargetType::BLANK,
                    ],
                    [
                        'link' => 'ios app url',
                        'icon' => '/images/Download_on_the_App_Store_Badge 1.png',
                        'target' => TargetType::BLANK,
                    ],
                ],
                'title_contact' => 'تواصل معنا لمزيد من المعلومات',
                'contact' => [
                    [
                        'type' => 'whatsapp',
                        'link' => 'https://api.whatsapp.com/send?phone=966500070201',
                        'number' => '+966 50 007 0201',
                        'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/whatsapp.png',
                        'target' => TargetType::BLANK,
                    ],
                    [
                        'type' => 'call',
                        'link' => 'tel:+966-50-007-0201',
                        'number' => '+966 50 007 0201',
                        'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/call.png',
                        'target' => TargetType::BLANK,
                    ],
                ],
            ],
            SectionType::OUR_APPS_HOME,
            9
        );
        PagesTableSeeder::createSection(
            $homePageArabicAE->id,
            [
                'title' => 'كيف نعمل؟',
                'steps' => [
                    [
                        'title' => 'اطلب الخدمة',
                        'description' => 'تقديم طلب التبرع عبر الموقع الإلكتروني او التطبيق',
                        'buttons' => [
                            [
                                'title' => 'إنشاء طلب',
                                'link' => '/create-order',
                                'target' => TargetType::SELF,
                            ],
                            [
                                'title' => 'تحميل التطبيق',
                                'link' => 'https://www.youtube.com/c/kiswaksa',
                                'target' => TargetType::BLANK,
                            ],
                        ],
                        'image' => '/images/how-we-work/button_one.png',
                    ],
                    [
                        'title' => 'تأكيد الطلب',
                        'description' => 'حمّل تطبيق جرين كلوزيت الان',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_two.png',
                    ],
                    [
                        'title' => 'استلام التبرعات',
                        'description' => 'حمّل تطبيق جرين كلوزيت الان',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_three.png',
                    ],
                    [
                        'title' => 'إعادة التدوير',
                        'description' => 'حمّل تطبيق جرين كلوزيت الان',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_four.png',
                    ],
                    [
                        'title' => 'التوزيع',
                        'description' => 'حمّل تطبيق جرين كلوزيت الان',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_five.png',
                    ],
                ],
            ],
            SectionType::HOW_WE_WORK,
            2
        );
        PagesTableSeeder::createSection(
            $homePageArabicAE->id,
            [
                'background' => '/images/benefits/benefitBG.png',
                'title' => 'فوائد مشروع جرين كلوزيت',
                'cards' => [
                    [
                        'title' => 'فوائد بيئية وحضارية',
                        'description' => 'رمي الملابس يشوه المنظر الجمالي للشوارع ويجعله اكثر عرضه للتلوث البصري والبيئي.',
                        'image' => '/images/benefits/card1.png',
                        'BGColor' => '#E5FFE7',
                    ],
                    [
                        'title' => 'مساعدة الأفراد',
                        'description' => 'الحصول على مكفئآت فورية مقابل فائض ملابسك.',
                        'image' => '/images/benefits/card2.png',
                        'BGColor' => '#FFF7EC',
                    ],
                    [
                        'title' => 'دعم الجمعيات الخيرية',
                        'description' => 'نجمع التبرعات من الملابس و نوصلها للجمعيات الخيرية.',
                        'image' => '/images/benefits/card3.png',
                        'BGColor' => '#EEFBFF',
                    ],
                ],
            ],
            SectionType::KISWA_BENEFITS_HOME,
            4
        );
        PagesTableSeeder::createSection(
            $homePageArabicAE->id,
            [
                'title' => 'عروض جرين كلوزيت',
                'description' => 'بمساعدة شركائنا  يمكنك الاستفادة من نقاطك في الحصول على عروض  تناسبك حياتك اليوميه',
                'button' => [
                    'title' => 'تعرف على عروضنا',
                    'link' => '/offers',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::SELF,
            ],

            SectionType::KISWA_OFFERS_HOME,
            5
        );
        PagesTableSeeder::createSection(
            $homePageArabicAE->id,
            [
                'background' => [
                    'Base' => '/images/partners/BaseBG.png',
                    'second' => '/images/partners/secondBG.png',
                ],
                'title' => 'شركائنا',
                'cards' => [
                    [
                        'type' => CardType::ASSOCIATION,
                        'description' => 'جمعية خيرية',
                        'image' => '/images/partners/card1.png',
                        'BGColor' => '#F3F6FF',
                    ],
                    [
                        'type' => CardType::PARTNER,
                        'description' => 'شركة شريكة',
                        'image' => '/images/partners/card2.png',
                        'BGColor' => '#F3F6FF',
                    ],
                    [
                        'type' => CardType::PARTNER,
                        'description' => 'مؤسسة  حكومية',
                        'image' => '/images/partners/card3.png',
                        'BGColor' => '#F3F6FF',
                    ],
                ],
                'button' => [
                    'title' => 'تعرف على شركائنا',
                    'link' => '/partners',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OUR_PARTNERS_HOME,
            7
        );
        PagesTableSeeder::createSection(
            $homePageArabicAE->id,
            [
                'src' => 'https://lottie.host/a512f5e6-be89-4f6c-b283-38c4c1eba5dd/a4P7xjiGqP.json',
            ],
            SectionType::LOTTIE_SECTION,
            3
        );


        $homePageEnglishAE = PagesTableSeeder::createPage('home page',
            Language::whereCode('en')->first()->id,
            Country::whereCode('AE')->first()->id, '/', true);


        PagesTableSeeder::createSection(
            $homePageEnglishAE->id,
            [
                'image' => '/images/sliders/slider2.png',
                'alt' => 'altsss',
                'contents' => [
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                    [
                        'title' => 'About Us',
                        'description' => '<p>Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.</p>',
                        'image' => '/images/benefits/card1.png',
                    ],
                ],
            ],
            SectionType::IMAGE_CONTENT_SECTION,
            3
        );

        PagesTableSeeder::createSection(
            $homePageEnglishAE->id,
            [
                'sliders' => [
                    [
                        'image' => '/images/sliders/slider1.png',
                        'title' => 'Contribute now to protect the environment',
                        'sub_title' => 'Kiswa is a project to benefit from surplus used clothes and deliver them to those who need them',
                        'description' => 'Make your order now, and our agent will reach you to receive your surplus clothes',
                        'button' => [
                            'title' => 'CTA - Button',
                            'link' => '',
                            'target' => TargetType::SELF,
                        ],
                    ],
                    [
                        'image' => '/images/sliders/slider2.png',
                        'title' => 'Contribute now to protect the environment',
                        'sub_title' => 'Kiswa is a project to benefit from surplus used clothes and deliver them to those who need them',
                        'description' => 'Make your order now, and our agent will reach you to receive your surplus clothes',
                        'button' => [
                            'title' => 'CTA - Button',
                            'link' => '',
                            'target' => TargetType::SELF,
                        ],
                    ],
                    [
                        'image' => '/images/sliders/slider3.png',
                        'title' => 'Contribute now to protect the environment',
                        'sub_title' => 'Kiswa is a project to benefit from surplus used clothes and deliver them to those who need them',
                        'description' => 'Make your order now, and our agent will reach you to receive your surplus clothes',
                        'button' => [
                            'title' => 'CTA - Button',
                            'link' => '',
                            'target' => TargetType::SELF,
                        ],
                    ],

                ],
            ],
            SectionType::IMAGE_SLIDER_HEADER,
            1,
        );
        PagesTableSeeder::createSection(
            $homePageEnglishAE->id,
            [
                'type' => MediaType::IMAGE,
                'sliders' => [
                    [
                        'src' => '/images/sliders/slider1.png',
                        'title' => 'title slider1',
                        'sub_title' => 'sub_title slider1 ',
                    ],
                    [
                        'src' => 'https://kiswame.com/storage/all_media/croppedImage_20230131132111000.png',
                        'title' => 'title slider 2',
                        'sub_title' => 'sub_title slider 2 ',
                    ],
                    [
                        'src' => '/images/sliders/slider1.png',
                        'title' => 'title slider 3',
                        'sub_title' => 'sub_title slider 3 ',
                    ],

                ],

            ],
            SectionType::CREATE_ORDER_COMPONENT,
            1,
        );
        PagesTableSeeder::createSection(
            $homePageEnglishAE->id,
            [
                'title' => 'News',
                'description' => 'Latest News',
                'button' => [
                    'title' => 'Show more',
                    'link' => '/news',
                    'target' => TargetType::SELF,
                ],
                'count' => 8,
                'component_target' => TargetType::SELF,
            ],
            SectionType::NEWS_HOME,
            6
        );
        PagesTableSeeder::createSection(
            $homePageEnglishAE->id,
            [
                'title' => 'FAQS',
                'description' => 'You can contact the customer service team if you do not find the answer to your question from the FAQS',

                'faqs' => [
                    [
                        'question' => 'What cities are we in?',
                        'answer' => 'You can contact the customer service team if you do not find the answer to your question from the FAQS',
                    ],
                    [
                        'question' => 'How we work?',
                        'answer' => 'You can contact the customer service team if you do not find the answer to your question from the FAQS',
                    ],
                    [
                        'question' => 'I have very old or damaged clothes, can I receive them?',
                        'answer' => 'You can contact the customer service team if you do not find the answer to your question from the FAQS',
                    ],
                    [
                        'question' => 'I sent a donation request and the agent has not arrived yet?',
                        'answer' => 'You can contact the customer service team if you do not find the answer to your question from the FAQS',
                    ],
                    [
                        'question' => 'Are we an official organization?',
                        'answer' => 'You can contact the customer service team if you do not find the answer to your question from the FAQS',
                    ],
                ],
            ],
            SectionType::FAQS,
            8
        );
        PagesTableSeeder::createSection(
            $homePageEnglishAE->id,
            [
                'background' => '/images/About-us-BG.png',
                'title' => 'Help us in looking forward to a better life',
                'description' => 'Download kiswa app now',
                'apps' => [
                    [
                        'link' => 'android app url',
                        'icon' => '/images/Google_Play_Store_badge_EN 1.png',
                        'target' => TargetType::BLANK,
                    ],
                    [
                        'link' => 'ios app url',
                        'icon' => '/images/Download_on_the_App_Store_Badge 1.png',
                        'target' => TargetType::BLANK,
                    ],
                ],
                'title_contact' => 'contact us',
                'contact' => [
                    [
                        'type' => 'whatsapp',
                        'link' => 'https://api.whatsapp.com/send?phone=966500070201',
                        'number' => '+966 50 007 0201',
                        'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/whatsapp.png',
                        'target' => TargetType::BLANK,
                    ],
                    [
                        'type' => 'call',
                        'link' => 'tel:+966-50-007-0201',
                        'number' => '+966 50 007 0201',
                        'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/call.png',
                        'target' => TargetType::BLANK,
                    ],
                ],
            ],
            SectionType::OUR_APPS_HOME,
            9
        );
        PagesTableSeeder::createSection(
            $homePageEnglishAE->id,
            [
                'title' => 'How We work ?',
                'steps' => [
                    [
                        'title' => 'Make order',
                        'description' => 'You can make order via App or website',
                        'buttons' => [
                            [
                                'title' => 'Create Order',
                                'link' => '/create-order',
                                'target' => TargetType::SELF,
                            ],
                            [
                                'title' => 'Download App',
                                'link' => 'https://www.youtube.com/c/kiswaksa',
                                'target' => TargetType::BLANK,
                            ],
                        ],
                        'image' => '/images/how-we-work/button_one.png',
                    ],
                    [
                        'title' => 'Confirm order',
                        'description' => 'Download App now',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_two.png',
                    ],
                    [
                        'title' => 'Receive Donations',
                        'description' => 'Download App now',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_three.png',
                    ],
                    [
                        'title' => 'Recycling',
                        'description' => 'Download App now',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_four.png',
                    ],
                    [
                        'title' => 'Distribution',
                        'description' => 'Download App now',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_five.png',
                    ],
                ],
            ],
            SectionType::HOW_WE_WORK,
            2
        );
        PagesTableSeeder::createSection(
            $homePageEnglishAE->id,
            [
                'background' => '/images/benefits/benefitBG.png',
                'title' => 'kiswa benefits',
                'cards' => [
                    [
                        'title' => 'Environmental and cultural benefits',
                        'description' => 'Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.',
                        'image' => '/images/benefits/card1.png',
                        'BGColor' => '#E5FFE7',
                    ],
                    [
                        'title' => 'Helping people',
                        'description' => 'Get instant rewards for your surplus clothes.',
                        'image' => '/images/benefits/card2.png',
                        'BGColor' => '#FFF7EC',
                    ],
                    [
                        'title' => 'Supporting charities',
                        'description' => 'We collect donations of clothes and deliver them to charities.',
                        'image' => '/images/benefits/card3.png',
                        'BGColor' => '#EEFBFF',
                    ],
                ],
            ],
            SectionType::KISWA_BENEFITS_HOME,
            4
        );
        PagesTableSeeder::createSection(
            $homePageEnglishAE->id,
            [
                'title' => 'Kiswa offers',
                'description' => 'With the help of our partners, you can use your points to get offers that suit your daily life',
                'button' => [
                    'title' => 'View our offers',
                    'link' => '/offers',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::SELF,
            ],
            SectionType::KISWA_OFFERS_HOME,
            5
        );
        PagesTableSeeder::createSection(
            $homePageEnglishAE->id,
            [
                'background' => [
                    'Base' => '/images/partners/BaseBG.png',
                    'second' => '/images/partners/secondBG.png',
                ],
                'title' => 'Our partners',
                'cards' => [
                    [
                        'type' => CardType::ASSOCIATION,
                        'description' => 'Charity',
                        'image' => '/images/partners/card1.png',
                        'BGColor' => '#F3F6FF',
                    ],
                    [
                        'type' => CardType::PARTNER,
                        'description' => 'Partner Company',
                        'image' => '/images/partners/card2.png',
                        'BGColor' => '#F3F6FF',
                    ],
                    [
                        'type' => CardType::PARTNER,
                        'description' => 'Governmental institution',
                        'image' => '/images/partners/card3.png',
                        'BGColor' => '#F3F6FF',
                    ],
                ],
                'button' => [
                    'title' => 'View our partners',
                    'link' => '/partners',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OUR_PARTNERS_HOME,
            7
        );
        PagesTableSeeder::createSection(
            $homePageEnglishAE->id,
            [
                'src' => 'https://lottie.host/a512f5e6-be89-4f6c-b283-38c4c1eba5dd/a4P7xjiGqP.json',
            ],
            SectionType::LOTTIE_SECTION,
            3
        );


        $homePageArabicSA = PagesTableSeeder::createPage('الصفحة الرئيسية ',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('SA')->first()->id, '/', true);
        PagesTableSeeder::createSection(
            $homePageArabicSA->id,
            [
                'type' => MediaType::IMAGE,
                'sliders' => [
                    [
                        'src' => '/images/sliders/slider1.png',
                        'title' => 'title slider1',
                        'sub_title' => 'sub_title slider1 ',
                    ],
                    [
                        'src' => 'https://kiswame.com/storage/all_media/croppedImage_20230131132111000.png',
                        'title' => 'title slider 2',
                        'sub_title' => 'sub_title slider 2 ',
                    ],
                    [
                        'src' => '/images/sliders/slider1.png',
                        'title' => 'title slider 3',
                        'sub_title' => 'sub_title slider 3 ',
                    ],

                ],

            ],
            SectionType::CREATE_ORDER_COMPONENT,
            1,
        );
        PagesTableSeeder::createSection(
            $homePageArabicSA->id,
            [
                'title' => 'الاخبار',
                'description' => 'اخر الاخبار',
                'button' => [
                    'title' => 'المزيد من الاخبار',
                    'link' => '/news',
                    'target' => TargetType::SELF,
                ],
                'count' => 8,
                'component_target' => TargetType::SELF,
            ],
            SectionType::NEWS_HOME,
            6
        );
        PagesTableSeeder::createSection(
            $homePageArabicSA->id,
            [
                'title' => 'الأسئلة الشائعة',
                'description' => 'يمكنك التواصل مع فريق خدمة العملاء اذا لم تجد جوابك لسؤالك من الأسئلة الشائعة',
                'faqs' => [
                    [
                        'question' => 'ماهي المدن المتواجدين فيها؟',
                        'answer' => 'جميع أنواع الملابس والأقمشة المستعملة أو التالفة مهما كانت حالتها بالإضافة الى الشنط والأحذية والاكسسوارات والالعاب.',
                    ],
                    [
                        'question' => 'ماهي آلية عمل جرين كلوزيت؟',
                        'answer' => 'جميع أنواع الملابس والأقمشة المستعملة أو التالفة مهما كانت حالتها بالإضافة الى الشنط والأحذية والاكسسوارات والالعاب.',
                    ],
                    [
                        'question' => 'لدي ملابس قديمة جداً او تالفة هل يمكن استقبالها؟',
                        'answer' => 'جميع أنواع الملابس والأقمشة المستعملة أو التالفة مهما كانت حالتها بالإضافة الى الشنط والأحذية والاكسسوارات والالعاب.',
                    ],
                    [
                        'question' => 'لقد ارسلت طلب تبرّع و لم يصل المندوب حتى الآن؟',
                        'answer' => 'جميع أنواع الملابس والأقمشة المستعملة أو التالفة مهما كانت حالتها بالإضافة الى الشنط والأحذية والاكسسوارات والالعاب.',
                    ],
                    [
                        'question' => 'هل أنتم جهة رسمية؟',
                        'answer' => 'جميع أنواع الملابس والأقمشة المستعملة أو التالفة مهما كانت حالتها بالإضافة الى الشنط والأحذية والاكسسوارات والالعاب.',
                    ],
                ],
            ],
            SectionType::FAQS,
            8
        );
        PagesTableSeeder::createSection(
            $homePageArabicSA->id,
            [
                'background' => '/images/About-us-BG.png',
                'title' => 'ساهم معنا في التطلع لحياه افضل',
                'description' => 'حمّل تطبيق جرين كلوزيت الان',
                'apps' => [
                    [
                        'link' => 'android app url',
                        'icon' => '/images/Google_Play_Store_badge_EN 1.png',
                        'target' => TargetType::BLANK,
                    ],
                    [
                        'link' => 'ios app url',
                        'icon' => '/images/Download_on_the_App_Store_Badge 1.png',
                        'target' => TargetType::BLANK,
                    ],
                ],
                'title_contact' => 'تواصل معنا لمزيد من المعلومات',
                'contact' => [
                    [
                        'type' => 'whatsapp',
                        'link' => 'https://api.whatsapp.com/send?phone=966500070201',
                        'number' => '+966 50 007 0201',
                        'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/whatsapp.png',
                        'target' => TargetType::BLANK,
                    ],
                    [
                        'type' => 'call',
                        'link' => 'tel:+966-50-007-0201',
                        'number' => '+966 50 007 0201',
                        'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/call.png',
                        'target' => TargetType::BLANK,
                    ],
                ],
            ],
            SectionType::OUR_APPS_HOME,
            9
        );
        PagesTableSeeder::createSection(
            $homePageArabicSA->id,
            [
                'title' => 'كيف نعمل؟',
                'steps' => [
                    [
                        'title' => 'اطلب الخدمة',
                        'description' => 'تقديم طلب التبرع عبر الموقع الإلكتروني او التطبيق',
                        'buttons' => [
                            [
                                'title' => 'Create Order',
                                'link' => '/create-order',
                                'target' => TargetType::SELF,
                            ],
                            [
                                'title' => 'Download App',
                                'link' => 'https://www.youtube.com/c/kiswaksa',
                                'target' => TargetType::BLANK,
                            ],
                        ],
                        'image' => '/images/how-we-work/button_one.png',
                    ],
                    [
                        'title' => 'تأكيد الطلب',
                        'description' => 'حمّل تطبيق جرين كلوزيت الان',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_two.png',
                    ],
                    [
                        'title' => 'استلام التبرعات',
                        'description' => 'حمّل تطبيق جرين كلوزيت الان',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_three.png',
                    ],
                    [
                        'title' => 'إعادة التدوير',
                        'description' => 'حمّل تطبيق جرين كلوزيت الان',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_four.png',
                    ],
                    [
                        'title' => 'التوزيع',
                        'description' => 'حمّل تطبيق جرين كلوزيت الان',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_five.png',
                    ],
                ],
            ],
            SectionType::HOW_WE_WORK,
            2
        );
        PagesTableSeeder::createSection(
            $homePageArabicSA->id,
            [
                'background' => '/images/benefits/benefitBG.png',
                'title' => 'فوائد مشروع جرين كلوزيت',
                'cards' => [
                    [
                        'title' => 'فوائد بيئية وحضارية',
                        'description' => 'رمي الملابس يشوه المنظر الجمالي للشوارع ويجعله اكثر عرضه للتلوث البصري والبيئي.',
                        'image' => '/images/benefits/card1.png',
                        'BGColor' => '#E5FFE7',
                    ],
                    [
                        'title' => 'مساعدة الأفراد',
                        'description' => 'الحصول على مكفئآت فورية مقابل فائض ملابسك.',
                        'image' => '/images/benefits/card2.png',
                        'BGColor' => '#FFF7EC',
                    ],
                    [
                        'title' => 'دعم الجمعيات الخيرية',
                        'description' => 'نجمع التبرعات من الملابس و نوصلها للجمعيات الخيرية.',
                        'image' => '/images/benefits/card3.png',
                        'BGColor' => '#EEFBFF',
                    ],
                ],
            ],
            SectionType::KISWA_BENEFITS_HOME,
            4
        );
        PagesTableSeeder::createSection(
            $homePageArabicSA->id,
            [
                'title' => 'عروض جرين كلوزيت',
                'description' => 'بمساعدة شركائنا  يمكنك الاستفادة من نقاطك في الحصول على عروض  تناسبك حياتك اليوميه',
                'button' => [
                    'title' => 'تعرف على عروضنا',
                    'link' => '/offers',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::SELF,
            ],
            SectionType::KISWA_OFFERS_HOME,
            5
        );
        PagesTableSeeder::createSection(
            $homePageArabicSA->id,
            [
                'background' => [
                    'Base' => '/images/partners/BaseBG.png',
                    'second' => '/images/partners/secondBG.png',
                ],
                'title' => 'شركائنا',
                'cards' => [
                    [
                        'type' => CardType::ASSOCIATION,
                        'description' => 'جمعية خيرية',
                        'image' => '/images/partners/card1.png',
                        'BGColor' => '#F3F6FF',
                    ],
                    [
                        'type' => CardType::PARTNER,
                        'description' => 'شركة شريكة',
                        'image' => '/images/partners/card2.png',
                        'BGColor' => '#F3F6FF',
                    ],
                    [
                        'type' => CardType::PARTNER,
                        'description' => 'مؤسسة  حكومية',
                        'image' => '/images/partners/card3.png',
                        'BGColor' => '#F3F6FF',
                    ],
                ],
                'button' => [
                    'title' => 'تعرف على شركائنا',
                    'link' => '/partners',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OUR_PARTNERS_HOME,
            7
        );
        PagesTableSeeder::createSection(
            $homePageArabicSA->id,
            [
                'src' => 'https://lottie.host/a512f5e6-be89-4f6c-b283-38c4c1eba5dd/a4P7xjiGqP.json',
            ],
            SectionType::LOTTIE_SECTION,
            3
        );

        $homePageEnglishSA = PagesTableSeeder::createPage('home page',
            Language::whereCode('en')->first()->id,
            Country::whereCode('SA')->first()->id, '/', true);
        PagesTableSeeder::createSection(
            $homePageEnglishSA->id,
            [
                'video' => [
                    'link' => '/images/banner.mp4',
                    'icon' => '/images/play.png',
                    'text' => 'Play video',
                ],
                'title' => 'Contribute now to protect the environment',
                'sub_title' => 'Kiswa is a project to benefit from surplus used clothes and deliver them to those who need them',
                'description' => 'Make your order now, and our agent will reach you to receive your surplus clothes',
                'button' => [
                    'title' => 'CTA - Button',
                    'link' => '',
                    'target' => TargetType::SELF,
                ],
            ],
            SectionType::VIDEO_BANNER,
            1,
        );
        PagesTableSeeder::createSection(
            $homePageEnglishSA->id,
            [
                'title' => 'News',
                'description' => 'Latest News',
                'button' => [
                    'title' => 'Show more',
                    'link' => '/news',
                    'target' => TargetType::SELF,
                ],
                'count' => 8,
                'component_target' => TargetType::SELF,
            ],

            SectionType::NEWS_HOME,
            6
        );
        PagesTableSeeder::createSection(
            $homePageEnglishSA->id,
            [
                'title' => 'FAQS',
                'description' => 'You can contact the customer service team if you do not find the answer to your question from the FAQS',

                'faqs' => [
                    [
                        'question' => 'What cities are we in?',
                        'answer' => 'You can contact the customer service team if you do not find the answer to your question from the FAQS',
                    ],
                    [
                        'question' => 'How we work?',
                        'answer' => 'You can contact the customer service team if you do not find the answer to your question from the FAQS',
                    ],
                    [
                        'question' => 'I have very old or damaged clothes, can I receive them?',
                        'answer' => 'You can contact the customer service team if you do not find the answer to your question from the FAQS',
                    ],
                    [
                        'question' => 'I sent a donation request and the agent has not arrived yet?',
                        'answer' => 'You can contact the customer service team if you do not find the answer to your question from the FAQS',
                    ],
                    [
                        'question' => 'Are we an official organization?',
                        'answer' => 'You can contact the customer service team if you do not find the answer to your question from the FAQS',
                    ],
                ],
            ],
            SectionType::FAQS,
            8
        );
        PagesTableSeeder::createSection(
            $homePageEnglishSA->id,
            [
                'background' => '/images/About-us-BG.png',
                'title' => 'Help us in looking forward to a better life',
                'description' => 'Download kiswa app now',
                'apps' => [
                    [
                        'link' => 'android app url',
                        'icon' => '/images/Google_Play_Store_badge_EN 1.png',
                        'target' => TargetType::BLANK,
                    ],
                    [
                        'link' => 'ios app url',
                        'icon' => '/images/Download_on_the_App_Store_Badge 1.png',
                        'target' => TargetType::BLANK,
                    ],
                ],
                'title_contact' => 'contact us',
                'contact' => [
                    [
                        'type' => 'whatsapp',
                        'link' => 'https://api.whatsapp.com/send?phone=966500070201',
                        'number' => '+966 50 007 0201',
                        'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/whatsapp.png',
                        'target' => TargetType::BLANK,
                    ],
                    [
                        'type' => 'call',
                        'link' => 'tel:+966-50-007-0201',
                        'number' => '+966 50 007 0201',
                        'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/call.png',
                        'target' => TargetType::BLANK,
                    ],
                ],
            ],
            SectionType::OUR_APPS_HOME,
            9
        );
        PagesTableSeeder::createSection(
            $homePageEnglishSA->id,
            [
                'title' => 'How We work ?',
                'steps' => [
                    [
                        'title' => 'Make order',
                        'description' => 'You can make order via App or website',
                        'buttons' => [
                            [
                                'title' => 'Create Order',
                                'link' => '/create-order',
                                'target' => TargetType::SELF,
                            ],
                            [
                                'title' => 'Download App',
                                'link' => 'https://www.youtube.com/c/kiswaksa',
                                'target' => TargetType::BLANK,
                            ],
                        ],
                        'image' => '/images/how-we-work/button_one.png',
                    ],
                    [
                        'title' => 'Confirm order',
                        'description' => 'Download App now',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_two.png',
                    ],
                    [
                        'title' => 'Receive Donations',
                        'description' => 'Download App now',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_three.png',
                    ],
                    [
                        'title' => 'Recycling',
                        'description' => 'Download App now',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_four.png',
                    ],
                    [
                        'title' => 'Distribution',
                        'description' => 'Download App now',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_five.png',
                    ],
                ],
            ],
            SectionType::HOW_WE_WORK,
            2
        );
        PagesTableSeeder::createSection(
            $homePageEnglishSA->id,
            [
                'background' => '/images/benefits/benefitBG.png',
                'title' => 'kiswa benefits',
                'cards' => [
                    [
                        'title' => 'Environmental and cultural benefits',
                        'description' => 'Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.',
                        'image' => '/images/benefits/card1.png',
                        'BGColor' => '#E5FFE7',
                    ],
                    [
                        'title' => 'Helping people',
                        'description' => 'Get instant rewards for your surplus clothes.',
                        'image' => '/images/benefits/card2.png',
                        'BGColor' => '#FFF7EC',
                    ],
                    [
                        'title' => 'Supporting charities',
                        'description' => 'We collect donations of clothes and deliver them to charities.',
                        'image' => '/images/benefits/card3.png',
                        'BGColor' => '#EEFBFF',
                    ],
                ],
            ],
            SectionType::KISWA_BENEFITS_HOME,
            4
        );
        PagesTableSeeder::createSection(
            $homePageEnglishSA->id,
            [
                'title' => 'Kiswa offers',
                'description' => 'With the help of our partners, you can use your points to get offers that suit your daily life',
                'button' => [
                    'title' => 'View our offers',
                    'link' => '/offers',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::SELF,
            ],
            SectionType::KISWA_OFFERS_HOME,
            5
        );
        PagesTableSeeder::createSection(
            $homePageEnglishSA->id,
            [
                'background' => [
                    'Base' => '/images/partners/BaseBG.png',
                    'second' => '/images/partners/secondBG.png',
                ],
                'title' => 'Our partners',
                'cards' => [
                    [
                        'type' => CardType::ASSOCIATION,
                        'description' => 'Charity',
                        'image' => '/images/partners/card1.png',
                        'BGColor' => '#F3F6FF',
                    ],
                    [
                        'type' => CardType::PARTNER,
                        'description' => 'Partner Company',
                        'image' => '/images/partners/card2.png',
                        'BGColor' => '#F3F6FF',
                    ],
                    [
                        'type' => CardType::PARTNER,
                        'description' => 'Governmental institution',
                        'image' => '/images/partners/card3.png',
                        'BGColor' => '#F3F6FF',
                    ],
                ],
                'button' => [
                    'title' => 'View our partners',
                    'link' => '/partners',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OUR_PARTNERS_HOME,
            7
        );
        PagesTableSeeder::createSection(
            $homePageEnglishSA->id,
            [
                'src' => 'https://lottie.host/a512f5e6-be89-4f6c-b283-38c4c1eba5dd/a4P7xjiGqP.json',
            ],
            SectionType::LOTTIE_SECTION,
            3
        );


        $homePageArabicKW = PagesTableSeeder::createPage('الصفحة الرئيسية ',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('KW')->first()->id, '/', true);
        PagesTableSeeder::createSection(
            $homePageArabicKW->id,
            [
                'image' => '/images/sliders/slider1.png',
                'title' => 'ساهم بالحفاظ على البيئة',
                'sub_title' => 'جرين كلوزيت هو مشروع للاستفادة من فائض الملابس المستعملة وايصالها لمن هو بحاجة لها',
                'description' => 'قم بإنشاء طلبك الآن ,وسوف يصلك مندوبنا لاستلام فائض ملابسكم',
                'button' => [
                    [
                        'title' => 'إنشاء طلب',
                        'link' => '/create-order',
                        'target' => TargetType::SELF,
                    ],
                ],
                'cards' => [
                    [
                        'title' => 'شركة',
                        'type' => CardType::PARTNER,
                        'total' => '424,100',
                        'image' => '/images/company.png',
                        'BGColor' => '#FFECFD',
                    ],
                    [
                        'title' => 'قطعة',
                        'type' => CardType::DONATIONS_ITEMS,
                        'total' => '424,100',
                        'image' => '/images/recycle.png',
                        'BGColor' => '#FFF7EC',
                    ],
                    [
                        'title' => 'قطعة',
                        'type' => CardType::RYCICLING_ITEMS,
                        'total' => '424,100',
                        'image' => '/images/clothe.png',
                        'BGColor' => '#D4FFD8',
                    ],
                    [
                        'title' => 'تبرع',
                        'type' => CardType::DONATIONS,
                        'total' => '424,100',
                        'image' => '/images/donate.png',
                        'BGColor' => '#F8FFEC',
                    ],
                ],
            ],
            SectionType::CARDS_HOME,
            1,
        );
        PagesTableSeeder::createSection(
            $homePageArabicKW->id,
            [
                'title' => 'الاخبار',
                'description' => 'اخر الاخبار',
                'button' => [
                    'title' => 'المزيد من الاخبار',
                    'link' => '/news',
                    'target' => TargetType::SELF,
                ],
                'count' => 8,
                'component_target' => TargetType::SELF,
            ],
            SectionType::NEWS_HOME,
            6
        );
        PagesTableSeeder::createSection(
            $homePageArabicKW->id,
            [
                'title' => 'الأسئلة الشائعة',
                'description' => 'يمكنك التواصل مع فريق خدمة العملاء اذا لم تجد جوابك لسؤالك من الأسئلة الشائعة',
                'faqs' => [
                    [
                        'question' => 'ماهي المدن المتواجدين فيها؟',
                        'answer' => 'جميع أنواع الملابس والأقمشة المستعملة أو التالفة مهما كانت حالتها بالإضافة الى الشنط والأحذية والاكسسوارات والالعاب.',
                    ],
                    [
                        'question' => 'ماهي آلية عمل جرين كلوزيت؟',
                        'answer' => 'جميع أنواع الملابس والأقمشة المستعملة أو التالفة مهما كانت حالتها بالإضافة الى الشنط والأحذية والاكسسوارات والالعاب.',
                    ],
                    [
                        'question' => 'لدي ملابس قديمة جداً او تالفة هل يمكن استقبالها؟',
                        'answer' => 'جميع أنواع الملابس والأقمشة المستعملة أو التالفة مهما كانت حالتها بالإضافة الى الشنط والأحذية والاكسسوارات والالعاب.',
                    ],
                    [
                        'question' => 'لقد ارسلت طلب تبرّع و لم يصل المندوب حتى الآن؟',
                        'answer' => 'جميع أنواع الملابس والأقمشة المستعملة أو التالفة مهما كانت حالتها بالإضافة الى الشنط والأحذية والاكسسوارات والالعاب.',
                    ],
                    [
                        'question' => 'هل أنتم جهة رسمية؟',
                        'answer' => 'جميع أنواع الملابس والأقمشة المستعملة أو التالفة مهما كانت حالتها بالإضافة الى الشنط والأحذية والاكسسوارات والالعاب.',
                    ],
                ],
            ],
            SectionType::FAQS,
            8
        );
        PagesTableSeeder::createSection(
            $homePageArabicKW->id,
            [
                'background' => '/images/About-us-BG.png',
                'title' => 'ساهم معنا في التطلع لحياه افضل',
                'description' => 'حمّل تطبيق جرين كلوزيت الان',
                'apps' => [
                    [
                        'link' => 'android app url',
                        'icon' => '/images/Google_Play_Store_badge_EN 1.png',
                        'target' => TargetType::BLANK,
                    ],
                    [
                        'link' => 'ios app url',
                        'icon' => '/images/Download_on_the_App_Store_Badge 1.png',
                        'target' => TargetType::BLANK,
                    ],
                ],
                'title_contact' => 'تواصل معنا لمزيد من المعلومات',
                'contact' => [
                    [
                        'type' => 'whatsapp',
                        'link' => 'https://api.whatsapp.com/send?phone=966500070201',
                        'number' => '+966 50 007 0201',
                        'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/whatsapp.png',
                        'target' => TargetType::BLANK,
                    ],
                    [
                        'type' => 'call',
                        'link' => 'tel:+966-50-007-0201',
                        'number' => '+966 50 007 0201',
                        'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/call.png',
                        'target' => TargetType::BLANK,
                    ],
                ],
            ],
            SectionType::OUR_APPS_HOME,
            9
        );
        PagesTableSeeder::createSection(
            $homePageArabicKW->id,
            [
                'title' => 'كيف نعمل؟',
                'steps' => [
                    [
                        'title' => 'اطلب الخدمة',
                        'description' => 'تقديم طلب التبرع عبر الموقع الإلكتروني او التطبيق',
                        'buttons' => [
                            [
                                'title' => 'إنشاء طلب',
                                'link' => '/create-order',
                                'target' => TargetType::SELF,
                            ],
                            [
                                'title' => 'تحميل التطبيق',
                                'link' => 'https://www.youtube.com/c/kiswaksa',
                                'target' => TargetType::BLANK,
                            ],
                        ],
                        'image' => '/images/how-we-work/button_one.png',
                    ],
                    [
                        'title' => 'تأكيد الطلب',
                        'description' => 'حمّل تطبيق جرين كلوزيت الان',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_two.png',
                    ],
                    [
                        'title' => 'استلام التبرعات',
                        'description' => 'حمّل تطبيق جرين كلوزيت الان',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_three.png',
                    ],
                    [
                        'title' => 'إعادة التدوير',
                        'description' => 'حمّل تطبيق جرين كلوزيت الان',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_four.png',
                    ],
                    [
                        'title' => 'التوزيع',
                        'description' => 'حمّل تطبيق جرين كلوزيت الان',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_five.png',
                    ],
                ],
            ],
            SectionType::HOW_WE_WORK,
            2
        );
        PagesTableSeeder::createSection(
            $homePageArabicKW->id,
            [
                'background' => '/images/benefits/benefitBG.png',
                'title' => 'فوائد مشروع جرين كلوزيت',
                'cards' => [
                    [
                        'title' => 'فوائد بيئية وحضارية',
                        'description' => 'رمي الملابس يشوه المنظر الجمالي للشوارع ويجعله اكثر عرضه للتلوث البصري والبيئي.',
                        'image' => '/images/benefits/card1.png',
                        'BGColor' => '#E5FFE7',
                    ],
                    [
                        'title' => 'مساعدة الأفراد',
                        'description' => 'الحصول على مكفئآت فورية مقابل فائض ملابسك.',
                        'image' => '/images/benefits/card2.png',
                        'BGColor' => '#FFF7EC',
                    ],
                    [
                        'title' => 'دعم الجمعيات الخيرية',
                        'description' => 'نجمع التبرعات من الملابس و نوصلها للجمعيات الخيرية.',
                        'image' => '/images/benefits/card3.png',
                        'BGColor' => '#EEFBFF',
                    ],
                ],
            ],
            SectionType::KISWA_BENEFITS_HOME,
            4
        );
        PagesTableSeeder::createSection(
            $homePageArabicKW->id,
            [
                'title' => 'عروض جرين كلوزيت',
                'description' => 'بمساعدة شركائنا  يمكنك الاستفادة من نقاطك في الحصول على عروض  تناسبك حياتك اليوميه',
                'button' => [
                    'title' => 'تعرف على عروضنا',
                    'link' => '/offers',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::SELF,
            ],
            SectionType::KISWA_OFFERS_HOME,
            5
        );
        PagesTableSeeder::createSection(
            $homePageArabicKW->id,
            [
                'background' => [
                    'Base' => '/images/partners/BaseBG.png',
                    'second' => '/images/partners/secondBG.png',
                ],
                'title' => 'شركائنا',
                'cards' => [
                    [
                        'type' => CardType::ASSOCIATION,
                        'description' => 'جمعية خيرية',
                        'image' => '/images/partners/card1.png',
                        'BGColor' => '#F3F6FF',
                    ],
                    [
                        'type' => CardType::PARTNER,
                        'description' => 'شركة شريكة',
                        'image' => '/images/partners/card2.png',
                        'BGColor' => '#F3F6FF',
                    ],
                    [
                        'type' => CardType::PARTNER,
                        'description' => 'مؤسسة  حكومية',
                        'image' => '/images/partners/card3.png',
                        'BGColor' => '#F3F6FF',
                    ],
                ],
                'button' => [
                    'title' => 'تعرف على شركائنا',
                    'link' => '/partners',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OUR_PARTNERS_HOME,
            7
        );
        PagesTableSeeder::createSection(
            $homePageArabicKW->id,
            [
                'src' => 'https://lottie.host/a512f5e6-be89-4f6c-b283-38c4c1eba5dd/a4P7xjiGqP.json',
            ],
            SectionType::LOTTIE_SECTION,
            3
        );


        $homePageEnglishKW = PagesTableSeeder::createPage('home page',
            Language::whereCode('en')->first()->id,
            Country::whereCode('KW')->first()->id, '/', true);
        PagesTableSeeder::createSection(
            $homePageEnglishKW->id,
            [
                'image' => '/images/sliders/slider1.png',
                'title' => 'Contribute now to protect the environment',
                'sub_title' => 'Kiswa is a project to benefit from surplus used clothes and deliver them to those who need them',
                'description' => 'Make your order now, and our agent will reach you to receive your surplus clothes',
                'button' => [
                    [
                        'title' => 'Create Order',
                        'link' => '/create-order',
                        'target' => TargetType::SELF,
                    ],
                    [
                        'title' => 'Download app',
                        'link' => 'https://www.youtube.com/c/kiswaksa',
                        'target' => TargetType::BLANK,
                    ],
                ],

                'cards' => [
                    [
                        'title' => 'Company',
                        'type' => CardType::PARTNER,
                        'total' => '424,100',
                        'image' => '/images/company.png',
                        'BGColor' => '#FFECFD',
                    ],
                    [
                        'title' => 'Clothes',
                        'type' => CardType::DONATIONS_ITEMS,
                        'total' => '424,100',
                        'image' => '/images/recycle.png',
                        'BGColor' => '#FFF7EC',
                    ],
                    [
                        'title' => 'Clothes',
                        'type' => CardType::RYCICLING_ITEMS,
                        'total' => '424,100',
                        'image' => '/images/clothe.png',
                        'BGColor' => '#D4FFD8',
                    ],
                    [
                        'title' => 'Donation',
                        'type' => CardType::DONATIONS,
                        'total' => '424,100',
                        'image' => '/images/donate.png',
                        'BGColor' => '#F8FFEC',
                    ],
                ],
            ],
            SectionType::CARDS_HOME,
            1,
        );
        PagesTableSeeder::createSection(
            $homePageEnglishKW->id,
            [
                'title' => 'News',
                'description' => 'Latest News',
                'button' => [
                    'title' => 'Show more',
                    'link' => '/news',
                    'target' => TargetType::SELF,
                ],
                'count' => 8,
                'component_target' => TargetType::SELF,
            ],
            SectionType::NEWS_HOME,
            6
        );
        PagesTableSeeder::createSection(
            $homePageEnglishKW->id,
            [
                'title' => 'FAQS',
                'description' => 'You can contact the customer service team if you do not find the answer to your question from the FAQS',

                'faqs' => [
                    [
                        'question' => 'What cities are we in?',
                        'answer' => 'You can contact the customer service team if you do not find the answer to your question from the FAQS',
                    ],
                    [
                        'question' => 'How we work?',
                        'answer' => 'You can contact the customer service team if you do not find the answer to your question from the FAQS',
                    ],
                    [
                        'question' => 'I have very old or damaged clothes, can I receive them?',
                        'answer' => 'You can contact the customer service team if you do not find the answer to your question from the FAQS',
                    ],
                    [
                        'question' => 'I sent a donation request and the agent has not arrived yet?',
                        'answer' => 'You can contact the customer service team if you do not find the answer to your question from the FAQS',
                    ],
                    [
                        'question' => 'Are we an official organization?',
                        'answer' => 'You can contact the customer service team if you do not find the answer to your question from the FAQS',
                    ],
                ],
            ],
            SectionType::FAQS,
            8
        );
        PagesTableSeeder::createSection(
            $homePageEnglishKW->id,
            [
                'background' => '/images/About-us-BG.png',
                'title' => 'Help us in looking forward to a better life',
                'description' => 'Download kiswa app now',
                'apps' => [
                    [
                        'link' => 'android app url',
                        'icon' => '/images/Google_Play_Store_badge_EN 1.png',
                        'target' => TargetType::BLANK,
                    ],
                    [
                        'link' => 'ios app url',
                        'icon' => '/images/Download_on_the_App_Store_Badge 1.png',
                        'target' => TargetType::BLANK,
                    ],
                ],
                'title_contact' => 'contact us',
                'contact' => [
                    [
                        'type' => 'whatsapp',
                        'link' => 'https://api.whatsapp.com/send?phone=966500070201',
                        'number' => '+966 50 007 0201',
                        'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/whatsapp.png',
                        'target' => TargetType::BLANK,
                    ],
                    [
                        'type' => 'call',
                        'link' => 'tel:+966-50-007-0201',
                        'number' => '+966 50 007 0201',
                        'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/call.png',
                        'target' => TargetType::BLANK,
                    ],
                ],
            ],
            SectionType::OUR_APPS_HOME,
            9
        );
        PagesTableSeeder::createSection(
            $homePageEnglishKW->id,
            [
                'title' => 'How We work ?',
                'steps' => [
                    [
                        'title' => 'Make order',
                        'description' => 'You can make order via App or website',
                        'buttons' => [
                            [
                                'title' => 'Create Order',
                                'link' => '/create-order',
                                'target' => TargetType::SELF,
                            ],
                            [
                                'title' => 'Download App',
                                'link' => 'https://www.youtube.com/c/kiswaksa',
                                'target' => TargetType::BLANK,
                            ],
                        ],
                        'image' => '/images/how-we-work/button_one.png',
                    ],
                    [
                        'title' => 'Confirm order',
                        'description' => 'Download App now',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_two.png',
                    ],
                    [
                        'title' => 'Receive Donations',
                        'description' => 'Download App now',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_three.png',
                    ],
                    [
                        'title' => 'Recycling',
                        'description' => 'Download App now',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_four.png',
                    ],
                    [
                        'title' => 'Distribution',
                        'description' => 'Download App now',
                        'buttons' => [],
                        'image' => '/images/how-we-work/button_five.png',
                    ],
                ],
            ],
            SectionType::HOW_WE_WORK,
            2
        );
        PagesTableSeeder::createSection(
            $homePageEnglishKW->id,
            [
                'background' => '/images/benefits/benefitBG.png',
                'title' => 'kiswa benefits',
                'cards' => [
                    [
                        'title' => 'Environmental and cultural benefits',
                        'description' => 'Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.',
                        'image' => '/images/benefits/card1.png',
                        'BGColor' => '#E5FFE7',
                    ],
                    [
                        'title' => 'Helping people',
                        'description' => 'Get instant rewards for your surplus clothes.',
                        'image' => '/images/benefits/card2.png',
                        'BGColor' => '#FFF7EC',
                    ],
                    [
                        'title' => 'Supporting charities',
                        'description' => 'We collect donations of clothes and deliver them to charities.',
                        'image' => '/images/benefits/card3.png',
                        'BGColor' => '#EEFBFF',
                    ],
                ],
            ],
            SectionType::KISWA_BENEFITS_HOME,
            4
        );
        PagesTableSeeder::createSection(
            $homePageEnglishKW->id,
            [
                'title' => 'Kiswa offers',
                'description' => 'With the help of our partners, you can use your points to get offers that suit your daily life',
                'button' => [
                    'title' => 'View our offers',
                    'link' => '/offers',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::SELF,
            ],
            SectionType::KISWA_OFFERS_HOME,
            5
        );
        PagesTableSeeder::createSection(
            $homePageEnglishKW->id,
            [
                'background' => [
                    'Base' => '/images/partners/BaseBG.png',
                    'second' => '/images/partners/secondBG.png',
                ],
                'title' => 'Our partners',
                'cards' => [
                    [
                        'type' => CardType::ASSOCIATION,
                        'description' => 'Charity',
                        'image' => '/images/partners/card1.png',
                        'BGColor' => '#F3F6FF',
                    ],
                    [
                        'type' => CardType::PARTNER,
                        'description' => 'Partner Company',
                        'image' => '/images/partners/card2.png',
                        'BGColor' => '#F3F6FF',
                    ],
                    [
                        'type' => CardType::PARTNER,
                        'description' => 'Governmental institution',
                        'image' => '/images/partners/card3.png',
                        'BGColor' => '#F3F6FF',
                    ],
                ],
                'button' => [
                    'title' => 'View our partners',
                    'link' => '/partners',
                    'target' => TargetType::SELF,
                ],
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OUR_PARTNERS_HOME,
            7
        );
        PagesTableSeeder::createSection(
            $homePageEnglishKW->id,
            [
                'src' => 'https://lottie.host/a512f5e6-be89-4f6c-b283-38c4c1eba5dd/a4P7xjiGqP.json',
            ],
            SectionType::LOTTIE_SECTION,
            3
        );


        PagesTableSeeder::createSection(
            $homePageArabicAE->id,
            [
                'title' => '<h1 style="color: red;font-weight: bold">ماذا نستقبل</h1>',
                'cards' => [
                    [
                        'title' => 'جميع أنواع الملابس',
                        'image' => '/images/what-do-we-receive/bags.png',
                    ],
                    [
                        'title' => 'جميع أنواع الملابس',
                        'image' => '/images/what-do-we-receive/bags.png',
                    ],
                    [
                        'title' => 'جميع أنواع الحقائب',
                        'image' => '/images/what-do-we-receive/bags.png',
                    ],
                    [
                        'title' => 'جميع أنواع الحقائب',
                        'image' => '/images/what-do-we-receive/image1.png',
                    ],
                    [
                        'title' => 'جميع أنواع الحقائب',
                        'image' => '/images/what-do-we-receive/image1.png',
                    ],
                    [
                        'title' => 'جميع أنواع الحقائب',
                        'image' => '/images/what-do-we-receive/image1.png',
                    ],
                ],
            ],
            SectionType::WHAT_DO_WE_RECEIVE,
            4
        );

    }
}
