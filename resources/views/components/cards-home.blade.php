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
@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/card-home.css') }}">
    @if(App::getLocale() == 'ar')

    @endif
@endPushOnce
<section class="main-landing-page position-relative pt-5">
    <div class="wrapper-dot position-absolute top-0 w-100 h-100  container">
        <div><span class="dot"></span></div>
        <div><span class="dot"></span></div>
        <div><span class="dot"></span></div>
        <div><span class="dot"></span></div>
        <div><span class="dot"></span></div>
        <div><span class="dot"></span></div>
    </div>
    <div class="container h-50">
        <div class="row h-100">
            <div class="col-12 h-100 d-flex align-items-center justify-content-center flex-column py-5 py-md-1">
                <h1 data-aos="fade-up" data-deuration="300" class="mb-5 text-center">{!!$section["title"]??""!!}</h1>
                <p data-aos="fade-up" data-deuration="500" class="fw-bold fs-5 text-center">
                    {!!$section["sub_title"]??""!!}
                </p>
                <div data-aos="fade-up" data-deuration="700" class="fs-6 text-center">
                    {!! $section['description'] !!}
                </div>
                @if(isset($section['button']))
                    <div class="col-12 d-flex align-item-center justify-content-center">
                        @foreach($section['button'] as $button)
                            <a data-aos="fade-up" data-deuration="900"
                               href="{{$button['target'] === '_blank' ?$button['link']:AppHelper::getSlug().$button['link']}}"
                               target="{{$button['target']}}"
                               class="text-white py-3 px-2 text-decoration-none cat-Button text-center mx-1 ">{{$button['title']}}</a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="h-50  image-circle position-relative overflow-hidden">
        <div class="mask position-absolute start-0 top-0  w-100 h-100"></div>
        <img loading="lazy" data-src="{{$section['image']??url('/images/placeholder.png')}}"
             alt="{{$section['alt']??''}}"
             class="img-fluid h-100 w-100">
    </div>
    <div class="cards-group overflow-hidden">
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
                                 data-aos="zoom-in"
                            >
                            <p class="fs-5"
                               data-aos="fade-up"
                            >{{$card['title']}}</p>
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
</section>
@pushOnce('scripts')
    <script>
        let maskImage = document.querySelector(".image-circle .mask")
        if (window.innerWidth > 1024) {
            maskImage.style = `border-radius: ${1000 - (window.scrollY * 2)}px ${1000 - (window.scrollY * 2)}px 0px 0px !important;`
            document.addEventListener("scroll", e => {
                maskImage.style = `border-radius: ${1000 - (window.scrollY * 2)}px ${1000 - (window.scrollY * 2)}px 0px 0px !important;`
            })
        }
    </script>
@endPushOnce








