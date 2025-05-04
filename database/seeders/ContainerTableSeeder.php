<?php

namespace Database\Seeders;

use App\Enums\ContainerStatus;
use App\Enums\ContainerType;
use App\Enums\DischargeShift;
use App\Enums\UserType;
use App\Models\Association;
use App\Models\Container;
use App\Models\ContainerDetails;
use App\Models\Country;
use App\Models\District;
use App\Models\Neighborhood;
use App\Models\Province;
use App\Models\Street;
use App\Models\Team;
use App\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Seeder;

class ContainerTableSeeder extends Seeder
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
        $UAETeam = Team::whereCountryId($UAE)->first()->id;
        $KSATeam = Team::whereCountryId($KSA)->first()->id;
        $provinceUAE = Province::whereCountryId($UAE)->first();
        $districtUAE = District::whereCountryId($UAE)->first();
        $neighborhoodUAE = Neighborhood::whereCountryId($UAE)->first();
        $streetUAE = Street::whereCountryId($UAE)->first();
        $province2UAE = Province::whereName('Abu Dhabi')->first();
        $district2UAE = District::whereName('Al Ain')->first();
        $neighborhood2UAE = Neighborhood::whereName('Tawam')->first();
        $street2UAE = Street::whereName('Al Tawam1 St')->first();
        $provinceKSA = Province::whereCountryId($KSA)->first();
        $districtKSA = District::whereCountryId($KSA)->first();
        $neighborhoodKSA = Neighborhood::whereCountryId($KSA)->first();
        $streetKSA = Street::whereCountryId($KSA)->first();
        $association_id = Association::whereUserId(User::whereEmail('association@kiswa.com')->first()->id)->first()->id;
        $agent = User::whereType(UserType::AGENT)->first();
        $point = new Point('25.745601', '55.976392');
        $point2 = new Point('23.975211', '56.863206');
        $point3 = new Point('23.264562', '58.386766');
        $point4 = new Point('22.047968', '58.562665');

        $container = $this->createContainer('23476', $association_id, $UAETeam, $UAE, $provinceUAE->id, $districtUAE->id, $neighborhoodUAE->id,
            $streetUAE->id, DischargeShift::EVENING_SHIFT, ContainerType::SHOES,
            ContainerStatus::IN_MAINTENANCE, $point, 'Behind supermarket');

        $container = $this->createContainer('23476', $association_id, $UAETeam, $UAE, $provinceUAE->id, $districtUAE->id, $neighborhoodUAE->id,
            $streetUAE->id, DischargeShift::EVENING_SHIFT, ContainerType::GLASS,
            ContainerStatus::ON_THE_FIELD, $point, 'Behind supermarket');

        $container = $this->createContainer('23476', $association_id, $UAETeam, $UAE, $provinceUAE->id, $districtUAE->id, $neighborhoodUAE->id,
            $streetUAE->id, DischargeShift::MORNING_SHIFT, ContainerType::PLASTIC,
            ContainerStatus::HANGING, $point, 'Behind supermarket');

        $container = $this->createContainer('23476', $association_id, $UAETeam, $UAE, $provinceUAE->id, $districtUAE->id, $neighborhoodUAE->id,
            $streetUAE->id, DischargeShift::EVENING_SHIFT, ContainerType::CLOTHES,
            ContainerStatus::SCRAP, $point, 'Behind supermarket');

        $container = $this->createContainer('23476', $association_id, $UAETeam, $UAE, $provinceUAE->id, $districtUAE->id, $neighborhoodUAE->id,
            $streetUAE->id, DischargeShift::MORNING_SHIFT, ContainerType::CLOTHES,
            ContainerStatus::IN_THE_WAREHOUSE, $point, 'Behind supermarket');

        $container = $this->createContainer('23476', $association_id, $UAETeam, $UAE, $provinceUAE->id, $districtUAE->id, $neighborhoodUAE->id,
            $streetUAE->id, DischargeShift::MORNING_SHIFT, ContainerType::PLASTIC,
            ContainerStatus::SCRAP, $point, 'Behind supermarket');

        $container = $this->createContainer('23476', $association_id, $UAETeam, $UAE, $provinceUAE->id, $districtUAE->id, $neighborhoodUAE->id,
            $streetUAE->id, DischargeShift::EVENING_SHIFT, ContainerType::SHOES,
            ContainerStatus::IN_MAINTENANCE, $point, 'Behind supermarket');

        $container = $this->createContainer('23476', $association_id, $UAETeam, $UAE, $provinceUAE->id, $districtUAE->id, $neighborhoodUAE->id,
            $streetUAE->id, DischargeShift::NIGHT_SHIFT, ContainerType::SHOES,
            ContainerStatus::IN_THE_WAREHOUSE, $point, 'Behind supermarket');

        $container = $this->createContainer('23476', $association_id, $UAETeam, $UAE, $provinceUAE->id, $districtUAE->id, $neighborhoodUAE->id,
            $streetUAE->id, DischargeShift::NIGHT_SHIFT, ContainerType::SHOES,
            ContainerStatus::IN_MAINTENANCE, $point, 'Behind supermarket');

        $container->update(['status' => ContainerStatus::ON_THE_FIELD]);
        $container->update(['status' => ContainerStatus::IN_MAINTENANCE, 'type' => ContainerType::CLOTHES]);

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2022-11-01 10:00:00',
        ]);

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2020-11-01 10:00:00',
        ]);

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 10,
            'value' => 20,
            'date' => '2022-09-01 12:00:00',
        ]);

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2020-10-01 03:00:00',
        ]);

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 40,
            'value' => 20,
            'date' => '2021-09-10 05:00:00',
        ]);

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2021-08-10 10:00:00',
        ]);

        $container = $this->createContainer('22112', $association_id, $UAETeam, $UAE, $provinceUAE->id,
            District::whereName('Media city')->first()->id, Neighborhood::whereName('Media city neighborhood')->first()->id,
            Street::whereName('Media city St')->first()->id, DischargeShift::EVENING_SHIFT, ContainerType::SHOES,
            ContainerStatus::IN_MAINTENANCE, $point, 'Behind supermarket');


        $container = $this->createContainer('10001', null, $UAETeam, $UAE, $provinceUAE->id, $districtUAE->id, $neighborhoodUAE->id,
            $streetUAE->id, DischargeShift::NIGHT_SHIFT, ContainerType::CLOTHES,
            ContainerStatus::ON_THE_FIELD, $point2, 'Behind Santiago Bernabéu');

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2020-10-01 10:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2021-11-11 10:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2021-10-10 10:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2020-02-10 12:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2020-03-10 06:00:00',
        ]);

        $container = $this->createContainer('20202', null, $UAETeam, $UAE, $province2UAE->id, $district2UAE->id, $neighborhood2UAE->id,
            $street2UAE->id, DischargeShift::MORNING_SHIFT, ContainerType::PLASTIC,
            ContainerStatus::HANGING, $point3, 'Behind supermarket');

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2021-02-10 08:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2020-10-10 06:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2020-12-10 06:00:00',
        ]);

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2021-02-10 06:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2022-03-10 11:00:00',
        ]);

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2022-08-10 12:00:00',
        ]);

        $container = $this->createContainer('11111', $association_id, $UAETeam, $UAE, $province2UAE->id, $district2UAE->id, $neighborhood2UAE->id,
            $street2UAE->id, DischargeShift::EVENING_SHIFT, ContainerType::SHOES,
            ContainerStatus::SCRAP, $point4, 'Behind Santiago Bernabéu');

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2022-11-12 10:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2022-12-09 12:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2022-07-10 12:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2022-10-10 12:00:00',
        ]);

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2021-01-10 09:00:00',
        ]);

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2022-05-12 08:00:00',
        ]);

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2022-03-12 07:00:00',
        ]);

        $container = $this->createContainer('11', $association_id, $KSATeam, $KSA, $provinceKSA->id, $districtKSA->id, $neighborhoodKSA->id,
            $streetKSA->id, DischargeShift::EVENING_SHIFT, ContainerType::SHOES,
            ContainerStatus::IN_MAINTENANCE, $point, 'Behind supermarket');

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2021-03-12 07:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2022-04-12 07:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2021-05-12 07:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2020-06-12 07:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2021-02-12 07:00:00',
        ]);
        $container = $this->createContainer('333', null, $KSATeam, $KSA, $provinceKSA->id, $districtKSA->id, $neighborhoodKSA->id,
            $streetKSA->id, DischargeShift::NIGHT_SHIFT, ContainerType::CLOTHES,
            ContainerStatus::ON_THE_FIELD, $point2, 'Behind Santiago Bernabéu');

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2022-01-12 07:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2022-02-03 07:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2022-03-12 07:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2021-06-10 07:00:00',
        ]);

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2021-03-17 07:00:00',
        ]);
        $container = $this->createContainer('444', null, $KSATeam, $KSA, $provinceKSA->id, $districtKSA->id, $neighborhoodKSA->id,
            $streetKSA->id, DischargeShift::MORNING_SHIFT, ContainerType::PLASTIC,
            ContainerStatus::HANGING, $point3, 'Behind supermarket');

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2022-01-10 07:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2022-02-01 07:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2021-03-03 07:00:00',
        ]);
        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2021-08-10 07:00:00',
        ]);

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2021-07-17 07:00:00',
        ]);

        $container = $this->createContainer('55151', $association_id, $KSATeam, $KSA, $provinceKSA->id, $districtKSA->id, $neighborhoodKSA->id,
            $streetKSA->id, DischargeShift::EVENING_SHIFT, ContainerType::SHOES,
            ContainerStatus::SCRAP, $point4, 'Behind Santiago Bernabéu');

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2022-08-10 10:00:00',
        ]);

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2022-09-12 11:00:00',
        ]);

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2022-01-10 07:00:00',
        ]);

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 20,
            'value' => 20,
            'date' => '2022-11-17 07:00:00',
        ]);

        $container = $this->createContainer('33aabb', 3, $UAETeam, $UAE, $provinceUAE->id, $districtUAE->id, $neighborhoodUAE->id,
            $streetUAE->id, DischargeShift::NIGHT_SHIFT, ContainerType::PLASTIC,
            ContainerStatus::IN_MAINTENANCE, $point, 'Behind plastic');

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 10,
            'value' => 20,
            'date' => '2022-11-17 07:00:00',
        ]);

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 5,
            'value' => 10,
            'date' => '2022-12-17 07:00:00',
        ]);
        $container = $this->createContainer('123aa', 3, $UAETeam, $UAE, $provinceUAE->id, $districtUAE->id, $neighborhoodUAE->id,
            $streetUAE->id, DischargeShift::NIGHT_SHIFT, ContainerType::SHOES,
            ContainerStatus::IN_MAINTENANCE, $point, 'Behind shoes');


        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 5,
            'value' => 10,
            'date' => '2022-12-17 07:00:00',
        ]);

        $container = $this->createContainer('23476', 3, $UAETeam, $UAE, $provinceUAE->id, $districtUAE->id, $neighborhoodUAE->id,
            $streetUAE->id, DischargeShift::NIGHT_SHIFT, ContainerType::GLASS,
            ContainerStatus::IN_MAINTENANCE, $point, 'Behind glass');

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 5,
            'value' => 10,
            'date' => '2022-12-17 07:00:00',
        ]);

        ContainerDetails::create([
            'agent_id' => $agent->id,
            'container_id' => $container->id,
            'weight' => 5,
            'value' => 10,
            'date' => '2023-02-17 07:00:00',
        ]);
    }

    public function createContainer($code, $association_id, $team_id, $country_id, $province_id, $district_id,
                                    $neighborhood_id, $street_id, $discharge_shift, $type, $status, $location,
                                    $location_description)
    {
        return Container::create([
            'code' => $code,
            'association_id' => $association_id,
            'team_id' => $team_id,
            'country_id' => $country_id,
            'province_id' => $province_id,
            'district_id' => $district_id,
            'neighborhood_id' => $neighborhood_id,
            'street_id' => $street_id,
            'discharge_shift' => $discharge_shift,
            'type' => $type,
            'status' => $status,
            'location' => $location,
            'location_description' => $location_description,
        ]);
    }
}
