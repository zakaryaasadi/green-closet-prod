@php
    use App\Helpers\AppHelper;
@endphp
@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/slider-section-in-home-page.css') }}">


    @if(App::getLocale() == 'ar')
        <link rel="stylesheet" href="{{ mix('css/components/slider-section-in-home-page-ar.css') }}">
    @endif
@endPushOnce
<section class="first-section-in-home-slider-section w-100 ">
    <div class="swiper mySwiper-in-first-section-in-home-slider-section h-100">
        <div class="swiper-wrapper h-100">
            @foreach($section['sliders'] as $key => $slider)
                <div class="swiper-slide  h-100 "
                     style=" background-image: url('{{$slider["image"]??url('/images/placeholder.png')}}');">
                    <div class="mask"></div>
                    <div class="container z-index-99 position-relative">
                        <div class="row  ">
                            <div class="col-12 col-lg-6 d-flex flex-column align-items-start text-white content">
                                <h1 data-aos="fade-up" data-deuration="300" data-swiper-parallax="-300" class="title">
                                    {!!$slider['title']??""!!}
                                </h1>
                                <p class="font-bold fs-5 " data-aos="fade-right" data-deuration="300"
                                   data-swiper-parallax="-400">{{$slider['sub_title']}}</p>
                                <div class="fs-6" data-aos="fade-right" data-deuration="300"
                                     data-swiper-parallax="-500">{!! $slider['description']??"" !!}
                                </div>
                                @if(isset($slider['button']))
                                    <a href="{{$slider['button']['target'] == '_blank' ? $slider['button']['link'] :"/".AppHelper::getSlug().$slider['button']['link']}}"
                                       class="cat-Button d-flex align-items-center justify-content-center py-2  text-decoration-none text-white"
                                       data-aos="fade-right"
                                       data-deuration="300"
                                       data-swiper-parallax="-600">
                                        {{$slider['button']['title']}}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="container position-relative bottom-15">
            <div class="row row-pagination  z-index-99">
                <div class="box-pagination col-12 d-flex align-items-center justify-content-start mx-4">
                    <div class="swiper-button-prev d-flex align-items-center">
                        <svg width="21" height="15" viewBox="0 0 21 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M1.10671 7.10936C0.734018 7.48205 0.734018 8.08631 1.10671 8.459L7.18006 14.5323C7.55275 14.905 8.157 14.905 8.52969 14.5323C8.90239 14.1597 8.90239 13.5554 8.52969 13.1827L3.13116 7.78418L8.52969 2.38565C8.90239 2.01295 8.90239 1.4087 8.52969 1.03601C8.157 0.663321 7.55275 0.663321 7.18006 1.03601L1.10671 7.10936ZM20.6792 6.82984L1.78153 6.82984V8.73851L20.6792 8.73851V6.82984Z"
                                fill="white"/>
                        </svg>
                    </div>
                    <div class="swiper-pagination h-100 d-flex align-items-center px-2 top-0 text-white number"></div>
                    <div class="swiper-button-next d-flex align-items-center">
                        <svg width="20" height="15" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.6122 8.45899C19.9848 8.0863 19.9848 7.48205 19.6122 7.10936L13.5388 1.03601C13.1661 0.663319 12.5619 0.663319 12.1892 1.03601C11.8165 1.4087 11.8165 2.01295 12.1892 2.38564L17.5877 7.78418L12.1892 13.1827C11.8165 13.5554 11.8165 14.1597 12.1892 14.5323C12.5619 14.905 13.1661 14.905 13.5388 14.5323L19.6122 8.45899ZM0.041504 8.73851L18.9373 8.73851L18.9373 6.82984L0.0415038 6.82984L0.041504 8.73851Z"
                                fill="white"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@pushOnce('scripts')
    <script src="{{ mix('js/components/slider-section-in-home-page.js') }}"></script>
    <script>
        var swiper = new Swiper(".mySwiper-in-first-section-in-home-slider-section", {
            pagination: {
                el: ".swiper-pagination",
                type: "fraction",
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            effect: "fade",
            speed: 800,
            parallax: true,
            autoplay: {
                delay: 4500,
                disableOnInteraction: false,
            },
            loop: false,
        });
    </script>
@endPushOnce
