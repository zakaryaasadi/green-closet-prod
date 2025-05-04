@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/news.css') }}">
@endPushOnce

@php
    use App\Helpers\AppHelper;
@endphp

<section class="news mt-5 pb-5">
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-12 text-center py-4">
                <h1 data-aos="fade-up">{!!$section['title']??""!!}</h1>
            </div>
            <div class="col-12 text-center py-4">
                <div data-aos="fade-down">{!! $section['description'] !!}</div>
            </div>
            <div class="swiper mySwiper-in-news-section">
                <div class="swiper-wrapper">
                    @foreach($news as $item)
                        <div class="swiper-slide">
                            <div class="card w-100 border-0 ">
                                <a href="/{{AppHelper::getSlug()}}/news/{{$item['slug']}}"
                                   class="text-decoration-none text-dark"
                                   target="{{$section['component_target']}}">
                                    <img loading="lazy" data-src="{{$item['image']??url('/images/placeholder.png')}}"
                                         class="card-img-top" alt="{{$item['alt']??'' }}" data-aos="zoom-in">
                                    <div class="card-body">
                                        <p class="card-text" data-aos="fade-down">{{$item['title'] }}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-12 justify-content-center d-flex mt-5">
                <a href="/{{AppHelper::getSlug()}}{{$section['button']['link']}}"
                   target="{{$section['button']['target']}}"
                   class="text-decoration-none">
                    <button class="btn btn-outline-primary py-3">
                        {{$section['button']['title']}}
                    </button>
                </a>
            </div>
        </div>
    </div>
</section>
@pushOnce('scripts')
    <script src="{{ mix('js/components/news.js') }}"></script>

    <script>
        var swiper = new Swiper(".mySwiper-in-news-section", {
            @if(App::getLocale() == 'ar')
            reverseDirection: true,
            @endif

            slidesPerView: 1,
            spaceBetween: 10,
            grabCursor: true,
            speed: 1500,
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 40,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 50,
                },
            },
            autoplay: {
                delay: 3500,

            },
        });
    </script>

@endPushOnce
