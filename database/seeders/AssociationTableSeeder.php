<?php

namespace Database\Seeders;

use App\Enums\ActiveStatus;
use App\Models\Association;
use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Seeder;

class AssociationTableSeeder extends Seeder
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
        $user = User::whereEmail('association@kiswa.com')->first()->id;
        $user2 = User::whereEmail('association2@kiswa.com')->first()->id;
        $user3 = User::whereEmail('association3@kiswa.com')->first()->id;
        $user4 = User::whereEmail('association4@kiswa.com')->first()->id;
        $user5 = User::whereEmail('association5@kiswa.com')->first()->id;
        $user6 = User::whereEmail('association6@kiswa.com')->first()->id;

        $this->createAssociation('https://albir.sa/', $UAE, [
            'translate' => [
                'title_ar' => 'جمعية البر الخيرية',
                'title_en' => 'Al Ber Charity Association',
                'description_ar' => 'امنح الناس فرصة لحياة أفضل',
                'description_en' => 'Give people chance for better life',
                ],
        ], $user, ActiveStatus::INACTIVE, 1);

        $this->createAssociation('https://albir.sa/', $UAE, [
            'translate' => [
                'title_ar' => 'جمعية ساعد الخيرية',
                'title_en' => 'Saed Charitable Society',
                'description_ar' => 'امنح الناس فرصة لحياة أفضل',
                'description_en' => 'Give people chance for better life',
            ],
        ], $user2, ActiveStatus::ACTIVE, 10);

        $this->createAssociation('https://albir.sa/', $UAE, [
            'translate' => [
                'title_ar' => 'جمعية ألفة الخيرية',
                'title_en' => 'Ulfah Charitable Society',
                'description_ar' => 'امنح الناس فرصة لحياة أفضل',
                'description_en' => 'Give people chance for better life',
            ],
        ], $user3, ActiveStatus::ACTIVE, 5);

        $this->createAssociation('https://albir.sa/', $UAE, [
            'translate' => [
                'title_ar' => 'جمعية اول جمعية لازم',
                'title_en' => 'Ulfah first association',
                'description_ar' => 'امنح الناس فرصة لحياة أفضل',
                'description_en' => 'Give people chance for better life',
            ],
        ], $user3, ActiveStatus::ACTIVE, 1);

        $this->createAssociation('https://albir.sa/', $KSA, [
            'translate' => [
                'title_ar' => 'مؤسسة البصر الخيرية',
                'title_en' => 'Al-Basr Charitable Foundation',
                'description_ar' => 'امنح الناس فرصة لحياة أفضل',
                'description_en' => 'Give people chance for better life',
            ],
        ], $user4, ActiveStatus::INACTIVE, 2);

        $this->createAssociation('https://albir.sa/', $KSA, [
            'translate' => [
                'title_ar' => 'مؤسسة العين الخيرية',
                'title_en' => 'Al Ain Charitable Foundation',
                'description_ar' => 'امنح الناس فرصة لحياة أفضل',
                'description_en' => 'Give people chance for better life',
            ],
        ], $user5, ActiveStatus::ACTIVE, 1);

        $this->createAssociation('https://albir.sa/', $KSA, [
            'translate' => [
                'title_ar' => 'مؤسسة زايد للأعمال الخيرية',
                'title_en' => 'Zayed Charitable Foundation',
                'description_ar' => 'امنح الناس فرصة لحياة أفضل',
                'description_en' => 'Give people chance for better life',
            ],
        ], $user6, ActiveStatus::ACTIVE, 10);

    }

    public function createAssociation($url, $country_id, $meta, $user_id, $status, $priority)
    {
        Association::create([
            'url' => $url,
            'meta' => $meta,
            'country_id' => $country_id,
            'user_id' => $user_id,
            'IBAN' => 'AZXXX23',
            'swift_code' => 'ZXCW1',
            'account_number' => 'ZXXXA',
            'status' => $status,
            'priority' => $priority,
        ]);
    }
}
