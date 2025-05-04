@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/offers-page.css') }}">
    @if(App::getLocale() == 'ar')
    @endif
@endPushOnce
<section class="offers-page py-5 ">
    <div class="container overflow-hidden ">
        <div class="row justify-content-center">
            <div class="col-12 d-flex justify-content-center align-items-center py-5">
                <h1>{!!$section['title']??""!!}</h1>
            </div>
        </div>
        <div class="row justify-content-between gap-0 gap-xl-5">
            @foreach($partnersOffer as $partner)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 box-card mt-5 mt-xl-0">
                    <div class="card d-flex flex-column align-items-center ">
                        <a href="{{$partner['link']}}" target="{{$section['component_target']}}">
                            <img loading="lazy" data-src="{{$partner['image']??url('/images/placeholder.png')}}"
                                 class="card-img-top" alt="{{$partner['alt']??''}}"
                                 data-aos="fade">
                        </a>
                        <div class="card-body flex-fill w-100">
                            <h5 class="card-title" data-aos="fade-up">{{$partner['name']}}</h5>
                            <ul class="px-3 px-xl-0 list-group">
                                @foreach($partner['offers'] as $offer)
                                    <li class="bg-transparent border-0 list-group-item position-relative d-flex align-items-center justify-content-start  "
                                        data-aos="fade-left">
                                        {{$offer['name']}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@pushOnce('scripts')

@endPushOnce
