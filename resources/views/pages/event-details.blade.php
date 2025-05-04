@extends('layout')

@section('style')
    <link rel="stylesheet" href="https://rawgit.com/LeshikJanz/libraries/master/Bootstrap/baguetteBox.min.css">

    <link rel="stylesheet" href="{{mix('css/components/events-details.css')}}">
    <style>
        main {
            height: fit-content
        }
    </style>
    @if(App::getLocale() == 'en')
        <style>
            .swiper-button-next svg, .swiper-button-prev svg,
            .back-to-events svg {
                rotate: 180deg;
            }
        </style>
    @endif

@endsection

@section('content')
    <main id="events-details-page" class=" pt-5 d-flex  flex-column  justify-content-evenly ">
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex flex-column ">
                    <div
                        class="btn text-info back-to-events w-fit d-flex flex-row-reverse align-items-center justify-content-center px-0"
                        onclick="history.back()">

                        <svg width="34" height="23" viewBox="0 0 34 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M32.6593 12.5284C33.2451 11.9426 33.2451 10.9929 32.6593 10.4071L23.1134 0.861172C22.5276 0.275385 21.5779 0.275385 20.9921 0.861172C20.4063 1.44696 20.4063 2.39671 20.9921 2.98249L29.4774 11.4678L20.9921 19.9531C20.4063 20.5388 20.4063 21.4886 20.9921 22.0744C21.5779 22.6602 22.5276 22.6602 23.1134 22.0744L32.6593 12.5284ZM0.00292969 12.9678H31.5987V9.96777H0.00292969V12.9678Z"
                                fill="#00A3ED"/>
                        </svg>

                    </div>
                    <h2>{{$eventDetails['title']}}</h2>
                    <p class="text-secondary number">{{$eventDetails['date']}}</p>
                </div>
                <div class="col-12">
                    <div class="fs-4">{!!$eventDetails['description']!!}</div>
                </div>
            </div>
        </div>
        <div class=" gallery-container">
            <div class="tz-gallery">
                <div class="swiper mySwiper-in-events-details-page h-fit py-5">
                    <div class="swiper-wrapper">
                        @foreach($eventDetails['images'] as $key => $node)
                            <div class="swiper-slide d-flex flex-column flex-lg-row">
                                <a class="lightbox" href="{{$node??url('/images/placeholder.png')}}">
                                    <img loading="lazy" data-src="{{$node??url('/images/placeholder.png')}}"
                                         alt="{{$eventDetails['alts'][$key] ?? ''}}"
                                         class="w-100">
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next ">
                        <svg width="64" height="63" viewBox="0 0 64 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M0 62.1641L64 62.1641L64 0.164062L5.42021e-06 0.164057L0 62.1641ZM48.4639 42.8752L36.3752 31.1641L48.4638 19.4532L38.0442 9.35925L15.5361 31.164L38.0442 52.9691L48.4639 42.8752Z"
                                  fill="white" fill-opacity="0.73"/>
                        </svg>
                    </div>
                    <div class="swiper-button-prev ">
                        <svg width="65" height="63" viewBox="0 0 65 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M64.4434 0.164062H0.443359V62.1641H64.4434V0.164062ZM15.9795 19.4529L28.0682 31.164L15.9795 42.8749L26.3991 52.9689L48.9073 31.1641L26.3992 9.35902L15.9795 19.4529Z"
                                  fill="white" fill-opacity="0.73"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js"
            integrity="sha512-7KzSt4AJ9bLchXCRllnyYUDjfhO2IFEWSa+a5/3kPGQbr+swRTorHQfyADAhSlVHCs1bpFdB1447ZRzFyiiXsg=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"></script>
    <script>
        baguetteBox.run('.tz-gallery', {
            animation: 'fadeIn',
            noScrollbars: true
        });
    </script>





    <script>
        var swiper = new Swiper(".mySwiper-in-events-details-page", {
            slidesPerView: 1,
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 5,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 5,
                },
                1200: {
                    slidesPerView: 4,
                    spaceBetween: 5,
                },
                1400: {
                    slidesPerView: 5.5,
                    spaceBetween: 5,
                },
            },
            loop: true,
        });
    </script>

@endsection
