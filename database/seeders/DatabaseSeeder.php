<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(TeamTableSeeder::class);
        $this->call(ProvinceTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(AssociationTableSeeder::class);
        $this->call(MessageTableSeeder::class);
        $this->call(ExpensesTableSeeder::class);
        $this->call(ItemTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(ContainerTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(UserAccessTableSeeder::class);
        $this->call(HomePageSeeder::class);
        $this->call(GalleryPageSeeder::class);
        $this->call(LocationsSettingsSeeder::class);
        $this->call(PartnersTableSeeder::class);
        $this->call(OffersTableSeeder::class);
        $this->call(OffersPageSeeder::class);
        $this->call(NewsTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(EventsPageSeeder::class);
        $this->call(OurPartnersPageSeeder::class);
        $this->call(PointsTableSeeder::class);
        $this->call(ContactUsPageSeeder::class);
        $this->call(CreateOrderPageSeeder::class);
        $this->call(TargetTableSeeder::class);
        $this->call(BlogTableSeeder::class);
    }
}
