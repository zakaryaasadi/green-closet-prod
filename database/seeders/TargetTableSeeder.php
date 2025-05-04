<?php

namespace Database\Seeders;

use App\Enums\MonthsEnum;
use App\Models\Country;
use App\Models\Target;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class TargetTableSeeder extends Seeder
{
    /**
     * @throws FileCannotBeAdded
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function run()
    {
        $UAE = Country::whereCode('AE')->first()->id;
        $KSA = Country::whereCode('SA')->first()->id;
        $KW = Country::whereCode('KW')->first()->id;

        $this->createTarget($UAE, MonthsEnum::January);
        $this->createTarget($UAE, MonthsEnum::February);
        $this->createTarget($UAE, MonthsEnum::March);
        $this->createTarget($UAE, MonthsEnum::April);
        $this->createTarget($UAE, MonthsEnum::May);
        $this->createTarget($UAE, MonthsEnum::June);
        $this->createTarget($UAE, MonthsEnum::July);
        $this->createTarget($UAE, MonthsEnum::August);
        $this->createTarget($UAE, MonthsEnum::September);
        $this->createTarget($UAE, MonthsEnum::October);
        $this->createTarget($UAE, MonthsEnum::November);
        $this->createTarget($UAE, MonthsEnum::December);


        $this->createTarget($KSA, MonthsEnum::January);
        $this->createTarget($KSA, MonthsEnum::February);
        $this->createTarget($KSA, MonthsEnum::March);
        $this->createTarget($KSA, MonthsEnum::April);
        $this->createTarget($KSA, MonthsEnum::May);
        $this->createTarget($KSA, MonthsEnum::June);
        $this->createTarget($KSA, MonthsEnum::July);
        $this->createTarget($KSA, MonthsEnum::August);
        $this->createTarget($KSA, MonthsEnum::September);
        $this->createTarget($KSA, MonthsEnum::October);
        $this->createTarget($KSA, MonthsEnum::November);
        $this->createTarget($KSA, MonthsEnum::December);

        $this->createTarget($KW, MonthsEnum::January);
        $this->createTarget($KW, MonthsEnum::February);
        $this->createTarget($KW, MonthsEnum::March);
        $this->createTarget($KW, MonthsEnum::April);
        $this->createTarget($KW, MonthsEnum::May);
        $this->createTarget($KW, MonthsEnum::June);
        $this->createTarget($KW, MonthsEnum::July);
        $this->createTarget($KW, MonthsEnum::August);
        $this->createTarget($KW, MonthsEnum::September);
        $this->createTarget($KW, MonthsEnum::October);
        $this->createTarget($KW, MonthsEnum::November);
        $this->createTarget($KW, MonthsEnum::December);

    }

     public static function createTarget($country_id, $month): void
    {
        Target::create([
            'country_id' => $country_id,
            'orders_count' => 500,
            'weight_target' => 1000,
            'month' => $month,
        ]);
    }
}
