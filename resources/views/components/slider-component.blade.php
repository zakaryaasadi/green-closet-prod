<div class="row w-100 my-5 sliderComponent ">
    <div class="swiper mySwiper-our-partners-home">
        <div class="swiper-wrapper">
            @foreach($partners as $partner )
                @if($loop->index %2 == 0)
                    <div class="swiper-slide d-flex justify-content-center rounded bg-white p-2 rounded">
                        <a href="{{$partner['link']}}" target="_blank">
                            <img loading="lazy" data-src="{{$partner['image']??url('/images/placeholder.png')}}" alt=""
                                 class="w-100 img-fluid">
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
                                 data-src=" {{$partner['image']??url('/images/placeholder.png')}}"
                                 alt=" {{$partner['alt']??''}}" class="w-100 img-fluid">
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>



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
