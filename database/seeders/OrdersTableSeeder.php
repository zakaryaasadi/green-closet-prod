<?php

namespace Database\Seeders;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PaymentStatus;
use App\Models\Address;
use App\Models\Association;
use App\Models\Country;
use App\Models\Item;
use App\Models\ItemOrders;
use App\Models\Order;
use App\Models\Province;
use App\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'user@kiswa.com')->first();
        $amjad = User::where('email', 'amjad@kiswa.com')->first();
        $country = Country::whereCode('AE')->first();
        $countryKW = Country::whereCode('KW')->first();
        $agent = User::where('email', 'agent@kiswa.com')->first();
        $association = Association::whereUserId(User::whereEmail('association@kiswa.com')->first()->id)->first();


        $test = Province::create([
            'country_id' => $country->id,
            'name' => 'test',
            'meta' => [
                'translate' => [
                    'name_ar' => 'test',
                    'name_en' => 'test',
                ],
            ],
        ]);


        $address = Address::create([
            'user_id' => $user->id,
            'province_id' => $test->id,
            'location' => new Point('25.745601', '55.976392'),
            'location_title' => 'MY Home',
            'location_province' => 'Dubai',
        ]);
        $order = Order::create([
            'location' => new Point('25.745601', '55.976392'),
            'country_id' => $country->id,
            'province_id' => $test->id,
            'customer_id' => $user->id,
            'address_id' => $address->id,
            'weight' => 200,
            'status' => OrderStatus::ASSIGNED,
            'type' => OrderType::RECYCLING,
            'platform' => 'Website',
        ]);

        $order = Order::create([
            'location' => new Point('25.745601', '55.976392'),
            'country_id' => $country->id,
            'province_id' => $test->id,
            'customer_id' => $user->id,
            'address_id' => $address->id,
            'weight' => 130,
            'status' => OrderStatus::POSTPONED,
            'type' => OrderType::RECYCLING,
            'platform' => 'Website',
        ]);

        $order = Order::create([
            'location' => new Point('25.745601', '55.976392'),
            'country_id' => $country->id,
            'province_id' => $test->id,
            'customer_id' => $user->id,
            'address_id' => $address->id,
            'weight' => 200,
            'status' => OrderStatus::ASSIGNED,
            'type' => OrderType::RECYCLING,
            'platform' => 'Website',
        ]);

        $order->update(['status' => OrderStatus::ACCEPTED]);
        $order->update(['agent_id' => $agent->id]);
        $agent->agentOrders()->first()->update(['status' => OrderStatus::DELIVERING]);
        $order->update(['image' => 'https://kiswauae.com/assets/img/m3.jpg']);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('23.975211', '56.863206'),
            'location_title' => 'MY Company',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('23.975211', '56.863206'),
            'country_id' => $country->id,
            'customer_id' => $user->id,
            'agent_id' => $agent->id,
            'address_id' => $address->id,
            'weight' => 200,
            'status' => OrderStatus::ASSIGNED,
            'platform' => 'call',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('23.264562', '58.386766'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('23.264562', '58.386766'),
            'country_id' => $country->id,
            'customer_id' => $user->id,
            'agent_id' => $agent->id,
            'address_id' => $address->id,
            'weight' => 200,
            'status' => OrderStatus::ASSIGNED,
            'platform' => 'call',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('22.047968', '58.562665'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('22.047968', '58.562665'),
            'country_id' => $country->id,
            'customer_id' => $user->id,
            'address_id' => $address->id,
            'weight' => 300,
            'agent_id' => $agent->id,
            'status' => OrderStatus::ACCEPTED,
            'platform' => 'call',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('25.406562', '51.205555'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('25.406562', '51.205555'),
            'country_id' => $country->id,
            'customer_id' => $user->id,
            'address_id' => $address->id,
            'agent_id' => $agent->id,
            'weight' => 500,
            'status' => OrderStatus::ACCEPTED,
            'platform' => 'call',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('28.455169', '46.152955'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('28.455169', '46.152955'),
            'country_id' => $country->id,
            'customer_id' => $user->id,
            'address_id' => $address->id,
            'weight' => 250,
            'agent_id' => $agent->id,
            'platform' => 'call',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('24.762793', '39.952528'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('24.762793', '39.952528'),
            'country_id' => $country->id,
            'customer_id' => $user->id,
            'address_id' => $address->id,
            'agent_id' => $agent->id,
            'weight' => 300,
            'platform' => 'call',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('24.664990', '46.709958'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('24.664990', '46.709958'),
            'country_id' => $country->id,
            'customer_id' => $user->id,
            'address_id' => $address->id,
            'weight' => 300,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-10-10 02:00:00',
            'ends_at' => '2022-10-10 03:00:00',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('24.407888', '46.818230'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('24.407888', '46.818230'),
            'country_id' => $country->id,
            'customer_id' => $user->id,
            'address_id' => $address->id,
            'weight' => 300,
            'agent_id' => $agent->id,
            'status' => OrderStatus::CREATED,
            'platform' => 'call',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('25.263047', '55.290648'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('25.263047', '55.290648'),
            'country_id' => $country->id,
            'customer_id' => $user->id,
            'address_id' => $address->id,
            'weight' => 300,
            'agent_id' => $agent->id,
            'status' => OrderStatus::ACCEPTED,
            'platform' => 'call',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('25.253111', '55.289274'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('25.253111', '55.289274'),
            'country_id' => $country->id,
            'customer_id' => $user->id,
            'address_id' => $address->id,
            'weight' => 300,
            'agent_id' => $agent->id,
            'status' => OrderStatus::DELIVERING,
            'start_at' => '2022-10-10 02:30:00',
            'platform' => 'call',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('25.2180181', '55.272096'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('25.218018', '55.272096'),
            'country_id' => $country->id,
            'customer_id' => $user->id,
            'address_id' => $address->id,
            'weight' => 300,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-10-10 02:30:00',
            'ends_at' => '2022-10-10 03:00:00',
            'platform' => 'call',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('23.364446', '57.521047'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('23.364446', '57.521047'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'weight' => 300,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-10-10 02:40:00',
            'ends_at' => '2022-10-10 03:00:00',
            'platform' => 'call',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('20.680073', '57.344782'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('20.680073', '57.344782'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => $association->id,
            'weight' => 900,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-10-10 02:50:00',
            'ends_at' => '2022-10-10 03:10:00',
            'platform' => 'call',
        ]);

        Order::create([
            'location' => new Point('20.680073', '57.344782'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => User::wherePhone('+971554838600')->first()->id,
            'association_id' => $association->id,
            'weight' => 900,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-10-10 02:50:00',
            'ends_at' => '2022-10-10 03:10:00',
            'platform' => 'call',
        ]);

        Order::create([
            'location' => new Point('20.680073', '57.344782'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => User::wherePhone('+971554838600')->first()->id,
            'association_id' => $association->id,
            'weight' => 900,
            'agent_id' => $agent->id,
            'status' => OrderStatus::CREATED,
            'platform' => 'Website',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('23.951116', '53.649649'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('23.951116', '53.649649'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => $association->id,
            'weight' => 200,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-10-10 04:40:00',
            'ends_at' => '2022-10-10 05:10:00',
            'platform' => 'call',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('24.256981', '54.697536'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('24.256981', '54.697536'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => $association->id,
            'weight' => 13,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-10-10 10:40:00',
            'ends_at' => '2022-10-10 11:00:00',
            'platform' => 'website',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('24.136728', '55.686966'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('24.136728', '55.686966'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => $association->id,
            'weight' => 33,
            'agent_id' => $agent->id,
            'status' => OrderStatus::CANCEL,
            'platform' => 'website',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('23.271627', '56.544472'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('23.271627', '56.544472'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => $association->id,
            'weight' => 20,
            'agent_id' => $agent->id,
            'status' => OrderStatus::CANCEL,
            'platform' => 'website',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('23.476347', '58.433108'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('23.476347', '58.433108'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => $association->id,
            'weight' => 11,
            'agent_id' => $agent->id,
            'status' => OrderStatus::DELIVERING,
            'start_at' => '2022-10-10 06:40:00',
            'platform' => 'whatsapp',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('29.322804', '47.720935'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('29.322804', '47.720935'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => $association->id,
            'weight' => 22,
            'agent_id' => $agent->id,
            'status' => OrderStatus::DELIVERING,
            'start_at' => '2022-10-10 13:40:00',
            'platform' => 'whatsapp',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('29.586833', '47.404316'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('29.586833', '47.404316'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => $association->id,
            'weight' => 22,
            'agent_id' => $agent->id,
            'status' => OrderStatus::DELIVERING,
            'start_at' => '2022-10-10 12:00:00',
            'platform' => 'whatsapp',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('15.548961', '46.978581'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('15.548961', '46.978581'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => $association->id,
            'weight' => 22,
            'agent_id' => $agent->id,
            'status' => OrderStatus::DELIVERING,
            'start_at' => '2022-10-10 12:00:00',
            'platform' => 'whatsapp',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('14.830115', '44.372985'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('14.830115', '44.372985'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => $association->id,
            'weight' => 22,
            'agent_id' => $agent->id,
            'status' => OrderStatus::DELIVERING,
            'start_at' => '2022-09-10 12:00:00',
            'platform' => 'whatsapp',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('29.722406', '40.024747'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('29.722406', '40.024747'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => $association->id,
            'weight' => 22,
            'agent_id' => $agent->id,
            'status' => OrderStatus::DELIVERING,
            'start_at' => '2022-09-10 02:00:00',
            'platform' => 'call',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('23.73079', '53.510975'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('23.730795', '53.510975'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => $association->id,
            'weight' => 22,
            'agent_id' => $agent->id,
            'status' => OrderStatus::DELIVERING,
            'start_at' => '2022-08-10 01:00:00',
            'platform' => 'whatsapp',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('23.663393', '53.819363'),
            'location_title' => 'Work',
            'location_province' => 'Dubai',
        ]);
        Order::create([
            'location' => new Point('23.663393', '53.819363'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => $association->id,
            'weight' => 22,
            'agent_id' => $agent->id,
            'status' => OrderStatus::DELIVERING,
            'start_at' => '2022-08-11 12:00:00',
            'platform' => 'whatsapp',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'location' => new Point('23.675971', '54.083211'),
            'location_title' => 'Work',
            'location_province' => 'City',
        ]);
        Order::create([
            'location' => new Point('23.675971', '54.083211'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => $association->id,
            'weight' => 22,
            'agent_id' => $agent->id,
            'status' => OrderStatus::DELIVERING,
            'start_at' => '2022-07-10 08:00:00',
            'platform' => 'whatsapp',
        ]);

        $order = Order::create([
            'country_id' => $country->id,
            'customer_id' => $user->id,
            'agent_id' => $agent->id,
            'address_id' => $address->id,
            'value' => 200,
            'status' => OrderStatus::SUCCESSFUL,
            'type' => OrderType::RECYCLING,
            'weight' => 200,
            'start_at' => '01-01-2023 12:00',
            'ends_at' => '02-01-2023 12:00',
            'start_task' => '01-01-2023 12:00',
            'platform' => 'call',
        ]);

        $item = Item::first();
        ItemOrders::create([
            'item_id' => $item->id,
            'order_id' => $order->id,
            'weight' => 5,
        ]);
        ItemOrders::create([
            'item_id' => $item->id,
            'order_id' => $order->id,
            'weight' => 2,
        ]);
        ItemOrders::create([
            'item_id' => $item->id,
            'order_id' => $order->id,
            'weight' => 4,
        ]);
        ItemOrders::create([
            'item_id' => $item->id,
            'order_id' => $order->id,
            'weight' => 5,
        ]);
        ItemOrders::create([
            'item_id' => $item->id,
            'order_id' => $order->id,
            'weight' => 5,
        ]);

        $order = Order::create([
            'country_id' => $countryKW->id,
            'customer_id' => $user->id,
            'agent_id' => $agent->id,
            'address_id' => $address->id,
            'value' => 200,
            'status' => OrderStatus::SUCCESSFUL,
            'type' => OrderType::RECYCLING,
            'weight' => 200,
            'start_at' => '01-01-2023 12:00',
            'ends_at' => '02-01-2023 12:00',
            'start_task' => '01-01-2023 12:00',
            'platform' => 'call',
        ]);

        ItemOrders::create([
            'item_id' => $item->id,
            'order_id' => $order->id,
            'weight' => 5,
        ]);
        ItemOrders::create([
            'item_id' => $item->id,
            'order_id' => $order->id,
            'weight' => 2,
        ]);
        ItemOrders::create([
            'item_id' => $item->id,
            'order_id' => $order->id,
            'weight' => 4,
        ]);
        ItemOrders::create([
            'item_id' => $item->id,
            'order_id' => $order->id,
            'weight' => 5,
        ]);
        ItemOrders::create([
            'item_id' => $item->id,
            'order_id' => $order->id,
            'weight' => 5,
        ]);

        $order = Order::create([
            'country_id' => $countryKW->id,
            'customer_id' => $user->id,
            'agent_id' => $agent->id,
            'address_id' => $address->id,
            'value' => 200,
            'status' => OrderStatus::SUCCESSFUL,
            'type' => OrderType::DONATION,
            'weight' => 200,
            'start_at' => '01-01-2023 12:00',
            'ends_at' => '02-01-2023 12:00',
            'start_task' => '01-01-2023 12:00',
            'platform' => 'call',
        ]);

        ItemOrders::create([
            'item_id' => $item->id,
            'order_id' => $order->id,
            'weight' => 5,
        ]);
        ItemOrders::create([
            'item_id' => $item->id,
            'order_id' => $order->id,
            'weight' => 5,
        ]);

        Order::create([
            'location' => new Point('23.675971', '54.083211'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => 3,
            'weight' => 22,
            'value' => 100,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-07-10 08:00:00',
            'platform' => 'whatsapp',
            'payment_status' => PaymentStatus::UNPAID,
        ]);

        Order::create([
            'location' => new Point('23.675971', '54.083211'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $amjad->id,
            'association_id' => 3,
            'weight' => 22,
            'value' => 20,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-07-10 08:00:00',
            'platform' => 'whatsapp',
            'payment_status' => PaymentStatus::UNPAID,
        ]);

        Order::create([
            'location' => new Point('23.675971', '54.083211'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $amjad->id,
            'association_id' => 3,
            'weight' => 22,
            'value' => 20,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-07-10 08:00:00',
            'platform' => 'whatsapp',
            'payment_status' => PaymentStatus::UNPAID,
        ]);

        Order::create([
            'location' => new Point('23.675971', '54.083211'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $amjad->id,
            'association_id' => 3,
            'weight' => 22,
            'value' => 20,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-07-10 08:00:00',
            'platform' => 'whatsapp',
            'payment_status' => PaymentStatus::UNPAID,
        ]);

        Order::create([
            'location' => new Point('23.675971', '54.083211'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $amjad->id,
            'association_id' => 3,
            'weight' => 22,
            'value' => 20,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-07-10 08:00:00',
            'platform' => 'whatsapp',
            'payment_status' => PaymentStatus::UNPAID,
        ]);

        Order::create([
            'location' => new Point('23.675971', '54.083211'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => 3,
            'weight' => 22,
            'value' => 20,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-07-10 08:00:00',
            'platform' => 'whatsapp',
            'payment_status' => PaymentStatus::UNPAID,
        ]);

        Order::create([
            'location' => new Point('23.675971', '54.083211'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => 3,
            'weight' => 22,
            'value' => 20,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-07-10 08:00:00',
            'platform' => 'whatsapp',
            'payment_status' => PaymentStatus::UNPAID,
        ]);

        Order::create([
            'location' => new Point('23.675971', '54.083211'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $amjad->id,
            'association_id' => 3,
            'weight' => 22,
            'value' => 20,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-07-10 08:00:00',
            'platform' => 'whatsapp',
            'payment_status' => PaymentStatus::UNPAID,
        ]);

        Order::create([
            'location' => new Point('23.675971', '54.083211'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => 3,
            'weight' => 22,
            'value' => 20,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-07-10 08:00:00',
            'platform' => 'whatsapp',
            'payment_status' => PaymentStatus::UNPAID,
        ]);


        Order::create([
            'location' => new Point('23.675971', '54.083211'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => 3,
            'weight' => 22,
            'value' => 20,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-07-10 08:00:00',
            'platform' => 'whatsapp',
            'payment_status' => PaymentStatus::UNPAID,
        ]);
        Order::create([
            'location' => new Point('23.675971', '54.083211'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $user->id,
            'association_id' => 3,
            'weight' => 22,
            'value' => 20,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-07-10 08:00:00',
            'platform' => 'whatsapp',
            'payment_status' => PaymentStatus::UNPAID,
        ]); Order::create([
        'location' => new Point('23.675971', '54.083211'),
        'country_id' => $country->id,
        'address_id' => $address->id,
        'customer_id' => $user->id,
        'association_id' => 3,
        'weight' => 22,
        'value' => 20,
        'agent_id' => $agent->id,
        'status' => OrderStatus::SUCCESSFUL,
        'start_at' => '2022-07-10 08:00:00',
        'platform' => 'whatsapp',
        'payment_status' => PaymentStatus::UNPAID,
    ]); Order::create([
        'location' => new Point('23.675971', '54.083211'),
        'country_id' => $country->id,
        'address_id' => $address->id,
        'customer_id' => $user->id,
        'association_id' => 3,
        'weight' => 22,
        'value' => 20,
        'agent_id' => $agent->id,
        'status' => OrderStatus::SUCCESSFUL,
        'start_at' => '2022-07-10 08:00:00',
        'platform' => 'whatsapp',
        'payment_status' => PaymentStatus::UNPAID,
    ]); Order::create([
        'location' => new Point('23.675971', '54.083211'),
        'country_id' => $country->id,
        'address_id' => $address->id,
        'customer_id' => $user->id,
        'association_id' => 3,
        'weight' => 22,
        'value' => 20,
        'agent_id' => $agent->id,
        'status' => OrderStatus::SUCCESSFUL,
        'start_at' => '2022-07-10 08:00:00',
        'platform' => 'whatsapp',
        'payment_status' => PaymentStatus::UNPAID,
    ]); Order::create([
        'location' => new Point('23.675971', '54.083211'),
        'country_id' => $country->id,
        'address_id' => $address->id,
        'customer_id' => $user->id,
        'association_id' => 3,
        'weight' => 22,
        'value' => 20,
        'agent_id' => $agent->id,
        'status' => OrderStatus::SUCCESSFUL,
        'start_at' => '2022-07-10 08:00:00',
        'platform' => 'whatsapp',
        'payment_status' => PaymentStatus::UNPAID,
    ]);

        Order::create([
            'location' => new Point('23.675971', '54.083211'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $amjad->id,
            'association_id' => 3,
            'weight' => 10,
            'value' => 20,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-07-10 08:00:00',
            'platform' => 'whatsapp',
            'payment_status' => PaymentStatus::UNPAID,
        ]);


        Order::create([
            'location' => new Point('23.675971', '54.083211'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $amjad->id,
            'association_id' => 3,
            'weight' => 10,
            'value' => 20,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-07-10 08:00:00',
            'platform' => 'whatsapp',
            'payment_status' => PaymentStatus::UNPAID,
        ]);



        Order::create([
            'location' => new Point('23.675971', '54.083211'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $amjad->id,
            'association_id' => 3,
            'weight' => 10,
            'value' => 20,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-07-10 08:00:00',
            'platform' => 'whatsapp',
            'payment_status' => PaymentStatus::UNPAID,
        ]);


        Order::create([
            'location' => new Point('23.675971', '54.083211'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $amjad->id,
            'association_id' => 3,
            'weight' => 10,
            'value' => 20,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-07-10 08:00:00',
            'platform' => 'whatsapp',
            'payment_status' => PaymentStatus::UNPAID,
        ]);


        Order::create([
            'location' => new Point('23.675971', '54.083211'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $amjad->id,
            'association_id' => 3,
            'weight' => 10,
            'value' => 20,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-07-10 08:00:00',
            'platform' => 'whatsapp',
            'payment_status' => PaymentStatus::UNPAID,
        ]);


        Order::create([
            'location' => new Point('23.675971', '54.083211'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $amjad->id,
            'association_id' => 3,
            'weight' => 10,
            'value' => 20,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-07-10 08:00:00',
            'platform' => 'whatsapp',
            'payment_status' => PaymentStatus::UNPAID,
        ]);
        Order::create([
            'location' => new Point('23.675971', '54.083211'),
            'country_id' => $country->id,
            'address_id' => $address->id,
            'customer_id' => $amjad->id,
            'association_id' => 3,
            'weight' => 10,
            'value' => 20,
            'agent_id' => $agent->id,
            'status' => OrderStatus::SUCCESSFUL,
            'start_at' => '2022-07-10 08:00:00',
            'platform' => 'whatsapp',
            'payment_status' => PaymentStatus::UNPAID,
        ]); Order::create([
        'location' => new Point('23.675971', '54.083211'),
        'country_id' => $country->id,
        'address_id' => $address->id,
        'customer_id' => $user->id,
        'association_id' => 3,
        'weight' => 10,
        'value' => 20,
        'agent_id' => $agent->id,
        'status' => OrderStatus::SUCCESSFUL,
        'start_at' => '2022-07-10 08:00:00',
        'platform' => 'whatsapp',
        'payment_status' => PaymentStatus::UNPAID,
    ]); Order::create([
        'location' => new Point('23.675971', '54.083211'),
        'country_id' => $country->id,
        'address_id' => $address->id,
        'customer_id' => $user->id,
        'association_id' => 3,
        'weight' => 10,
        'value' => 20,
        'agent_id' => $agent->id,
        'status' => OrderStatus::SUCCESSFUL,
        'start_at' => '2022-07-10 08:00:00',
        'platform' => 'whatsapp',
        'payment_status' => PaymentStatus::UNPAID,
    ]); Order::create([
        'location' => new Point('23.675971', '54.083211'),
        'country_id' => $country->id,
        'address_id' => $address->id,
        'customer_id' => $user->id,
        'association_id' => 3,
        'weight' => 10,
        'value' => 20,
        'agent_id' => $agent->id,
        'status' => OrderStatus::SUCCESSFUL,
        'start_at' => '2022-07-10 08:00:00',
        'platform' => 'whatsapp',
        'payment_status' => PaymentStatus::UNPAID,
    ]); Order::create([
        'location' => new Point('23.675971', '54.083211'),
        'country_id' => $country->id,
        'address_id' => $address->id,
        'customer_id' => $user->id,
        'association_id' => 3,
        'weight' => 10,
        'value' => 20,
        'agent_id' => $agent->id,
        'status' => OrderStatus::SUCCESSFUL,
        'start_at' => '2022-07-10 08:00:00',
        'platform' => 'whatsapp',
        'payment_status' => PaymentStatus::UNPAID,
    ]);



    }
}
