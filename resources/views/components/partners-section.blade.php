@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/our-partners-home.css') }}">
@endPushOnce
@php
    use App\Enums\CardType;use App\Helpers\AppHelper;
    $country_id = AppHelper::getLocationSettings()->country_id;
    $associationsCount = \App\Models\Association::whereCountryId($country_id)->get()->count();
    $partnersCount = \App\Models\Partner::whereCountryId($country_id)->get()->count();
    $counter = 0;
    $donationsCount = \App\Models\Order::where(['type' => \App\Enums\OrderType::DONATION, 'country_id' => $country_id])->get()->count();
    $orderDonationItems = \App\Models\ItemOrders::whereHas('order', function ($query) {
                    $query->where(['country_id' => AppHelper::getLocationSettings()->country_id, 'type' => \App\Enums\OrderType::DONATION]);
    })->get()->count();
    $orderRecyclingItems = \App\Models\ItemOrders::whereHas('order', function ($query) {
                    $query->where(['country_id' => AppHelper::getLocationSettings()->country_id, 'type' => \App\Enums\OrderType::RECYCLING]);
    })->get()->count();
    $recyclingCount = \App\Models\Order::where(['type' => \App\Enums\OrderType::RECYCLING, 'country_id' => $country_id])->get()->count();
    $partnersCount = \App\Models\Partner::whereCountryId($country_id)->get()->count();
@endphp

<section class="our-partners-home position-relative d-flex  align-items-center py-5 justify-content-center"
         style="
             background: linear-gradient(
             to bottom,
             #f9fdff45,
             #f9fdffd9
             )
             ">
    <div
            class="container overflow-hidden  d-flex align-items-center justify-content-center position-relative main-container flex-column">
        <div class="row">
            <div class="col-12 align-items-center justify-content-center">
                <h1 class="" data-aos="fade-up"> {!!$section['title']??""!!}</h1>
            </div>
        </div>
        <div class="row mt-2 mt-md-5 d-flex align-items-center justify-content-center w-100">
            @foreach($section['cards'] as $card)
                <div class="col-12 col-md-6 col-lg-4 d-flex align-items-center justify-content-center">
                    <div
                            class="main-box-card m-0 m-md-3 d-flex rounded w-100 d-flex align-items-center justify-content-center"
                            data-aos="zoom-out" style="background-color: {{$card['BGColor']}}">
                        <img loading="lazy" data-src="{{$card['image']??url('/images/placeholder.png')}}"
                             alt="{{$card['alt'] ?? ''}}"
                             data-aos="zoom-in" class="px-2" width="50px" height="50px">
                        <div class="description d-flex flex-column flex-fill ">
                            @switch($card['type'])
                                @case(CardType::ASSOCIATION)
                                    <h3 data-aos="fade-up" class="number count" data-target="{{$associationsCount}}">
                                        0</h3>
                                    @break
                                @case(CardType::PARTNER)
                                    <h3 data-aos="fade-up" class="number count" data-target="{{$partnersCount}}">0</h3>
                                    @break

                                @case(CardType::DONATIONS)
                                    <h3 data-aos="fade-up" class="number count" data-target="{{$donationsCount}}">0</h3>
                                    @break

                                @case(CardType::RYCICLING)
                                    <h3 data-aos="fade-up" class="number count" data-target="{{$recyclingCount}}">0</h3>
                                    @break

                                @case(CardType::DONATIONS_ITEMS)
                                    <h3 data-aos="fade-up" class="number count" data-target="{{$orderDonationItems}}">
                                        0</h3>
                                    @break
                                @case(CardType::RYCICLING_ITEMS)
                                    <h3 data-aos="fade-up" class="number count" data-target="{{$orderRecyclingItems}}">
                                        0</h3>
                                    @break

                            @endswitch
                            <div data-aos="fade-down">{!! $card['description'] !!} </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
        <div class="row w-100 my-5">
            <div class="swiper mySwiper-our-partners-home">
                <div class="swiper-wrapper">
                    @foreach($partners as $partner )
                        @if($loop->index %2 == 0)
                            <div class="swiper-slide d-flex justify-content-center rounded bg-white p-2 rounded">
                                <a href="{{$partner['link']}}" target="_blank">
                                    <img loading="lazy" data-src="{{$partner['image']??url('/images/placeholder.png')}}"
                                         alt="{{$partner['alt']??''}}" class="w-100 img-fluid"/>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="swiper mt-4 mySwiper-our-partners-home mySwiper-our-partners-home-reverseDirection">
                <div class="swiper-wrapper">
                    @foreach($partners as $partner )
                        @if($loop->index %2 != 0)
                            <div class="swiper-slide d-flex justify-content-center rounded bg-white p-2 rounded">
                                <a href="{{$partner['link']}}" target="_blank">
                                    <img loading="lazy"
                                         data-src=" {{$partner['image']??url('/images/placeholder.png')}}" alt=""
                                         class="w-100 img-fluid"/>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-12 justify-content-center d-flex mt-5">
                <a href="/{{AppHelper::getSlug()}}{{$section['button']['link']}}" class="text-decoration-none">
                    <button class="btn btn-outline-primary py-3" data-aos="fade-up">
                        {{$section['button']['title']}}
                    </button>
                </a>

            </div>
        </div>
    </div>


</section>

@pushOnce('scripts')
    <script>
        var mySwiperOurPartnersHome = new Swiper(".mySwiper-our-partners-home", {
            speed: 5000,
            slidesPerView: 1,
            spaceBetween: 10,
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 40,
                },
                1024: {
                    slidesPerView: 3.5,
                    spaceBetween: 50,
                },
            },


            loop: true,
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
            },
        });
        var mySwiperOurPartnersHomeReverseDirection = new Swiper(".mySwiper-our-partners-home-reverseDirection", {
            speed: 5000,
            reverseDirection: false,
            slidesPerView: 1,
            spaceBetween: 10,
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 40,
                },
                1024: {
                    slidesPerView: 3.5,
                    spaceBetween: 50,
                },
            },
            loop: true,
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
                reverseDirection: true,
            },

        });
    </script>
    <script src="{{mix('js/components/partners-section.js')}}"></script>
@endPushOnce

