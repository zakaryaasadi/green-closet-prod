<?php

namespace Database\Seeders;

use App\Enums\PermissionType;
use App\Enums\RoleType;
use App\Enums\UserType;
use App\Models\AgentSettings;
use App\Models\Country;
use App\Models\Permission;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $updateUserPermission = Permission::where('name', '=', PermissionType::UPDATE_USER_PERMISSIONS)->first();
        $dashboardAccessPermission = Permission::where('name', '=', PermissionType::DASHBOARD_ACCESS)->first();
        $UAE = Country::whereCode('AE')->first()->id;

        $root = $this->createUser(
            'super-admin',
            'super-admin@green-closet.com',
            '+971554835477',
            UserType::ADMIN,
        );
        $root->assignRole(RoleType::SUPER_ADMIN);

        $admin = $this->createUser(
            'admin',
            'admin@green-closet.com',
            '+971',
            UserType::ADMIN
        );
        $admin->assignRole(RoleType::ADMIN);

        $this->createUser(
            'user',
            'user@green-closet.com',
            '+971554838677',
            UserType::CLIENT
        );

        $this->createUser(
            'amjad',
            'amjad@green-closet.com',
            '+971554838600',
            UserType::CLIENT
        );

        $agent = $this->createUser(
            'agent',
            'agent@green-closet.com',
            '+971554838675',
            UserType::AGENT
        );
        $agent->update(['team_id' => Team::whereCountryId($UAE)->first()->id]);
        $agent->save();
        AgentSettings::create([
            'agent_id' => $agent->id,
            'tasks_per_day' => 2,
            'budget' => 2,
            'holiday' => 1,
            'start_work' => '11:00',
            'finish_work' => '10:00',
            'work_shift' => 2,
        ]);
        $agent1 = $this->createUser(
            'ramez',
            'ramez@green-closet.com',
            '+971585561707',
            UserType::CLIENT
        );
        AgentSettings::create([
            'agent_id' => $agent1->id,
            'tasks_per_day' => 2,
            'budget' => 2,
            'holiday' => 1,
            'start_work' => '11:00',
            'finish_work' => '10:00',
            'work_shift' => 2,
        ]);
        $agent2 = $this->createUser(
            'izat',
            'izat@green-closet.com',
            '+9715548386113',
            UserType::AGENT
        );
        AgentSettings::create([
            'agent_id' => $agent2->id,
            'tasks_per_day' => 2,
            'budget' => 2,
            'holiday' => 1,
            'start_work' => '11:00',
            'finish_work' => '10:00',
            'work_shift' => 2,
        ]);

        $this->createUser(
            'association',
            'association@green-closet.com',
            '+971554838611',
            UserType::ASSOCIATION
        );

        $this->createUser(
            'association',
            'association2@green-closet.com',
            '+971554838612',
            UserType::ASSOCIATION
        );

        $this->createUser(
            'association',
            'association3@green-closet.com',
            '+971554838613',
            UserType::ASSOCIATION
        );

        $this->createUser(
            'association',
            'association4@green-closet.com',
            '+9715548386141',
            UserType::ASSOCIATION
        );

        $this->createUser(
            'association',
            'association5@green-closet.com',
            '+9715548386151',
            UserType::ASSOCIATION
        );

        $this->createUser(
            'association',
            'association6@green-closet.com',
            '+9715548386161',
            UserType::ASSOCIATION
        );

        $this->createUser(
            'association',
            'association7@green-closet.com',
            '+9715548386110',
            UserType::ASSOCIATION
        );

        $editor = $this->createUser(
            'amjad',
            'order@green-closet.com',
            '+971554838123',
            UserType::ADMIN
        );
        $editor->permissions()->attach([$dashboardAccessPermission->id, $updateUserPermission->id]);

        $editor = $this->createUser(
            'nour',
            'news@green-closet.com',
            '+971554838144',
            UserType::ADMIN
        );
        $editor->permissions()->attach([$dashboardAccessPermission->id, $updateUserPermission->id]);

        $editor = $this->createUser(
            'Zinab',
            'event@green-closet.com',
            '+971554838222',
            UserType::ADMIN
        );
        $editor->permissions()->attach([$dashboardAccessPermission->id, $updateUserPermission->id]);

    }

    private function createUser($name, $email, $phone, $type): Model|User
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => 'secret',
            'phone' => $phone,
            'type' => $type,
            'country_id' => Country::whereCode('AE')->first()->id,
            'email_verified_at' => now(),
        ]);
    }
}
