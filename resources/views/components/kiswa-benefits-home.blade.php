@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/kiswa-benefits-home.css') }}">
    @if(App::getLocale() == 'ar')
        <link rel="stylesheet" href="{{ mix('css/components/kiswa-benefits-home-ar.css') }}">

    @endif
@endPushOnce
<section class="kiswa-benefits-home mt-5  position-relative ">
    @if(isset($section["background"]))
        <div class="mask w-100 h-100 position-absolute bottom-0 right-0" style="z-index: -1">
            <img loading="lazy"
                 data-src="{{$section["background"]}}"
                 alt="{{$section["alt"]??''}}" class="image-fluid w-100 h-100 "></div>
    @endif
    <div class="secound-section   position-relative">
        <div class="container">
            <div class="row justify-content-center cards overflow-hidden">
                <div class="col-12 text-center mb-2">
                    <h1 data-aos="fade-up">{!!$section['title']??""!!}</h1>
                    <div class="my-1" data-aos="fade-down">{!! $section['description']??"" !!}</div>
                </div>

                @foreach($section['cards'] as $card)
                    <div class="col-12 col-lg-6 col-xl-4  d-flex position-relative card-container mt-4 mt-xl-2"
                         data-aos="zoom-out">
                        <div class="w-100 p-4 card h-100 border-0" style="background-color: {{$card['BGColor']}}">
                            <h2 data-aos="fade-up" class="pt-4">{{$card['title']}}</h2>
                            <div class="description pt-3" data-aos="fade-left"
                                 data-aos-duration="800">{!!$card['description']??""!!}</div>
                            <img loading="lazy" data-src="{{$card['image']??url('/images/placeholder.png')}}"
                                 alt="{{$card['alt']??''}}"
                                 class="image-fluid">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@pushOnce('scripts')
    <script src="{{ mix('js/components/kiswa-benefits-home.js') }}" defer></script>

@endPushOnce

