<?php

namespace App\Http\API\V1\Repositories\Country;

use App\Enums\ActiveStatus;
use App\Enums\CardType;
use App\Enums\DaysEnum;
use App\Enums\DischargeShift;
use App\Enums\MessageType;
use App\Enums\MonthsEnum;
use App\Enums\SectionType;
use App\Enums\TargetType;
use App\Filters\CustomFilter;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Country;
use App\Models\Language;
use App\Models\LocationSettings;
use App\Models\Page;
use App\Models\Section;
use App\Models\Setting;
use Database\Seeders\LocationsSettingsSeeder;
use Database\Seeders\MessageTableSeeder;
use Database\Seeders\PagesTableSeeder;
use Database\Seeders\TargetTableSeeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class CountryRepository extends BaseRepository
{
    public function __construct(Country $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::custom('search', new CustomFilter(['name', 'code'], ['name'])),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('name'),
            AllowedSort::field('code'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(Country::class, $filters, $sorts);
    }

    public function indexCountriesForClient(): PaginatedData
    {

        $countries = Country::where(['status' => ActiveStatus::ACTIVE]);
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::custom('search', new CustomFilter(['name', 'code'], ['name'])),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('name'),
            AllowedSort::field('code'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter($countries, $filters, $sorts);
    }

    public function createMainPages(Country|Model $country)
    {
        //home page EN
        $homePage = PagesTableSeeder::createPage('home page',
            Language::whereCode('en')->first()->id,
            $country->id, '/', true);
        PagesTableSeeder::createSection(
            $homePage->id,
            [
                'sliders' => [
                    [
                        'image' => '/images/sliders/slider1.png',
                        'title' => 'Contribute now to protect the environment',
                        'sub_title' => 'Green Closet is a project to benefit from surplus used clothes and deliver them to those who need them',
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
                        'sub_title' => 'Green Closet is a project to benefit from surplus used clothes and deliver them to those who need them',
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
                        'sub_title' => 'Green Closet is a project to benefit from surplus used clothes and deliver them to those who need them',
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
            $homePage->id,
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
            $homePage->id,
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
            $homePage->id,
            [
                'background' => '/images/About-us-BG.png',
                'title' => 'Help us in looking forward to a better life',
                'description' => 'Download Green Closet app now',
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
            $homePage->id,
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
            $homePage->id,
            [
                'background' => '/images/benefits/benefitBG.png',
                'title' => 'Green Closet benefits',
                'cards' => [
                    [
                        'title' => 'Environmental and cultural benefits',
                        'description' => 'Throwing clothes distorts the aesthetic view of the streets and makes it more vulnerable to visual and environmental pollution.',
                        'image' => '/images/benefits/card1.png',
                        'BGColor' => '#E5FFE7',
                        'type' => CardType::DONATIONS,
                    ],
                    [
                        'title' => 'Helping people',
                        'description' => 'Get instant rewards for your surplus clothes.',
                        'image' => '/images/benefits/card2.png',
                        'BGColor' => '#FFF7EC',
                        'type' => CardType::ASSOCIATION,
                    ],
                    [
                        'title' => 'Supporting charities',
                        'description' => 'We collect donations of clothes and deliver them to charities.',
                        'image' => '/images/benefits/card3.png',
                        'BGColor' => '#EEFBFF',
                        'type' => CardType::DONATIONS_ITEMS,

                    ],
                ],
            ],
            SectionType::KISWA_BENEFITS_HOME,
            4
        );
        PagesTableSeeder::createSection(
            $homePage->id,
            [
                'title' => 'Green Closet offers',
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
            $homePage->id,
            [
                'background' => [
                    'Base' => '/images/partners/BaseBG.png',
                    'second' => '/images/partners/secondBG.png',
                ],
                'title' => 'Our partners',
                'cards' => [
                    [
                        'title' => '+34',
                        'description' => 'Charity',
                        'image' => '/images/partners/card1.png',
                        'BGColor' => '#F3F6FF',
                        'type' => CardType::ASSOCIATION,

                    ],
                    [
                        'title' => '+20',
                        'description' => 'Partner Company',
                        'image' => '/images/partners/card2.png',
                        'BGColor' => '#F3F6FF',
                        'type' => CardType::ASSOCIATION,

                    ],
                    [
                        'title' => '+34',
                        'description' => 'Governmental institution',
                        'image' => '/images/partners/card3.png',
                        'BGColor' => '#F3F6FF',
                        'type' => CardType::ASSOCIATION,

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
            $homePage->id,
            [
                'src' => 'https://lottie.host/a512f5e6-be89-4f6c-b283-38c4c1eba5dd/a4P7xjiGqP.json',
            ],
            SectionType::LOTTIE_SECTION,
            3
        );

        //gallery page EN
        $galleryPageEnglish = PagesTableSeeder::createPage('Gallery',
            Language::whereCode('en')->first()->id,
            $country->id, 'gallery', false);
        $sectionGalleryEnglish = PagesTableSeeder::createSection(
            $galleryPageEnglish->id,
            [
                'title' => 'Gallery',
                'description' => 'Gallery',
                'images' => [
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                    'https://phplaravel-771124-2618940.cloudwaysapps.com/storage/16/m3.jpg',
                ],
            ],
            SectionType::GALLERY_PAGE,
            1
        );

        //gallery page AR
        $galleryPageArabic = PagesTableSeeder::createPage('المعرض',
            Language::whereCode('ar')->first()->id,
            $country->id, 'gallery', false);
        $sectionGalleryArabic = PagesTableSeeder::createSection(
            $galleryPageArabic->id,
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

        //events page EN
        $eventsPage = PagesTableSeeder::createPage('Events',
            Language::whereCode('en')->first()->id,
            $country->id, 'events', false);
        PagesTableSeeder::createSection(
            $eventsPage->id,
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

        //events page AR
        $eventsPageArabic = PagesTableSeeder::createPage('الفعاليات',
            Language::whereCode('ar')->first()->id,
            $country->id, 'events', false);

        PagesTableSeeder::createSection(
            $eventsPageArabic->id,
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

        //Thanks page
        PagesTableSeeder::createPage('Thanks page',
            Language::whereCode('en')->first()->id,
            $country->id, 'thank-you', false);

        PagesTableSeeder::createPage('صفحة الشكر',
            Language::whereCode('ar')->first()->id,
            $country->id, 'thank-you', false);

        //contact us page EN
        $email = Setting::where(['country_id' => null])->first()->email;
        $location = Setting::where(['country_id' => null])->first()->location;
        $phone = Setting::where(['country_id' => null])->first()->phone;
        $contactUsPage = PagesTableSeeder::createPage('Contact us',
            Language::whereCode('en')->first()->id,
            $country->id, 'contact-us', false);
        PagesTableSeeder::createSection(
            $contactUsPage->id,
            [
                'title' => 'Thank you for your interest in Green Closet project',
                'description' => ' For more information and details about Green Closet, we are pleased to contact us any time',
                'contact' => [
                    [
                        'title' => 'Email',
                        'info' => $email,
                        'info-link' => 'mailto:' . $email,
                        'icon' => '/images/email.png',
                    ],
                    [
                        'title' => 'location',
                        'info' => $location,
                        'info-link' => 'location-url',
                        'icon' => '/images/location.png',
                    ],
                    [
                        'title' => 'Phone',
                        'info' => $phone,
                        'info-link' => 'tel:' . $phone,
                        'icon' => '/images/Bphone.png',
                    ],
                ],
                'form' => [
                    'title' => 'Contact us',
                    'fields' => [
                        [
                            'title' => 'User name',
                            'type' => 'text',
                            'name' => 'name',
                            'id' => 'inputUserName',
                            'icon' => '/images/contact-profile.png',
                        ],
                        [
                            'title' => 'Email',
                            'type' => 'email',
                            'name' => 'email',
                            'id' => 'inputEmail',
                            'icon' => '/images/contact-email.png',
                        ],
                        [
                            'title' => 'Phone number',
                            'type' => 'text',
                            'name' => 'phone',
                            'id' => 'inputPhone',
                            'icon' => '/images/contact-phone.png',
                        ],
                        'textarea' => [
                            'title' => 'Message',
                            'type' => '',
                            'name' => 'details',
                            'id' => 'inputMessage',
                            'icon' => '/images/contact-message.png',
                        ],
                    ],
                    'button' => [
                        'title' => 'Send',

                    ],
                ],
                'map' => [
                    'lat' => '25.193052885450484',
                    'lng' => '55.26491653228316',
                ],
            ],
            SectionType::CONTACT_US,
            1
        );

        //contact us page AR
        $contactUsPageArabic = PagesTableSeeder::createPage('تواصل معنا',
            Language::whereCode('ar')->first()->id,
            $country->id, 'contact-us', false);
        PagesTableSeeder::createSection(
            $contactUsPageArabic->id,
            [
                'title' => 'شكرا لاهتمامك بمشروع جرين كلوزيت',
                'description' => 'لمزيد من المعلومات والتفاصيل حول جرين كلوزيت، يسرنا تواصلك معنا في أي وقت',
                'contact' => [
                    [
                        'title' => 'الايميل',
                        'info' => $email,
                        'info-link' => 'mailto:' . $email,
                        'icon' => '/images/email.png',
                    ],
                    [
                        'title' => 'الموقع',
                        'info' => $location,
                        'info-link' => 'location-url',
                        'icon' => '/images/location.png',
                    ],
                    [
                        'title' => 'الهاتف',
                        'info' => $phone,
                        'info-link' => 'tel:' . $phone,
                        'icon' => '/images/Bphone.png',
                    ],
                ],
                'form' => [
                    'title' => 'تواصل معنا',
                    'fields' => [
                        [
                            'title' => 'اسم المستخدم',
                            'type' => 'text',
                            'name' => 'name',
                            'id' => 'inputUserName',
                            'icon' => '/images/contact-profile.png',
                        ],
                        [
                            'title' => 'الايميل',
                            'type' => 'email',
                            'name' => 'email',
                            'id' => 'inputEmail',
                            'icon' => '/images/contact-email.png',
                        ],
                        [
                            'title' => 'رقم الهاتف',
                            'type' => 'text',
                            'name' => 'phone',
                            'id' => 'inputPhone',
                            'icon' => '/images/contact-phone.png',
                        ],
                        'textarea' => [
                            'title' => 'الرسالة',
                            'type' => '',
                            'name' => 'details',
                            'id' => 'inputMessage',
                            'icon' => '/images/contact-message.png',
                        ],
                    ],
                    'button' => [
                        'title' => 'ارسال',

                    ],
                ],
                'map' => [
                    'lat' => '25.193052885450484',
                    'lng' => '55.26491653228316',
                ],
            ],
            SectionType::CONTACT_US,
            1
        );

        //create order page EN
        $createOrderPage = PagesTableSeeder::createPage('Create order',
            Language::whereCode('en')->first()->id,
            $country->id, 'create-order', false);
        PagesTableSeeder::createSection(
            $createOrderPage->id,
            [],
            SectionType::CREATE_ORDER,
            1
        );

        $createOrderPageArabic = PagesTableSeeder::createPage('انشاء طلب تبرع',
            Language::whereCode('ar')->first()->id,
            $country->id, 'create-order', false);
        PagesTableSeeder::createSection(
            $createOrderPageArabic->id,
            [],
            SectionType::CREATE_ORDER,
            1
        );

        //offers page EN
        $offersPage = PagesTableSeeder::createPage('Offers',
            Language::whereCode('en')->first()->id,
            $country->id, 'offers', false);
        PagesTableSeeder::createSection(
            $offersPage->id,
            [
                'title' => 'Offers from Green Closet',
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OFFER_PAGE,
            1
        );

        //create order page AR
        $offersPageArabic = PagesTableSeeder::createPage('العروض',
            Language::whereCode('ar')->first()->id,
            $country->id, 'offers', false);
        PagesTableSeeder::createSection(
            $offersPageArabic->id,
            [
                'title' => 'العروض من جرين كلوزيت',
                'component_target' => TargetType::BLANK,
            ],
            SectionType::OFFER_PAGE,
            1
        );

        //our Partners EN
        $ourPartnersPage = PagesTableSeeder::createPage('Partners',
            Language::whereCode('en')->first()->id,
            $country->id, 'partners', false);
        PagesTableSeeder::createSection(
            $ourPartnersPage->id,
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

        //our Partners AR
        $ourPartnersPageArabic = PagesTableSeeder::createPage('شركائنا',
            Language::whereCode('ar')->first()->id,
            $country->id, 'partners', false);
        PagesTableSeeder::createSection(
            $ourPartnersPageArabic->id,
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

        //news page EN
        $newsPage = PagesTableSeeder::createPage('News Page',
            Language::whereCode('en')->first()->id,
            $country->id, 'news', false);
        PagesTableSeeder::createSection(
            $newsPage->id,
            [
                'title' => 'News',
                'description' => 'News',
                'component_target' => TargetType::SELF,
            ],

            SectionType::NEWS_PAGE,
            1
        );

        //news page AR
        $newsPageArabic = PagesTableSeeder::createPage('صفحةالأخبار',
            Language::whereCode('ar')->first()->id,
            $country->id, 'news', false);
        PagesTableSeeder::createSection(
            $newsPageArabic->id,
            [
                'title' => 'الاخبار',
                'description' => 'اخر الاخبار',
                'component_target' => TargetType::SELF,
            ],
            SectionType::NEWS_PAGE,
            1
        );

        //English location settings
        LocationsSettingsSeeder::createLocationSettings(
            [
                'header' => [
                    'links' => [
                        [
                            'title' => 'Home',
                            'link' => '/',
                            'target' => '_self',
                        ],
                        [
                            'title' => 'Gallery',
                            'link' => '/gallery',
                            'target' => '_self',
                        ],
                        [
                            'title' => 'News',
                            'link' => '/news',
                            'target' => '_self',
                        ],
                        [
                            'title' => 'Offers',
                            'link' => '/offers',
                            'target' => '_self',
                        ],
                        [
                            'title' => 'Events',
                            'link' => '/events',
                            'target' => '_self',
                        ],
                        [
                            'title' => 'Contact Us',
                            'link' => '/contact-us',
                            'target' => '_self',
                        ],
                    ],
                    'logo' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/logo.png',
                    'buttons' => [

                        [
                            'title' => 'Create Order',
                            'link' => '/create-order',
                            'target' => '_self',
                        ],
                    ],
                ],
                'footer' => [
                    'follow_us' => [
                        [
                            'url' => 'https://facebook.com/',
                            'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/Facebook.png',
                            'target' => '_blank',
                        ],
                        [
                            'url' => 'https://twitter.com/',
                            'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/Twitter.png',
                            'target' => '_blank',
                        ],
                        [
                            'url' => 'https://instagram.com/',
                            'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/Instagram.png',
                            'target' => '_blank',
                        ],
                        [
                            'url' => 'https://www.youtube.com/',
                            'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/YouTube.png',
                            'target' => '_blank',
                        ],
                    ],
                    'contact_us' => [
                        [
                            'link' => 'https://api.whatsapp.com/send?phone=966500070201',
                            'number' => '+966 50 007 0201',
                            'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/whatsapp.png',
                            'target' => '_blank',
                        ],
                        [
                            'link' => 'tel:+966-50-007-0201',
                            'number' => '+966 50 007 0201',
                            'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/call.png',
                            'target' => '_blank',
                        ],
                    ],
                    'links' => [
                        [
                            'title' => ' All Rights Reserved .Green Closet 2022 ©',
                            'link' => 'link',
                            'target' => '_self',
                        ],
                        [
                            'title' => 'Privacy & Terms',
                            'link' => 'link',
                            'target' => '_self',
                        ],
                    ],
                    'logo' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/logo-light.png',
                ],
            ],
            Language::whereCode('en')->first()->id,
            $country->id,
            strtolower($country->code) . '-en',
            [
                'header' => '<script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>',
                'footer' => '<script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>',
            ]
        );

        //home page AR
        $homePageArabic = PagesTableSeeder::createPage('الصفحة الرئيسية ',
            Language::whereCode('ar')->first()->id,
            $country->id, '/', true);
        PagesTableSeeder::createSection(
            $homePageArabic->id,
            [
                'sliders' => [
                    [
                        'image' => '/images/sliders/slider1.png',
                        'title' => 'ساهم بالحفاظ على البيئة',
                        'sub_title' => 'جرين كلوزيت هو مشروع للاستفادة من فائض الملابس المستعملة وايصالها لمن هو بحاجة لها',
                        'description' => 'قم بإنشاء طلبك الآن ,وسوف يصلك مندوبنا لاستلام فائض ملابسكم',
                        'buttons' => [],
                    ],
                    [
                        'image' => '/images/sliders/slider2.png',
                        'title' => 'ساهم بالحفاظ على البيئة',
                        'sub_title' => 'جرين كلوزيت هو مشروع للاستفادة من فائض الملابس المستعملة وايصالها لمن هو بحاجة لها',
                        'description' => 'قم بإنشاء طلبك الآن ,وسوف يصلك مندوبنا لاستلام فائض ملابسكم',
                        'button' => [
                            'title' => 'CTA - Button',
                            'link' => '',
                            'target' => TargetType::SELF,
                        ],
                    ],
                    [
                        'image' => '/images/sliders/slider3.png',
                        'title' => 'ساهم بالحفاظ على البيئة',
                        'sub_title' => 'جرين كلوزيت هو مشروع للاستفادة من فائض الملابس المستعملة وايصالها لمن هو بحاجة لها',
                        'description' => 'قم بإنشاء طلبك الآن ,وسوف يصلك مندوبنا لاستلام فائض ملابسكم',
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
            $homePageArabic->id,
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
            $homePageArabic->id,
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
            $homePageArabic->id,
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
            $homePageArabic->id,
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
            $homePageArabic->id,
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
            $homePageArabic->id,
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
            $homePageArabic->id,
            [
                'background' => [
                    'Base' => '/images/partners/BaseBG.png',
                    'second' => '/images/partners/secondBG.png',
                ],
                'title' => 'شركائنا',
                'cards' => [
                    [
                        'title' => '+34',
                        'description' => 'جمعية خيرية',
                        'image' => '/images/partners/card1.png',
                        'BGColor' => '#F3F6FF',
                        'type' => CardType::ASSOCIATION,
                    ],
                    [
                        'title' => '+20',
                        'description' => 'شركة شريكة',
                        'image' => '/images/partners/card2.png',
                        'BGColor' => '#F3F6FF',
                        'type' => CardType::ASSOCIATION,
                    ],
                    [
                        'title' => '+34',
                        'description' => 'مؤسسة  حكومية',
                        'image' => '/images/partners/card3.png',
                        'BGColor' => '#F3F6FF',
                        'type' => CardType::ASSOCIATION,
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
            $homePageArabic->id,
            [
                'src' => 'https://lottie.host/a512f5e6-be89-4f6c-b283-38c4c1eba5dd/a4P7xjiGqP.json',
            ],
            SectionType::LOTTIE_SECTION,
            3
        );

        //Arabic location settings
        LocationsSettingsSeeder::createLocationSettings(
            [
                'header' => [
                    'links' => [
                        [
                            'title' => 'الصفحة الرئيسية',
                            'link' => '/',
                            'target' => '_self',
                        ],
                        [
                            'title' => 'المعرض',
                            'link' => '/gallery',
                            'target' => '_self',
                        ],
                        [
                            'title' => 'الأخبار',
                            'link' => '/news',
                            'target' => '_self',
                        ],
                        [
                            'title' => 'العروض',
                            'link' => '/offers',
                            'target' => '_self',
                        ],
                        [
                            'title' => 'الفعاليات',
                            'link' => '/events',
                            'target' => '_self',
                        ],
                        [
                            'title' => 'تواصل معنا',
                            'link' => '/contact-us',
                            'target' => '_self',
                        ],

                    ],
                    'logo' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/logo.png',
                    'buttons' => [

                        [
                            'title' => 'انشاء طلب',
                            'link' => '/create-order',
                            'target' => '_self',
                        ],

                    ],
                ],
                'footer' => [
                    'follow_us' => [
                        [
                            'url' => 'https://facebook.com/',
                            'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/Facebook.png',
                            'target' => '_blank',
                        ],
                        [
                            'url' => 'https://twitter.com/',
                            'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/Twitter.png',
                            'target' => '_blank',
                        ],
                        [
                            'url' => 'https://instagram.com/',
                            'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/Instagram.png',
                            'target' => '_blank',
                        ],
                        [
                            'url' => 'https://www.youtube.com/',
                            'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/YouTube.png',
                            'target' => '_blank',
                        ],
                    ],
                    'contact_us' => [
                        [
                            'link' => 'https://api.whatsapp.com/send?phone=966500070201',
                            'number' => '+966 50 007 0201',
                            'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/whatsapp.png',
                            'target' => '_blank',
                        ],
                        [
                            'link' => 'tel:+966-50-007-0201',
                            'number' => '+966 50 007 0201',
                            'icon' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/footer/call.png',
                            'target' => '_blank',
                        ],
                    ],
                    'links' => [
                        [
                            'title' => ' جميع الحقوق محفوظة . جرين كلوزيت 2022 ©',
                            'link' => '',
                            'target' => '_self',
                        ],
                        [
                            'title' => 'الخصوصية  & الشروط ',
                            'link' => '',
                            'target' => '_self',
                        ],
                    ],
                    'logo' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/logo-light.png',
                ],
            ],
            Language::whereCode('ar')->first()->id,
            $country->id,
            strtolower($country->code) . '-ar',
            [
                'header' => '<script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>',
                'footer' => '<script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>',
            ]
        );

        Section::create([
            'structure' => [
                'title' => 'How We Work?',
                'steps' => [
                    [
                        'title' => 'Ask for service',
                        'description' => 'Submit a donation request through the website or application',
                        'sort' => '1',
                        'image' => 'https://green-closet.com/images/how-we-work/button_one.png',
                    ],
                    [
                        'title' => 'Confirmation',
                        'description' => 'We will contact you to confirm the date and address of receipt',
                        'sort' => '2',
                        'image' => 'https://green-closet.com/images/how-we-work/button_two.png',
                    ],
                    [
                        'title' => 'Receipt of donations',
                        'description' => 'Receive your donations from your home for free within 24 hours',
                        'sort' => '3',
                        'image' => 'https://green-closet.com/images/how-we-work/button_three.png',
                    ],
                    [
                        'title' => 'Recycling',
                        'description' => 'Sorting and recycling donations by our specialized team',
                        'sort' => '4',
                        'image' => 'https://green-closet.com/images/how-we-work/button_four.png',
                    ],
                    [
                        'title' => 'Distribution',
                        'description' => 'Distributing donations to the needy through the Green Closet volunteer team and under the supervision of approved charities',
                        'sort' => '5',
                        'image' => 'https://green-closet.com/images/how-we-work/button_five.png',
                    ],
                ],
            ],
            'sort' => 1,
            'type' => SectionType::HOW_WE_WORK_MOBILE,
            'language_id' => Language::whereCode('en')->first()->id,
            'country_id' => $country->id,
        ]);

        Section::create([
            'structure' => [
                'title' => 'كيف نعمل؟',
                'steps' => [
                    [
                        'title' => 'اطلب الخدمة',
                        'description' => 'تقديم طلب التبرع عبر الموقع الإلكتروني او التطبيق',
                        'sort' => '1',
                        'image' => 'https://green-closet.com/images/how-we-work/button_one.png',
                    ],
                    [
                        'title' => 'تأكيد الطلب',
                        'description' => 'سيتم التواصل معكم لتأكيد موعد وعنوان الاستلام',
                        'sort' => '2',
                        'image' => 'https://green-closet.com/images/how-we-work/button_two.png',
                    ],
                    [
                        'title' => 'استلام التبرعات',
                        'description' => 'استلام تبرعاتكم من منزلكم مجاناً خلال 24 ساعة',
                        'sort' => '3',
                        'image' => 'https://green-closet.com/images/how-we-work/button_three.png',
                    ],
                    [
                        'title' => 'اعادة التدوير',
                        'description' => 'فرز وإعادة تدوير التبرعات على يد فريقنا المختص',
                        'sort' => '4',
                        'image' => 'https://green-closet.com/images/how-we-work/button_four.png',
                    ],
                    [
                        'title' => 'التوزيع',
                        'description' => 'توزيع التبرعات على المحتاجين من خلال فريق جرين كلوزيت التطوعي و تحت اشراف االجمعيات الخيرية المعتمدة',
                        'sort' => '5',
                        'image' => 'https://green-closet.com/images/how-we-work/button_five.png',
                    ],
                ],
            ],
            'sort' => 1,
            'type' => SectionType::HOW_WE_WORK_MOBILE,
            'language_id' => Language::whereCode('ar')->first()->id,
            'country_id' => $country->id,
        ]);

        Setting::create([
            'country_id' => $country->id,
            'language_id' => Language::whereCode('en')->first()->id,
            'point_value' => 0.5,
            'point_count' => 10,
            'point_expire' => 50,
            'first_points' => 100,
            'first_points_expire' => 20,
            'container_value' => 5,
            'send_link' => 0,
            'mail_receiver' => 'test@test',
            'slug' => strtolower($country->code) . '-en',
            'email' => 'test@test',
            'location' => 'test - test - test',
            'default_country_id' => Country::whereCode('AE')->first()->id,
            'phone' => '+test',
            'header_title' => 'Green Closet ' . $country->meta['translate']['name_en'],
            'header_title_arabic' => 'جرين كلوزيت ' . $country->meta['translate']['name_ar'],
            'auto_assign' => 0,
            'calculate_points' => 1,
            'points_per_order' => 100,
            'has_donation' => 1,
            'has_recycling' => 1,
            'has_donation_admin' => 1,
            'has_recycling_admin' => 1,
            'tasks_per_day' => 5,
            'budget' => 100,
            'holiday' => DaysEnum::SATURDAY,
            'start_work' => '12:00',
            'finish_work' => '04:00',
            'sms_user_name' => config('integrations.sms.user_name'),
            'sms_password' => config('integrations.sms.password'),
            'sms_sender_id' => config('integrations.sms.sender_id'),
            'work_shift' => DischargeShift::EVENING_SHIFT,
        ]);
        $this->createMessages($country);
    }

    public function createMessages(Country|Model $country)
    {
        $EN = Language::whereCode('en')->first()->id;
        $AR = Language::whereCode('ar')->first()->id;


        //OTP Message
        MessageTableSeeder::createMessage('Dear $CLIENT_NAME your code is :', $country->id, MessageType::OTP_MESSAGE, $EN);
        MessageTableSeeder::createMessage('Dear $CLIENT_NAME your code is :', $country->id, MessageType::OTP_MESSAGE, $AR);

        //Invoice Message
        MessageTableSeeder::createMessage('Dear $CLIENT_NAME your order is success and your invoice in : ', $country->id, MessageType::INVOICE_MESSAGE, $EN);
        MessageTableSeeder::createMessage('Dear $CLIENT_NAME your order is success and your invoice in : ', $country->id, MessageType::INVOICE_MESSAGE, $AR);


        MessageTableSeeder::createMessage('Hello $CLIENT_NAME your order #$ORDER_ID has been accepted', $country->id, MessageType::ACCEPT_ORDER_MESSAGE, $EN);

        MessageTableSeeder::createMessage('مرحبا $CLIENT_NAME طلبك ذو الرقم #$ORDER_ID تم قبوله', $country->id, MessageType::ACCEPT_ORDER_MESSAGE, $AR);


        //Accept Order Title
        MessageTableSeeder::createMessage('Hello $CLIENT_NAME Your order accepted', $country->id, MessageType::ACCEPT_ORDER_MESSAGE_TITLE, $EN);

        MessageTableSeeder::createMessage('مرحبا $CLIENT_NAME طلبك ذو الرقم #$ORDER_ID تم قبوله', $country->id, MessageType::ACCEPT_ORDER_MESSAGE_TITLE, $AR);


        //Create Order
        MessageTableSeeder::createMessage('Thanks $CLIENT_NAME your order is created', $country->id, MessageType::CREATE_ORDER_MESSAGE, $EN);

        MessageTableSeeder::createMessage('شكرا $CLIENT_NAME لقد تم انشاء طلبك بنجاح', $country->id, MessageType::CREATE_ORDER_MESSAGE, $AR);


        //Create Order Title
        MessageTableSeeder::createMessage('Order is created', $country->id, MessageType::CREATE_ORDER_MESSAGE_TITLE, $EN);

        MessageTableSeeder::createMessage('لقد تم انشاء طلبك بنجاح', $country->id, MessageType::CREATE_ORDER_MESSAGE_TITLE, $AR);


        //Assign Order
        MessageTableSeeder::createMessage('$CLIENT_NAME your order #$ORDER_ID is assign ', $country->id, MessageType::ASSIGNED_ORDER_MESSAGE, $EN);

        MessageTableSeeder::createMessage('$CLIENT_NAME طلبك ذو الرقم $ORDER_ID فعال', $country->id, MessageType::ASSIGNED_ORDER_MESSAGE, $AR);


        //Assign Order Title
        MessageTableSeeder::createMessage('The order is assigned', $country->id, MessageType::ASSIGNED_ORDER_MESSAGE_TITLE, $EN);

        MessageTableSeeder::createMessage('تم اسناد الطلب', $country->id, MessageType::ASSIGNED_ORDER_MESSAGE_TITLE, $AR);


        //Assign Order Agent
        MessageTableSeeder::createMessage('$ORDER_AGENT order #$ORDER_ID is assign to you', $country->id, MessageType::ASSIGNED_ORDER_MESSAGE_AGENT, $EN);

        MessageTableSeeder::createMessage('$ORDER_AGENT الطلب ذو الرقم $ORDER_ID اسند اليك', $country->id, MessageType::ASSIGNED_ORDER_MESSAGE_AGENT, $AR);


        //Delivering Order
        MessageTableSeeder::createMessage('$ORDER_AGENT is on the way to you', $country->id, MessageType::DELIVERING_ORDER_MESSAGE, $EN);

        MessageTableSeeder::createMessage('$ORDER_AGENT في طريقه اليك!', $country->id, MessageType::DELIVERING_ORDER_MESSAGE, $AR);


        //Delivering Order Title
        MessageTableSeeder::createMessage('Order is on the way to you', $country->id, MessageType::DELIVERING_ORDER_MESSAGE_TITLE, $EN);

        MessageTableSeeder::createMessage('طلبك في طريقه اليك!', $country->id, MessageType::DELIVERING_ORDER_MESSAGE_TITLE, $AR);


        //Decline Order
        MessageTableSeeder::createMessage('$CLIENT_NAME your order is Decline :(', $country->id, MessageType::DECLINE_ORDER_MESSAGE, $EN);

        MessageTableSeeder::createMessage('$CLIENT_NAME طلبك تم رفضه', $country->id, MessageType::DECLINE_ORDER_MESSAGE, $AR);


        //Decline Order Title
        MessageTableSeeder::createMessage('Order is Decline :(', $country->id, MessageType::DECLINE_ORDER_MESSAGE_TITLE, $EN);

        MessageTableSeeder::createMessage('طلبك تم رفضه', $country->id, MessageType::DECLINE_ORDER_MESSAGE_TITLE, $AR);


        //Cancel Order
        MessageTableSeeder::createMessage('$CLIENT_NAME your order is cancel :(', $country->id, MessageType::CANCEL_ORDER_MESSAGE, $EN);

        MessageTableSeeder::createMessage('$CLIENT_NAME طلبك تم رفضه', $country->id, MessageType::CANCEL_ORDER_MESSAGE, $AR);


        //Cancel Order Title
        MessageTableSeeder::createMessage('Order is cancel :(', $country->id, MessageType::CANCEL_ORDER_MESSAGE_TITLE, $EN);

        MessageTableSeeder::createMessage('طلبك تم رفضه', $country->id, MessageType::CANCEL_ORDER_MESSAGE_TITLE, $AR);


        //Failed Order
        MessageTableSeeder::createMessage('$CLIENT_NAME Order is failed :(', $country->id, MessageType::FAILED_ORDER_MESSAGE, $EN);

        MessageTableSeeder::createMessage('$CLIENT_NAME طلبك قد فشل', $country->id, MessageType::FAILED_ORDER_MESSAGE, $AR);


        //Failed Order Title
        MessageTableSeeder::createMessage('Order failed :(', $country->id, MessageType::FAILED_ORDER_MESSAGE_TITLE, $EN);

        MessageTableSeeder::createMessage('طلبك قد فشل', $country->id, MessageType::FAILED_ORDER_MESSAGE_TITLE, $AR);


        //Successful Order
        MessageTableSeeder::createMessage('Thanks for save the environment $CLIENT_NAME ! you order #$ORDER_ID is completed', $country->id, MessageType::SUCCESSFUL_ORDER_MESSAGE, $EN);

        MessageTableSeeder::createMessage('شكرا $CLIENT_NAME على انقاذك للبيئة! طلبك ذو الرقم $ORDER_ID قد اكتمل', $country->id, MessageType::SUCCESSFUL_ORDER_MESSAGE, $AR);


        //Successful Order Title
        MessageTableSeeder::createMessage('Order is completed', $country->id, MessageType::SUCCESSFUL_ORDER_MESSAGE_TITLE, $EN);

        MessageTableSeeder::createMessage('طلبك قد اكتمل', $country->id, MessageType::SUCCESSFUL_ORDER_MESSAGE_TITLE, $AR);


        //Thanks message
        MessageTableSeeder::createMessage('Thanks for your effort! your order is created', $country->id, MessageType::THANKS_MESSAGE, $EN);

        MessageTableSeeder::createMessage('تم انشاء طلبك بنجاح!
        سيتصل بك احد ممثلينا باقرب وقت ممكن!', $country->id, MessageType::THANKS_MESSAGE, $AR);

        //Failed messages
        MessageTableSeeder::createMessage('العميل غير جاهز الآن Another Day', $country->id, MessageType::FAILED_MESSAGE, $EN);
        MessageTableSeeder::createMessage('العميل لا يرد  No Answer', $country->id, MessageType::FAILED_MESSAGE, $EN);
        MessageTableSeeder::createMessage('جوال العميل مغلق  Switch off phone', $country->id, MessageType::FAILED_MESSAGE, $EN);
        MessageTableSeeder::createMessage('الموقع خاطئ  Location Wrong', $country->id, MessageType::FAILED_MESSAGE, $EN);
        MessageTableSeeder::createMessage('الرقم غير صحيح  Wrong Number', $country->id, MessageType::FAILED_MESSAGE, $EN);


        //Cancel messages
        MessageTableSeeder::createMessage('حدث خطا Error', $country->id, MessageType::CANCEL_MESSAGE, $EN);
        MessageTableSeeder::createMessage('انقطاع الخدمة  No Service', $country->id, MessageType::CANCEL_MESSAGE, $EN);
        MessageTableSeeder::createMessage('حالة طارئة  SOS', $country->id, MessageType::CANCEL_MESSAGE, $EN);

        //Expense Created Title
        MessageTableSeeder::createMessage('$ASSOCIATION_NAME is request expense $EXPENSE_ID', $country->id, MessageType::ASSOCIATION_EXPENSES_REQUESTED_TITLE, $EN);

        MessageTableSeeder::createMessage('$ASSOCIATION_NAME طلب سحب رصيد $EXPENSE_ID', $country->id, MessageType::ASSOCIATION_EXPENSES_REQUESTED_TITLE, $AR);


        //Expense Created Message
        MessageTableSeeder::createMessage('$ASSOCIATION_NAME is request expense $EXPENSE_ID', $country->id, MessageType::ASSOCIATION_EXPENSES_REQUESTED_MESSAGE, $EN);

        MessageTableSeeder::createMessage('$ASSOCIATION_NAME طلب سحب رصيد $EXPENSE_ID', $country->id, MessageType::ASSOCIATION_EXPENSES_REQUESTED_MESSAGE, $AR);


    }

    public function createTargetTable(Country|Model $country)
    {

        TargetTableSeeder::createTarget($country->id, MonthsEnum::January);
        TargetTableSeeder::createTarget($country->id, MonthsEnum::February);
        TargetTableSeeder::createTarget($country->id, MonthsEnum::March);
        TargetTableSeeder::createTarget($country->id, MonthsEnum::April);
        TargetTableSeeder::createTarget($country->id, MonthsEnum::May);
        TargetTableSeeder::createTarget($country->id, MonthsEnum::June);
        TargetTableSeeder::createTarget($country->id, MonthsEnum::July);
        TargetTableSeeder::createTarget($country->id, MonthsEnum::August);
        TargetTableSeeder::createTarget($country->id, MonthsEnum::September);
        TargetTableSeeder::createTarget($country->id, MonthsEnum::October);
        TargetTableSeeder::createTarget($country->id, MonthsEnum::November);
        TargetTableSeeder::createTarget($country->id, MonthsEnum::December);
    }

    public function deleteCountry(Country $country): ?bool
    {

        Setting::whereCountryId($country->id)->first()?->delete();
        Page::whereCountryId($country->id)?->delete();
        LocationSettings::whereCountryId($country->id)?->delete();

        return $this->delete($country);
    }
}
