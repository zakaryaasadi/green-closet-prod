<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Language;
use App\Models\LocationSettings;
use Illuminate\Database\Seeder;

class LocationsSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createLocationSettings(
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
                            'title' => 'المقالات',
                            'link' => '/blogs',
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
                    'has_float_button' => true,
                    'float_button' => [
                        'color' => '#FFF7EC',
                        'image' => '',
                        'link' => 'sdsd',
                        'buttons' => [
                        ],
                    ],
                ],
            ],
            Language::whereCode('ar')->first()->id,
            Country::whereCode('AE')->first()->id,
            'uae-ar',
            [
                'header' => '<script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>',
                'footer' => '<script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>',
            ]
        );

        $this->createLocationSettings(
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
                            'title' => ' All Rights Reserved .Kiswa 2022 ©',
                            'link' => '',
                            'target' => '_self',
                        ],
                        [
                            'title' => 'Privacy & Terms',
                            'link' => '',
                            'target' => '_self',
                        ],
                    ],
                    'logo' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/logo-light.png',
                    'has_float_button' => false,

                ],
            ],
            Language::whereCode('en')->first()->id,
            Country::whereCode('AE')->first()->id,
            'uae-en',
            [
                'header' => '<script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>',
                'footer' => '<script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>',
            ]
        );

        $this->createLocationSettings(
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
            Country::whereCode('KW')->first()->id,
            'kwt-ar',
            [
                'header' => '<script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>',
                'footer' => '<script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>',
            ]
        );

        $this->createLocationSettings(
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
                            'title' => ' All Rights Reserved .Kiswa 2022 ©',
                            'link' => '',
                            'target' => '_self',
                        ],
                        [
                            'title' => 'Privacy & Terms',
                            'link' => '',
                            'target' => '_self',
                        ],
                    ],
                    'logo' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/logo-light.png',
                ],
            ],
            Language::whereCode('en')->first()->id,
            Country::whereCode('KW')->first()->id,
            'kwt-en',
            [
                'header' => '<script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>',
                'footer' => '<script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>',
            ]
        );

        $this->createLocationSettings(
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
            Country::whereCode('SA')->first()->id,
            'ksa-ar',
            [
                'header' => '<script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>',
                'footer' => '<script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>',
            ]
        );

        $this->createLocationSettings(
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
                            'title' => ' All Rights Reserved .Kiswa 2022 ©',
                            'link' => '',
                            'target' => '_self',
                        ],
                        [
                            'title' => 'Privacy & Terms',
                            'link' => '',
                            'target' => '_self',
                        ],
                    ],
                    'logo' => 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/logo-light.png',
                ],
            ],
            Language::whereCode('en')->first()->id,
            Country::whereCode('SA')->first()->id,
            'ksa-en',
            [
                'header' => '<script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>',
                'footer' => '<script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>',
            ]
        );

    }

    public static function createLocationSettings($structure, $languageId, $country_id, $slug, $scripts): void
    {
        LocationSettings::create([
            'country_id' => $country_id,
            'language_id' => $languageId,
            'structure' => $structure,
            'scripts' => $scripts,
            'slug' => $slug,
        ]);
    }
}
