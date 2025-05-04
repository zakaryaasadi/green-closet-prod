<?php

namespace Database\Seeders;

use App\Enums\PointStatus;
use App\Models\Point;
use App\Models\User;
use Illuminate\Database\Seeder;

class PointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'user@green-closet.com')->first();

        Point::create([
            'user_id' => $user->id,
            'order_id' => 1,
            'count' => 100,
            'ends_at' => '2022-11-11 12:00',
            'status' => PointStatus::ACTIVE,
        ]);

        Point::create([
            'user_id' => $user->id,
            'order_id' => 1,
            'count' => 100,
            'ends_at' => '2022-11-11 12:00',
            'status' => PointStatus::ACTIVE,
        ]);

        Point::create([
            'user_id' => $user->id,
            'order_id' => 1,
            'count' => 100,
            'ends_at' => '2022-11-11 12:00',
            'status' => PointStatus::ACTIVE,
        ]);

        Point::create([
            'user_id' => $user->id,
            'order_id' => 1,
            'count' => 100,
            'ends_at' => '2022-11-11 12:00',
            'status' => PointStatus::ACTIVE,
        ]);

        Point::create([
            'user_id' => $user->id,
            'order_id' => 1,
            'count' => 100,
            'ends_at' => '2022-11-11 12:00',
            'status' => PointStatus::ACTIVE,
        ]);

        Point::create([
            'user_id' => $user->id,
            'order_id' => 1,
            'count' => 100,
            'ends_at' => '2022-11-11 12:00',
            'status' => PointStatus::ACTIVE,
        ]);
        Point::create([
            'user_id' => $user->id,
            'order_id' => 1,
            'count' => 100,
            'ends_at' => '2022-11-11 12:00',
            'status' => PointStatus::ACTIVE,
        ]);

        Point::create([
            'user_id' => $user->id,
            'order_id' => 1,
            'count' => 100,
            'ends_at' => '2022-11-11 12:00',
            'status' => PointStatus::ACTIVE,
        ]);

        Point::create([
            'user_id' => $user->id,
            'order_id' => 1,
            'count' => 100,
            'ends_at' => '2022-11-11 12:00',
            'status' => PointStatus::ACTIVE,
        ]);

        Point::create([
            'user_id' => $user->id,
            'order_id' => 1,
            'count' => 100,
            'ends_at' => '2022-11-11 12:00',
            'status' => PointStatus::ACTIVE,
        ]);

        Point::create([
            'user_id' => $user->id,
            'order_id' => 2,
            'count' => 200,
            'ends_at' => '2022-10-01 12:00',
            'status' => PointStatus::FINISH,
            'used' => false,
        ]);

        Point::create([
            'user_id' => $user->id,
            'order_id' => 3,
            'count' => 500,
            'ends_at' => '2022-12-11 12:00',
            'status' => PointStatus::FINISH,
            'used' => false,
        ]);

        Point::create([
            'user_id' => $user->id,
            'order_id' => 4,
            'count' => 300,
            'ends_at' => '2022-10-07 12:00',
            'status' => PointStatus::FINISH,
            'used' => true,
        ]);

        Point::create([
            'user_id' => $user->id,
            'order_id' => 5,
            'count' => 200,
            'ends_at' => '2022-12-12 12:00',
            'status' => PointStatus::ACTIVE,
            'used' => false,
        ]);

        Point::create([
            'user_id' => $user->id,
            'order_id' => 5,
            'count' => 500,
            'ends_at' => '2022-12-12 12:00',
            'used' => true,
            'status' => PointStatus::FINISH,
        ]);
    }
}
