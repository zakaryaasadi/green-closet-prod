@extends('layout')

@section('style')

    <link rel="stylesheet" href="{{mix('css/components/news-details.css')}}">
    <link rel="stylesheet" href="https://rawgit.com/LeshikJanz/libraries/master/Bootstrap/baguetteBox.min.css">
    @if(App::getLocale() == 'en')
        <style>
            #news-details-page .swiper .swiper-slide:hover img {
                transform-origin: right;
            }

            #news-details-page .swiper-button-next svg,
            #news-details-page .swiper-button-prev svg {
                transform: rotate(180deg);
            }
        </style>
    @endif
@endsection
@php
    use App\Helpers\AppHelper;use App\Models\Setting;
    $metaDescription = '';
    $locationSetting = AppHelper::getLocationSettings();
    $settings=Setting::where(['country_id' => $locationSetting->country_id])->first()??Setting::where(['country_id' => null])->first();
    if ($locationSetting->language->code == 'ar')
        $title = $settings?->header_title_arabic;
    else
        $title = $settings?->header_title;
    if ($meta_tags != ' ') {
        if (array_key_exists('seo_title', $meta_tags))
                $title = $title . ' - ' . $meta_tags['seo_title'];
        if (array_key_exists('meta_description', $meta_tags))
                $metaDescription = $meta_tags['meta_description'];
    }
@endphp
@section('seo_title', $title)
@section('meta_description', $metaDescription)

@section('content')
    <main id="news-details-page">
        <section class="image-section"
                 style='background-image: url("{{$blogDetails['image']??url('/images/placeholder.png')}}")'></section>
        <div class="container py-5">
            <div class="row py-5">
                <div class="col-12"><h1>{{$blogDetails['title']}}</h1></div>
                <div class="col-12">
                    <div>{!!$blogDetails['description']!!}</div>
                </div>
            </div>

            <div class="w-100">
                {{--                <div class=" gallery-container">--}}
                {{--                    <div class="tz-gallery">--}}
                {{--                        <div class="row">--}}
                {{--                            @foreach($newsDetails["images"]  as $image )--}}
                {{--                                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mt-3 p-2 d-flex flex-column flex-lg-row">--}}
                {{--                                    <a class="lightbox w-100" href="{{$image??url('/images/placeholder.png')}}">--}}
                {{--                                        <img loading="lazy"--}}
                {{--                                             data-src="{{$image??url('/images/placeholder.png')}}"--}}
                {{--                                             alt="" class="w-100"/>--}}
                {{--                                    </a>--}}
                {{--                                </div>--}}
                {{--                            @endforeach--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>


            <div class="d-flex align-items-center">
                <div class="swiper-button-next mt-0 mx-2 end-0 position-relative justify-content-center">
                    <svg width="65" height="64" viewBox="0 0 65 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M64.0684 0H0.0683594V64H64.0684V0ZM15.6043 19.911L27.6929 31.9999L15.6043 44.0885L26.0239 54.5081L48.532 32L26.024 9.49146L15.6043 19.911Z"
                              fill="#008451"/>
                    </svg>
                </div>
                <div class="swiper mySwiper-in-news-details-page h-fit py-5">
                    <div class="swiper-wrapper">
                        @foreach($allBlogs  as $blog)
                            <div class="swiper-slide d-flex flex-column flex-lg-row">
                                <a href="/{{AppHelper::getSlug()}}/blogs/{{$blog['slug']}}"
                                   class="text-dark text-decoration-none">
                                    <div class="row">
                                        <img loading="lazy"
                                             data-src="{{$blog['image']??url('/images/placeholder.png')}}"
                                             alt="{{$blog['alt']??''}}"
                                             class="col-12 col-md-6 ">
                                        <p class="col-12 col-md-6 d-flex {{App::getLocale() == 'ar' ? 'text-end ' : ' text-start'}}">
                                            {{$blog["title"]}}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-button-prev mt-0 mx-2 start-0 position-relative">
                    <svg width="65" height="64" viewBox="0 0 65 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M0.0683594 0H64.0684V64H0.0683594V0ZM48.5325 19.911L36.4438 31.9999L48.5324 44.0885L38.1128 54.5081L15.6047 32L38.1128 9.49146L48.5325 19.911Z"
                              fill="#008451"/>
                    </svg>
                </div>
            </div>
        </div>
    </main>

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js"
            integrity="sha512-7KzSt4AJ9bLchXCRllnyYUDjfhO2IFEWSa+a5/3kPGQbr+swRTorHQfyADAhSlVHCs1bpFdB1447ZRzFyiiXsg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        baguetteBox.run('.tz-gallery', {
            animation: 'fadeIn',
            noScrollbars: true
        });
    </script>




    <script>
        var swiper = new Swiper(".mySwiper-in-news-details-page", {
            slidesPerView: 1,
            spaceBetween: 10,
            navigation: {
                prevEl: ".swiper-button-next",
                nextEl: ".swiper-button-prev",
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                },
                1024: {
                    slidesPerView: 2,
                    spaceBetween: 5,
                },
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 5,
                },
            },
        });
    </script>

@endsection
