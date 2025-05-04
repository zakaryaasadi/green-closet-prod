@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/offers-section.css') }}">
    <style>
        .offers-section * {
        }
    </style>
@endPushOnce

@php
    use App\Helpers\AppHelper;use App\Models\Setting;
    $currency_ar  = Setting::whereCountryId(AppHelper::getLocationSettings()->country_id)->first()?->currency_ar ??
                    Setting::whereCountryId(['country_id' => null])->first()?->currency_ar;
    $currency_en  = Setting::whereCountryId(AppHelper::getLocationSettings()->country_id)->first()?->currency_en ??
                    Setting::whereCountryId(['country_id' => null])->first()?->currency_en;
@endphp


<section class="offers-section d-flex align-items-center justify-content-center   ">
    <div class="w-100">
        <div class="container">
            <div class="row">
                <div class="col-12 py-3 text-center">
                    <h1> {!!$section->structure["title"]??""!!}</h1>
                    <div>{!! $section->structure["description"] !!}</div>
                </div>
            </div>
        </div>
        <div class="swiper mySwiper-offers-section-{{$section->sort}} ">
            <div
                class="swiper-wrapper d-flex align-items-center h-fit {{count($offers) < 5 ? 'justify-content-center d-flex' : ''}}"
            >

                @if(count($offers) >= 5)
                    @foreach($offers as $offer)
                        <div class="swiper-slide d-flex align-items-end justify-content-start position-relative"
                        >
                            <div class="box-image position-absolute w-100 h-100 start-0 top-0  "
                                 style="z-index: -1">
                                <img loading="lazy" data-src="{{$offer["image"]??url('/images/placeholder.png')}}"
                                     alt="{{$offer["alt"]??''}}" class="w-100 h-100 img-fluid"
                                     style="object-fit:cover"
                                >
                                <span class="bg-white position-absolute d-flex ">
                                <div class="line position-absolute d-flex">
                                <svg class="svg-1" width="100" height="4" viewBox="0 0 100 4" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.9458 2.44434L97.5942 2.44414" stroke="#00A3ED" stroke-width="3"
                                          stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="15 15"/>
                                </svg>
                            </div>
                            </span>

                            </div>
                            <div class="content-offer w-100  text-white position-relative px-2 px-md-3">
                                <h3 class=" text-center ">{{$offer['name']}}</h3>

                                @switch($offer['type'])

                                    @case(\App\Enums\OfferType::PERCENT)
                                        <h2 class="number text-center  "> {{$offer["value"]}}
                                            %</h2>
                                        @break

                                    @case(\App\Enums\OfferType::FIXED)
                                        @if(AppHelper::getLocationSettings()->language->code == 'ar')
                                            <h2 class="number text-center">
                                                {{$offer["value"]}} {{$currency_ar}}
                                            </h2>
                                        @else
                                            <h2 class="number text-center  ">
                                                {{$offer["value"]}} {{$currency_en}}</h2>
                                        @endif

                                        @break

                                @endswitch

                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="row justify-content-center gap-3">
                        @foreach($offers as $offer)
                            <div
                                class="col-12 col-md-6 col-lg-4 col-xl-3 d-flex align-items-end justify-content-start position-relative   "
                            >
                                <div class="box-image position-absolute w-100 h-100 start-0 top-0  "
                                     style="z-index: -1">
                                    <img loading="lazy" data-src="{{$offer["image"]??url('/images/placeholder.png')}}"
                                         alt="{{$offer["alt"]??''}}" class="w-100 h-100 img-fluid"
                                         style="object-fit:cover"
                                    >
                                    <span class="bg-white position-absolute d-flex ">
                                <div class="line position-absolute d-flex">
                                <svg class="svg-1" width="100" height="4" viewBox="0 0 100 4" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.9458 2.44434L97.5942 2.44414" stroke="#00A3ED" stroke-width="3"
                                          stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="15 15"/>
                                </svg>
                            </div>
                            </span>

                                </div>
                                <div class="content w-100  text-white position-relative px-2 px-md-3">
                                    <h3 class=" text-center ">{{$offer['name']}}</h3>
                                    <h2 class="number text-center  ">%{{$offer["value"]}}</h2>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
        <div class="container mt-5">
            <div class="row">

                @if(isset($section->structure['button']))
                    <div class="col-12 text-center">
                        <a href="/{{AppHelper::getSlug()}}{{$section->structure['button']['link']}}"
                           target="{{$section->structure['button']['target']}}" class="text-decoration-none">
                            <button class="btn  btn-outline-primary">
                                {{$section->structure['button']['title']}}
                            </button>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@pushOnce('scripts')
    <script>
        var mySwiperOffersSection{{$section->sort}} = new Swiper(".mySwiper-offers-section-{{$section->sort}}", {

            slidesPerView: 1,
            spaceBetween: 5,
            breakpoints: {
                425: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                820: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                991: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1200: {
                    slidesPerView: 4.5,
                    spaceBetween: 40,
                },
            },
            observer: true,
            observeParents: true,
            allowSlidePrev: true,
            allowSlideNext: true,
            loop: false,
            allowTouchMove: true,
            freeMode: true,
        });


    </script>
@endPushOnce
