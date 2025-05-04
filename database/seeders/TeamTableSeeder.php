<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamTableSeeder extends Seeder
{
    public function run()
    {
        $UAE = Country::whereCode('AE')->first()->id;
        $KSA = Country::whereCode('SA')->first()->id;
        $KWT = Country::whereCode('KW')->first()->id;

        $this->createTeam('UAE Team', $UAE, [
            'translate' => [
                'name_ar' => 'فريق الامارات',
                'name_en' => 'UAE Team',
            ],
        ]);

        $this->createTeam('SA Team', $KSA, [
            'translate' => [
                'name_ar' => 'فريق السعودية',
                'name_en' => 'SA Team',
            ],
        ]);

        $this->createTeam('KWT TEAM', $KWT, [
            'translate' => [
                'name_ar' => 'فريق الكويت',
                'name_en' => 'KWT TEAM',
            ],
        ]);
    }

    public function createTeam($name, $country_id, $meta)
    {
        Team::create([
            'name' => $name,
            'country_id' => $country_id,
            'meta' => $meta,
        ]);
    }
}
