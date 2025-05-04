<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\Analytics;
use App\Models\Association;
use App\Models\Blog;
use App\Models\Container;
use App\Models\Country;
use App\Models\District;
use App\Models\Event;
use App\Models\IP;
use App\Models\Item;
use App\Models\Language;
use App\Models\LocationSettings;
use App\Models\MediaModel;
use App\Models\Neighborhood;
use App\Models\News;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Province;
use App\Models\Section;
use App\Models\Setting;
use App\Models\Street;
use App\Models\Target;
use App\Models\Team;
use App\Models\User;
use App\Models\UserAccess;
use App\Policies\AddressPolicy;
use App\Policies\AnalyticsPolicy;
use App\Policies\AssociationPolicy;
use App\Policies\BlogPolicy;
use App\Policies\ContainerPolicy;
use App\Policies\CountryPolicy;
use App\Policies\DistrictPolicy;
use App\Policies\EventPolicy;
use App\Policies\IpPolicy;
use App\Policies\ItemPolicy;
use App\Policies\LanguagePolicy;
use App\Policies\LocationSettingsPolicy;
use App\Policies\MediaModelPolicy;
use App\Policies\NeighborhoodPolicy;
use App\Policies\NewsPolicy;
use App\Policies\OfferPolicy;
use App\Policies\OrderPolicy;
use App\Policies\PagePolicy;
use App\Policies\PartnerPolicy;
use App\Policies\ProvincePolicy;
use App\Policies\SectionPolicy;
use App\Policies\SettingPolicy;
use App\Policies\StreetPolicy;
use App\Policies\TargetPolicy;
use App\Policies\TeamPolicy;
use App\Policies\UserAccessPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Page::class => PagePolicy::class,
        Container::class => ContainerPolicy::class,
        Blog::class => BlogPolicy::class,
        Address::class => AddressPolicy::class,
        Association::class => AssociationPolicy::class,
        Language::class => LanguagePolicy::class,
        News::class => NewsPolicy::class,
        Offer::class => OfferPolicy::class,
        Partner::class => PartnerPolicy::class,
        Section::class => SectionPolicy::class,
        Team::class => TeamPolicy::class,
        Setting::class => SettingPolicy::class,
        Country::class => CountryPolicy::class,
        Event::class => EventPolicy::class,
        Order::class => OrderPolicy::class,
        LocationSettings::class => LocationSettingsPolicy::class,
        MediaModel::class => MediaModelPolicy::class,
        UserAccess::class => UserAccessPolicy::class,
        User::class => UserPolicy::class,
        Province::class => ProvincePolicy::class,
        District::class => DistrictPolicy::class,
        Neighborhood::class => NeighborhoodPolicy::class,
        Street::class => StreetPolicy::class,
        Item::class => ItemPolicy::class,
        Analytics::class => AnalyticsPolicy::class,
        Target::class => TargetPolicy::class,
        IP::class => IpPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
