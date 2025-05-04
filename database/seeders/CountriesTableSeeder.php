<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createCountry(
            'United Arab Emirates',
            'AE', 'UAE', 'https://flagcdn.com/w320/ae.png', '+971', [
                'translate' => [
                    'name_ar' => 'الامارات',
                    'name_en' => 'United Arab Emirates',
                ],
            ]
        );
        $this->createCountry(
            'Saudi Arabia',
            'SA', 'SAR', 'https://flagcdn.com/w320/sa.png', '+966', [
                'translate' => [
                    'name_ar' => 'السعودية',
                    'name_en' => 'Saudi Arabia',
                ],
            ]
        );

        $this->createCountry(
            'Kuwait',
            'KW', 'KWT', 'https://flagcdn.com/w320/kw.png', '+965', [
                'translate' => [
                    'name_ar' => 'الكويت',
                    'name_en' => 'Kuwait',
                ],
            ]
        );

    }

    private function createCountry($name, $code, $ico, $flag, $code_number, $meta): Country
    {
        return Country::create([
            'name' => $name,
            'code' => $code,
            'ico' => $ico,
            'flag' => $flag,
            'code_number' => $code_number,
            'meta' => $meta,
        ]);
    }
}
