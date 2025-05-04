@php
    use App\Enums\CardType;use App\Helpers\AppHelper;use Illuminate\Database\Eloquent\Builder;
    $country_id = AppHelper::getLocationSettings()->country_id;
    $associationsCount = \App\Models\Association::whereCountryId($country_id)->get()->count();
    $donationsCount = \App\Models\Order::where(['type' => \App\Enums\OrderType::DONATION, 'country_id' => $country_id])->get()->count();
    $orderDonationItems = \App\Models\ItemOrders::whereHas('order', function (Builder $query) {
                    $query->where(['country_id' => AppHelper::getLocationSettings()->country_id, 'type' => \App\Enums\OrderType::DONATION]);
    })->get()->count();
    $orderResyclingItems = \App\Models\ItemOrders::whereHas('order', function (Builder $query) {
                    $query->where(['country_id' => AppHelper::getLocationSettings()->country_id, 'type' => \App\Enums\OrderType::RECYCLING]);
    })->get()->count();
    $resyclingCount = \App\Models\Order::where(['type' => \App\Enums\OrderType::RECYCLING, 'country_id' => $country_id])->get()->count();
    $partnersCount = \App\Models\Partner::whereCountryId($country_id)->get()->count();
    $counter = 0;
@endphp
<link rel="stylesheet" href="{{ mix('css/components/cards-component.css') }}">

<div class="cards-group overflow-hidden my-2">
    <div class="container">
        <div class="row">
            @foreach($section['cards'] as $card)
                <div class="col-12 col-md-6 col-lg-3 card-box px-0 px-md-4 mt-3">
                    <div
                        class="p-3 rounded d-flex flex-column align-items-center justify-content-center"
                        data-aos="zoom-out"
                        style="background-color:{{$card['BGColor']}}"
                    >
                        <img loading="lazy" data-src="{{$card['image']??url('/images/placeholder.png')}}"
                             alt="{{$card['alt']??''}}"
                             class="img-fluid"
                             data-aos="zoom-in">
                        <p class="fs-5"
                           data-aos="fade-up">
                            {{$card['title']}}
                        </p>

                        @switch($card['type'])
                            @case(CardType::ASSOCIATION)
                                <h3 data-aos="fade-down" class="number">{{$associationsCount}}</h3>
                                @break
                            @case(CardType::PARTNER)

                                <h3 data-aos="fade-down" class="number">{{$partnersCount}}</h3>
                                @break
                            @case(CardType::DONATIONS)
                                <h3 data-aos="fade-down" class="number">{{$donationsCount}}</h3>
                                @break
                            @case(CardType::RYCICLING)
                                <h3 data-aos="fade-down" class="number">{{$resyclingCount}}</h3>
                                @break
                            @case(CardType::RYCICLING_ITEMS)
                                <h3 data-aos="fade-down" class="number">{{$orderResyclingItems}}</h3>
                                @break
                            @case(CardType::DONATIONS_ITEMS)
                                <h3 data-aos="fade-down" class="number">{{$orderDonationItems}}</h3>
                                @break
                            @case(CardType::OTHERS)
                                <h3 data-aos="fade-down" class="number">{{$card["valueType"]}}</h3>
                                @break
                        @endswitch
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
