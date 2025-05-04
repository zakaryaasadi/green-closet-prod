<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnersTableSeeder extends Seeder
{
    public function run()
    {
        $UAE = Country::whereCode('AE')->first()->id;
        $KSA = Country::whereCode('SA')->first()->id;
        $KW = Country::whereCode('KW')->first()->id;
        $partner = $this->createPartner('https://www.splashfashions.com/ae/en/', $UAE, [
            'translate' => [
                'name_ar' => 'سبلاش',
                'name_en' => 'Splash',
                'description_ar' => 'متجر الكتروني',
                'description_en' => 'E-Commerce',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/splash.png');

        $partner = $this->createPartner(
             'https://rashidc.ae/en/home/', $UAE, [
            'translate' => [
                'name_ar' => 'مركز راشد لأصحاب الهمم',
                'name_en' => 'Rashid Center for People of Determination',
                'description_ar' => 'إحداث فرق في حياة الطلاب أصحاب الهمم ، تأسس مركز راشد لطلبة الهمم عام 1994.',
                'description_en' => 'making a difference in the lives of students of determination.',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/rashid.png');

        $partner = $this->createPartner('https://www.splashfashions.com/ae/en/', $UAE, [
            'translate' => [
                'name_ar' => 'سبلاش',
                'name_en' => 'Splash',
                'description_ar' => 'متجر الكتروني',
                'description_en' => 'E-Commerce',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/splash.png');

        $partner = $this->createPartner(
             'https://rashidc.ae/en/home/', $UAE, [
                'translate' => [
                    'name_ar' => 'مركز راشد لأصحاب الهمم',
                    'name_en' => 'Rashid Center for People of Determination',
                    'description_ar' => 'إحداث فرق في حياة الطلاب أصحاب الهمم ، تأسس مركز راشد لطلبة الهمم عام 1994.',
                    'description_en' => 'making a difference in the lives of students of determination.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/rashid.png');

        $partner = $this->createPartner(
             'https://www.eeg-uae.org/?lang=ar', $UAE, [
                'translate' => [
                    'name_ar' => 'مجموعة عمل الإمارات للبيئة',
                    'name_en' => 'Emirates Environmental Group',
                    'description_ar' => 'المساهمة بشكل فعال في تعزيز التنمية المستدامة في دولة الإمارات العربية المتحدة.',
                    'description_en' => 'Contribute effectively to the promotion of sustainable development in the United Arab Emirates.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/EEG.png');

        $partner = $this->createPartner(
             'https://www.eeg-uae.org/?lang=ar', $UAE, [
                'translate' => [
                    'name_ar' => 'مجموعة عمل الإمارات للبيئة',
                    'name_en' => 'Emirates Environmental Group',
                    'description_ar' => 'المساهمة بشكل فعال في تعزيز التنمية المستدامة في دولة الإمارات العربية المتحدة.',
                    'description_en' => 'Contribute effectively to the promotion of sustainable development in the United Arab Emirates.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/EEG.png');

        $partner = $this->createPartner(
             'https://www.noon.com/', $UAE, [
                'translate' => [
                    'name_ar' => 'نون',
                    'name_en' => 'Noon',
                    'description_ar' => 'متجر الكتروني.',
                    'description_en' => 'E-Commerce.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/Noon.png');

        $partner = $this->createPartner(
             'https://www.noon.com/', $UAE, [
                'translate' => [
                    'name_ar' => 'نون',
                    'name_en' => 'Noon',
                    'description_ar' => 'متجر الكتروني.',
                    'description_en' => 'E-Commerce.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/Noon.png');

        $partner = $this->createPartner(
            'https://www.sivvi.com/', $UAE, [
                'translate' => [
                    'name_ar' => 'سيفي',
                    'name_en' => 'SIVVI',
                    'description_ar' => 'متجر الكتروني.',
                    'description_en' => 'E-Commerce.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/sivvi.png');

        $partner = $this->createPartner('https://www.splashfashions.com/ae/en/', $KSA, [
            'translate' => [
                'name_ar' => 'سبلاش',
                'name_en' => 'Splash',
                'description_ar' => 'متجر الكتروني',
                'description_en' => 'E-Commerce',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/splash.png');

        $partner = $this->createPartner(
            'https://rashidc.ae/en/home/', $KSA, [
                'translate' => [
                    'name_ar' => 'مركز راشد لأصحاب الهمم',
                    'name_en' => 'Rashid Center for People of Determination',
                    'description_ar' => 'إحداث فرق في حياة الطلاب أصحاب الهمم ، تأسس مركز راشد لطلبة الهمم عام 1994.',
                    'description_en' => 'making a difference in the lives of students of determination.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/rashid.png');

        $partner = $this->createPartner('https://www.splashfashions.com/ae/en/', $KSA, [
            'translate' => [
                'name_ar' => 'سبلاش',
                'name_en' => 'Splash',
                'description_ar' => 'متجر الكتروني',
                'description_en' => 'E-Commerce',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/splash.png');

        $partner = $this->createPartner(
            'https://rashidc.ae/en/home/', $KSA, [
                'translate' => [
                    'name_ar' => 'مركز راشد لأصحاب الهمم',
                    'name_en' => 'Rashid Center for People of Determination',
                    'description_ar' => 'إحداث فرق في حياة الطلاب أصحاب الهمم ، تأسس مركز راشد لطلبة الهمم عام 1994.',
                    'description_en' => 'making a difference in the lives of students of determination.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/rashid.png');

        $partner = $this->createPartner(
            'https://www.eeg-uae.org/?lang=ar', $KSA, [
                'translate' => [
                    'name_ar' => 'مجموعة عمل الإمارات للبيئة',
                    'name_en' => 'Emirates Environmental Group',
                    'description_ar' => 'المساهمة بشكل فعال في تعزيز التنمية المستدامة في دولة الإمارات العربية المتحدة.',
                    'description_en' => 'Contribute effectively to the promotion of sustainable development in the United Arab Emirates.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/EEG.png');

        $partner = $this->createPartner(
            'https://www.eeg-uae.org/?lang=ar', $KSA, [
                'translate' => [
                    'name_ar' => 'مجموعة عمل الإمارات للبيئة',
                    'name_en' => 'Emirates Environmental Group',
                    'description_ar' => 'المساهمة بشكل فعال في تعزيز التنمية المستدامة في دولة الإمارات العربية المتحدة.',
                    'description_en' => 'Contribute effectively to the promotion of sustainable development in the United Arab Emirates.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/EEG.png');

        $partner = $this->createPartner(
            'https://www.noon.com/', $KSA, [
                'translate' => [
                    'name_ar' => 'نون',
                    'name_en' => 'Noon',
                    'description_ar' => 'متجر الكتروني.',
                    'description_en' => 'E-Commerce.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/Noon.png');

        $partner = $this->createPartner(
            'https://www.noon.com/', $KSA, [
                'translate' => [
                    'name_ar' => 'نون',
                    'name_en' => 'Noon',
                    'description_ar' => 'متجر الكتروني.',
                    'description_en' => 'E-Commerce.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/Noon.png');

        $partner = $this->createPartner(
            'https://www.sivvi.com/', $KSA, [
                'translate' => [
                    'name_ar' => 'سيفي',
                    'name_en' => 'SIVVI',
                    'description_ar' => 'متجر الكتروني.',
                    'description_en' => 'E-Commerce.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/sivvi.png');

        $partner = $this->createPartner('https://www.splashfashions.com/ae/en/', $KW, [
            'translate' => [
                'name_ar' => 'سبلاش',
                'name_en' => 'Splash',
                'description_ar' => 'متجر الكتروني',
                'description_en' => 'E-Commerce',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/splash.png');


        $partner = $this->createPartner(
            'https://rashidc.ae/en/home/', $KW, [
                'translate' => [
                    'name_ar' => 'مركز راشد لأصحاب الهمم',
                    'name_en' => 'Rashid Center for People of Determination',
                    'description_ar' => 'إحداث فرق في حياة الطلاب أصحاب الهمم ، تأسس مركز راشد لطلبة الهمم عام 1994.',
                    'description_en' => 'making a difference in the lives of students of determination.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/rashid.png');

        $partner = $this->createPartner('https://www.splashfashions.com/ae/en/', $KW, [
            'translate' => [
                'name_ar' => 'سبلاش',
                'name_en' => 'Splash',
                'description_ar' => 'متجر الكتروني',
                'description_en' => 'E-Commerce',
            ],
        ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/splash.png');

        $partner = $this->createPartner(
            'https://rashidc.ae/en/home/', $KW, [
                'translate' => [
                    'name_ar' => 'مركز راشد لأصحاب الهمم',
                    'name_en' => 'Rashid Center for People of Determination',
                    'description_ar' => 'إحداث فرق في حياة الطلاب أصحاب الهمم ، تأسس مركز راشد لطلبة الهمم عام 1994.',
                    'description_en' => 'making a difference in the lives of students of determination.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/rashid.png');

        $partner = $this->createPartner(
            'https://www.eeg-uae.org/?lang=ar', $KW, [
                'translate' => [
                    'name_ar' => 'مجموعة عمل الإمارات للبيئة',
                    'name_en' => 'Emirates Environmental Group',
                    'description_ar' => 'المساهمة بشكل فعال في تعزيز التنمية المستدامة في دولة الإمارات العربية المتحدة.',
                    'description_en' => 'Contribute effectively to the promotion of sustainable development in the United Arab Emirates.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/EEG.png');

        $partner = $this->createPartner(
            'https://www.eeg-uae.org/?lang=ar', $KW, [
                'translate' => [
                    'name_ar' => 'مجموعة عمل الإمارات للبيئة',
                    'name_en' => 'Emirates Environmental Group',
                    'description_ar' => 'المساهمة بشكل فعال في تعزيز التنمية المستدامة في دولة الإمارات العربية المتحدة.',
                    'description_en' => 'Contribute effectively to the promotion of sustainable development in the United Arab Emirates.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/EEG.png');

        $partner = $this->createPartner(
            'https://www.noon.com/', $KW, [
                'translate' => [
                    'name_ar' => 'نون',
                    'name_en' => 'Noon',
                    'description_ar' => 'متجر الكتروني.',
                    'description_en' => 'E-Commerce.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/Noon.png');

        $partner = $this->createPartner(
            'https://www.noon.com/', $KW, [
                'translate' => [
                    'name_ar' => 'نون',
                    'name_en' => 'Noon',
                    'description_ar' => 'متجر الكتروني.',
                    'description_en' => 'E-Commerce.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/Noon.png');

        $partner = $this->createPartner(
            'https://www.sivvi.com/', $KW, [
                'translate' => [
                    'name_ar' => 'سيفي',
                    'name_en' => 'SIVVI',
                    'description_ar' => 'متجر الكتروني.',
                    'description_en' => 'E-Commerce.',
                ],
            ], 'https://phplaravel-771124-2618940.cloudwaysapps.com/images/partners/sivvi.png');
    }

    private function createPartner($url, $country_id, $meta, $image): Partner
    {
        return Partner::create([
            'country_id' => $country_id,
            'meta' => $meta,
            'url' => $url,
            'alt' => 'test partner image',
            'image_path' => $image,
        ]);
    }
}
