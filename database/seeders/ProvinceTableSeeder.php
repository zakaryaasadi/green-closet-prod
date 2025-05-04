<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\District;
use App\Models\Neighborhood;
use App\Models\Province;
use App\Models\Street;
use Illuminate\Database\Seeder;

class ProvinceTableSeeder extends Seeder
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

        $dubai = Province::create([
            'country_id' => $UAE,
            'name' => 'Dubai',
            'meta' => [
                'translate' => [
                    'name_ar' => 'دبي',
                    'name_en' => 'Dubai',
                ],
            ],
        ]);

        $downTown = District::create([
            'country_id' => $UAE,
            'province_id' => $dubai->id,
            'name' => 'Downtown Dubai',
            'meta' => [
                'translate' => [
                    'name_ar' => 'داون تاون دبي',
                    'name_en' => 'Downtown Dubai',
                ],
            ],
        ]);

        $mediaCity = District::create([
            'country_id' => $UAE,
            'province_id' => $dubai->id,
            'name' => 'Media city',
            'meta' => [
                'translate' => [
                    'name_ar' => 'ميديا سيتي',
                    'name_en' => 'Media city',
                ],
            ],
        ]);

        $alserkal = Neighborhood::create([
            'country_id' => $UAE,
            'district_id' => $downTown->id,
            'name' => 'Alserkal Avenue',
            'meta' => [
                'translate' => [
                    'name_ar' => 'السركال',
                    'name_en' => 'Alserkal Avenue',
                ],
            ],
        ]);

        $mediaCityNeighborhood = Neighborhood::create([
            'country_id' => $UAE,
            'district_id' => $mediaCity->id,
            'name' => 'Media city neighborhood',
            'meta' => [
                'translate' => [
                    'name_ar' => 'حي ميديا سيتي',
                    'name_en' => 'Media city neighborhood',
                ],
            ],
        ]);

        Street::create([
            'country_id' => $UAE,
            'neighborhood_id' => $alserkal->id,
            'name' => 'Al Diyafa St',
            'meta' => [
                'translate' => [
                    'name_ar' => 'شارع الضيافة',
                    'name_en' => 'Al Diyafa St',
                ],
            ],
        ]);

        Street::create([
            'country_id' => $UAE,
            'neighborhood_id' => $mediaCityNeighborhood->id,
            'name' => 'Media city St',
            'meta' => [
                'translate' => [
                    'name_ar' => 'شارع ميديا سيتي',
                    'name_en' => 'Media city St',
                ],
            ],
        ]);

        $abuDhabi = Province::create([
            'country_id' => $UAE,
            'name' => 'Abu Dhabi',
            'meta' => [
                'translate' => [
                    'name_ar' => 'أبو ظبي',
                    'name_en' => 'Abu Dhabi',
                ],
            ],
        ]);

        $ain = District::create([
            'country_id' => $UAE,
            'province_id' => $abuDhabi->id,
            'name' => 'Al Ain',
            'meta' => [
                'translate' => [
                    'name_ar' => 'العين',
                    'name_en' => 'Al Ain',
                ],
            ],
        ]);

        $tawam = Neighborhood::create([
            'country_id' => $UAE,
            'district_id' => $ain->id,
            'name' => 'Tawam',
            'meta' => [
                'translate' => [
                    'name_ar' => 'التوام',
                    'name_en' => 'Al Tawam',
                ],
            ],
        ]);

        Street::create([
            'country_id' => $UAE,
            'neighborhood_id' => $tawam->id,
            'name' => 'Al Tawam1 St',
            'meta' => [
                'translate' => [
                    'name_ar' => 'شارع التوام 1',
                    'name_en' => 'Al Tawam1 St',
                ],
            ],
        ]);


        $riyadh = Province::create([
            'country_id' => $KSA,
            'name' => 'Riyadh',
            'meta' => [
                'translate' => [
                    'name_ar' => 'الرياض',
                    'name_en' => 'Riyadh',
                ],
            ],
        ]);

        $al_Dilam = District::create([
            'country_id' => $KSA,
            'province_id' => $riyadh->id,
            'name' => 'Al‑Dilam',
            'meta' => [
                'translate' => [
                    'name_ar' => 'الدلم',
                    'name_en' => 'Al‑Dilam',
                ],
            ],
        ]);

        $al_akhoa = Neighborhood::create([
            'country_id' => $KSA,
            'district_id' => $al_Dilam->id,
            'name' => 'Al Akhoa',
            'meta' => [
                'translate' => [
                    'name_ar' => 'الاخوة',
                    'name_en' => 'Al Akhoa',
                ],
            ],
        ]);

        Street::create([
            'country_id' => $KSA,
            'neighborhood_id' => $al_akhoa->id,
            'name' => 'Al Akhoa 1 St',
            'meta' => [
                'translate' => [
                    'name_ar' => 'شارع الاخوة 1',
                    'name_en' => 'Al Akhoa 1 St',
                ],
            ],
        ]);

    }
}
