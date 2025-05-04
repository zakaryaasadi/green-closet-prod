<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use App\Models\UserAccess;
use Illuminate\Database\Seeder;

class UserAccessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $UAE = Country::whereCode('AE')->first();
        $KSA = Country::whereCode('SA')->first();

        $orderManager = User::whereEmail('order@kiswa.com')->first();
        $admin = User::whereEmail('super-admin@kiswa.com')->first();
        $newsManager = User::whereEmail('news@kiswa.com')->first();
        $eventsManager = User::whereEmail('event@kiswa.com')->first();


        UserAccess::create([
            'user_id' => $admin->id,
            'country_id' => $KSA->id,
            'role_id' => Role::whereName('SUPER_ADMIN')->first()->id,
        ]);
        $orderRole = Role::whereName('Order role')->first();

        UserAccess::create([
            'user_id' => $orderManager->id,
            'country_id' => $UAE->id,
            'role_id' => $orderRole->id,
        ]);
        $orderManager->permissions()->syncWithoutDetaching($orderRole->getAllPermissions()->pluck('id'));

        $adminRole = Role::whereName(RoleType::SUPER_ADMIN)->first();
        UserAccess::create([
            'user_id' => $admin->id,
            'country_id' => $UAE->id,
            'role_id' => $adminRole->id,
        ]);
        $admin->permissions()->syncWithoutDetaching($adminRole->getAllPermissions()->pluck('id'));


        UserAccess::create([
            'user_id' => $orderManager->id,
            'country_id' => $KSA->id,
            'role_id' => Role::whereName('Order role')->first()->id,
        ]);

        UserAccess::create([
            'user_id' => $newsManager->id,
            'country_id' => $UAE->id,
            'role_id' => Role::whereName('News role')->first()->id,
        ]);

        UserAccess::create([
            'user_id' => $newsManager->id,
            'country_id' => $KSA->id,
            'role_id' => Role::whereName('News role')->first()->id,
        ]);

        UserAccess::create([
            'user_id' => $eventsManager->id,
            'country_id' => $UAE->id,
            'role_id' => Role::whereName('Event role')->first()->id,
        ]);
    }
}
