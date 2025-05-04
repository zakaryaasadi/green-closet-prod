<?php

namespace Database\Seeders;

use App\Enums\FieldNameEnum;
use App\Enums\FieldType;
use App\Enums\SectionType;
use App\Models\Country;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class ContactUsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $email = Setting::where(['country_id' => null])->first()->email;

        $location = Setting::where(['country_id' => null])->first()->location;

        $phone = Setting::where(['country_id' => null])->first()->phone;

        $contactUsPageEnglishAE = PagesTableSeeder::createPage('Contact us',
            Language::whereCode('en')->first()->id,
            Country::whereCode('AE')->first()->id, 'contact-us', false);
        PagesTableSeeder::createSection(
            $contactUsPageEnglishAE->id,
            [
                'title' => 'Thank you for your interest in KISWA project',
                'description' => ' For more information and details about Kiswa, we are pleased to contact us any time',
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

        $contactUsPageArabicAE = PagesTableSeeder::createPage('تواصل معنا',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('AE')->first()->id, 'contact-us', false);
        PagesTableSeeder::createSection(
            $contactUsPageArabicAE->id,
            [
                'title' => 'شكرا لاهتمامك بمشروع كسوة',
                'description' => 'لمزيد من المعلومات والتفاصيل حول كسوة، يسرنا تواصلك معنا في أي وقت',
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
                            'type' => FieldType::TEXT,
                            'name' => FieldNameEnum::NAME,
                            'id' => 'inputUserName',
                            'icon' => '/images/contact-profile.png',
                        ],
                        [
                            'title' => 'الايميل',
                            'type' => FieldType::EMAIL,
                            'name' => FieldNameEnum::EMAIL,
                            'id' => 'inputEmail',
                            'icon' => '/images/contact-email.png',
                        ],
                        [
                            'title' => 'الرسالة',
                            'type' => FieldType::TEXTAREA,
                            'name' => FieldNameEnum::DETAILS,
                            'id' => 'inputMessage',
                            'icon' => '/images/contact-message.png',
                        ],
                        [
                            'title' => 'رقم الهاتف',
                            'type' => FieldType::TEXT,
                            'name' => FieldNameEnum::PHONE,
                            'id' => 'inputPhone',
                            'icon' => '/images/contact-phone.png',
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


        $contactUsPageEnglishSA = PagesTableSeeder::createPage('Contact us',
            Language::whereCode('en')->first()->id,
            Country::whereCode('SA')->first()->id, 'contact-us', false);

        PagesTableSeeder::createSection(
            $contactUsPageEnglishSA->id,
            [
                'title' => 'Thank you for your interest in KISWA project',
                'description' => ' For more information and details about Kiswa, we are pleased to contact us any time',
                'contact' => [
                      [
                        'title' => 'Email',
                        'info' => 'info@kiswakwt.com',
                        'info-link' => 'mailto:info@kiswakwt.com',
                        'icon' => '/images/email.png',
                    ],
                      [
                        'title' => 'location',
                        'info' => 'location',
                        'info-link' => 'location-url',
                        'icon' => '/images/location.png',
                    ],
                      [
                        'title' => 'Phone',
                        'info' => '+965 9608 9608',
                        'info-link' => 'tel:+96596089608',
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
        $contactUsPageArabicSA = PagesTableSeeder::createPage('تواصل معنا',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('SA')->first()->id, 'contact-us', false);
        PagesTableSeeder::createSection(
            $contactUsPageArabicSA->id,
            [
                'title' => 'شكرا لاهتمامك بمشروع كسوة',
                'description' => 'لمزيد من المعلومات والتفاصيل حول كسوة، يسرنا تواصلك معنا في أي وقت',
                'contact' => [
                    [
                        'title' => 'الإيميل',
                        'info' => 'info@kiswakwt.com',
                        'info-link' => 'mailto:info@kiswakwt.com',
                        'icon' => '/images/email.png',
                    ],
                    [
                        'title' => 'الموقع',
                        'info' => 'الموقع',
                        'info-link' => 'location url',
                        'icon' => '/images/location.png',
                    ],
                    [
                        'title' => 'الهاتف',
                        'info' => '+965 9608 9608',
                        'info-link' => 'tel:+96596089608',
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
                            'title' => 'الإيميل',
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

        $contactUsPageEnglishKW = PagesTableSeeder::createPage('Contact us',
            Language::whereCode('en')->first()->id,
            Country::whereCode('KW')->first()->id, 'contact-us', false);
        PagesTableSeeder::createSection(
            $contactUsPageEnglishKW->id,
            [
                'title' => 'Thank you for your interest in KISWA project',
                'description' => ' For more information and details about Kiswa, we are pleased to contact us any time',
                'contact' => [
                    [
                        'title' => 'Email',
                        'info' => 'info@kiswakwt.com',
                        'info-link' => 'mailto:info@kiswakwt.com',
                        'icon' => '/images/email.png',
                    ],
                    [
                        'title' => 'location',
                        'info' => 'location',
                        'info-link' => 'location-url',
                        'icon' => '/images/location.png',
                    ],
                    [
                        'title' => 'Phone',
                        'info' => '+965 9608 9608',
                        'info-link' => 'tel:+96596089608',
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
        $contactUsPageArabicKW = PagesTableSeeder::createPage('تواصل معنا',
            Language::whereCode('ar')->first()->id,
            Country::whereCode('KW')->first()->id, 'contact-us', false);
        PagesTableSeeder::createSection(
            $contactUsPageArabicKW->id,
            [
                'title' => 'شكرا لاهتمامك بمشروع كسوة',
                'description' => 'لمزيد من المعلومات والتفاصيل حول كسوة، يسرنا تواصلك معنا في أي وقت',
                'contact' => [
                    [
                        'title' => 'الإيميل',
                        'info' => 'info@kiswakwt.com',
                        'info-link' => 'mailto:info@kiswakwt.com',
                        'icon' => '/images/email.png',
                    ],
                    [
                        'title' => 'الموقع',
                        'info' => 'الموقع',
                        'info-link' => 'location url',
                        'icon' => '/images/location.png',
                    ],
                    [
                        'title' => 'الهاتف',
                        'info' => '+965 9608 9608',
                        'info-link' => 'tel:+96596089608',
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
                            'title' => 'الإيميل',
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

    }
}
