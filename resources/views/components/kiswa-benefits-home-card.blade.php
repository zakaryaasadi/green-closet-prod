@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/kiswa-benefits-home.css') }}">
    @if(App::getLocale() == 'ar')
        <link rel="stylesheet" href="{{ mix('css/components/kiswa-benefits-home-ar.css') }}">

    @endif
@endPushOnce


<section class="kiswa-benefits-home mt-5  position-relative ">
    @if(isset($section["background"]))
        <div class="mask w-100 h-100 position-absolute bottom-0 right-0" style="z-index: -1">
            <img loading="lazy" data-src="{{$section["background"]}}"
                 alt="{{$section["alt"]??''}}" class="image-fluid w-100 h-100 ">
        </div>
    @endif
    <div class="secound-section   position-relative py-5">
        <div class="container  ">
            <div class="row justify-content-center cards overflow-hidden">
                <div class="col-12 text-center mb-2">
                    <h1 data-aos="fade-up">{!!$section['title']??""!!}</h1>
                </div>
                @foreach($section['cards'] as $card)
                    <div class="col-12 col-lg-6 col-xl-4  d-flex position-relative card-container mt-4 mt-xl-2"
                         data-aos="zoom-out">
                        <div class="w-100 p-0 pb-3 card h-100 border-0" style="background-color: {{$card['BGColor']}}">
                            <div class="image-box w-100">

                                <img loading="lazy"
                                     data-src="{{$card['image']??url('/images/placeholder.png')}}"
                                     alt="{{$card['alt']??''}}"
                                     class="image-fluid w-100 h-100 ">
                            </div>
                            <div class="w-100 p-2 p-md-4 text-center">
                                <h2 data-aos="fade-up" class="pt-4">{{$card['title']}}</h2>
                                <div class="description pt-3" data-aos="fade-left"
                                     data-aos-duration="800">{!!$card['description']!!}</div>
                            </div>

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
