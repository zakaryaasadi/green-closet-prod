<?php

namespace Database\Seeders;

use App\Enums\PermissionType;
use App\Enums\RoleType;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allPermissions = Permission::all();

        $orderPermission = collect(Permission::where('name', 'like', '%ORDER%')->get());
        $newsPermission = collect(Permission::where('name', 'like', '%NEWS%')->get());
        $eventsPermission = collect(Permission::where('name', 'like', '%EVENT%')->get());

        $this->createRole(RoleType::SUPER_ADMIN, PermissionType::getDescription(RoleType::SUPER_ADMIN))
            ->givePermissionTo($allPermissions);

        $this->createRole(RoleType::ADMIN, PermissionType::getDescription(RoleType::ADMIN))
            ->givePermissionTo(Permission::all());

        $this->createRole('Order role', 'Manage Orders')
            ->givePermissionTo($orderPermission->all());

        $this->createRole('News role', 'Manage News')
            ->givePermissionTo($newsPermission->all());

        $this->createRole('Event role', 'Manage Events')
            ->givePermissionTo($eventsPermission->all());
    }

    private function createRole($name, $description): Builder|Model
    {
        if (Role::whereName($name)->count() > 0)
            return Role::whereName($name)->first();

        return Role::create([
            'name' => $name,
            'description' => $description,
            'guard_name' => 'api',
        ]);
    }
}
