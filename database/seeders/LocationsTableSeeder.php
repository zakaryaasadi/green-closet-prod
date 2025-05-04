<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Location;
use App\Models\Team;
use App\Models\User;
use GeoJson\GeoJson;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teamUAE = Team::whereCountryId(Country::whereCode('AE')->first()->id)->first();
        $damac = Polygon::fromJson(GeoJson::jsonUnserialize([
            'type' => 'Polygon',
            'coordinates' => [[
                [55.367073, 25.000318],
                [55.367073, 25.00031768],
                [55.38269418, 24.97262174],
                [55.41385072, 24.97176587],
                [55.41968721, 24.98911558],
                [55.39943117, 24.99922863],
                [55.367073, 25.000318],
            ]], ]));
        $location = $this->createLocation('Abu Dhabi', 'c5328a', $damac, $teamUAE->id);
        $location->agents()->save(User::whereEmail('ramez@kiswa.com')->first());
        $location->agents()->save(User::whereEmail('izat@kiswa.com')->first());


        $dubai = Polygon::fromJson(GeoJson::jsonUnserialize([
            'type' => 'Polygon',
            'coordinates' => [[
                [55.427681, 25.24212],
                [55.4276813, 25.24211983],
                [55.48123965, 25.22938702],
                [55.5196918, 25.18993789],
                [55.4170383, 25.0886163],
                [55.32125125, 25.00401379],
                [55.27009616, 24.97522942],
                [55.21550784, 25.00556951],
                [55.1138843, 25.0568972],
                [55.10427122, 25.108048],
                [55.1152575, 25.15047605],
                [55.16538253, 25.14146334],
                [55.3260574, 25.31228189],
                [55.40879837, 25.25112529],
                [55.427681, 25.24212],
            ]], ]));
        $location = $this->createLocation('Dubai', '2816ff', $dubai, $teamUAE->id);
        $location->agents()->save(User::whereEmail('agent@kiswa.com')->first());

    }

    public function createLocation($name, $color, $area, $team_id)
    {
        $opacity = '42';

        return Location::create([
            'name' => $name,
            'color' => $color . $opacity,
            'area' => $area,
            'country_id' => 1,
            'team_id' => $team_id,
        ]);

    }
}
