@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/video-banner.css') }}">


    @if(App::getLocale() == 'ar')
        <style>
            .first-section-in-home-video-section .mask {
                rotate: 0deg !important;
            }

        </style>
    @endif

@endPushOnce
<section class="first-section-in-home-video-section w-100">
    <div class="swiper mySwiper-in-first-section-in-home-slider-section h-100">
        <div class="swiper-wrapper h-100">
            <div class="swiper-slide  h-100 slide-1">
                <video
                    src="{{$section['video']['link']}}"
                    muted
                    autoplay
                    loop
                    id="video"
                    class="w-100 h-100 position-absolute fit-cover start-0 top-0"
                    playsinline>
                </video>
                <div class="mask"></div>
                <div class="container z-index-99 position-relative">
                    <div class="row">
                        <div class="col-12 col-lg-6 d-flex flex-column align-items-start text-white">
                            <h1 data-aos="fade-up" data-deuration="300" data-swiper-parallax="-300" class="title">
                                {!!$section['title']??""!!}
                            </h1>
                            <div class="font-bold fs-3 " data-aos="fade-right" data-deuration="300"
                                 data-swiper-parallax="-400">{!! $section['description'] ??""!!}</div>
                            <p class="fs-6" data-aos="fade-right" data-deuration="300" data-swiper-parallax="-500">{!!$section['sub_title']??""!!}</p>
                            <a href="{{$section['button']['link']}}"
                               class="cat-Button d-flex align-items-center justify-content-center py-2  text-decoration-none text-white"
                               data-aos="fade-right" data-deuration="300" data-swiper-parallax="-600">
                                {{$section['button']['title']}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container position-relative bottom-15">
            <div class="row row-pagination  z-index-99">
                <div class="box-pagination mt-2 mt-md-4 col-12 d-flex align-items-center justify-content-start me-4">
                </div>
            </div>
        </div>
    </div>
</section>
@pushOnce('scripts')

@endPushOnce
