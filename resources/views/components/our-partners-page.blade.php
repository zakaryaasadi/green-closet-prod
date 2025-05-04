@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/our-partners-page.css') }}">
    @if(App::getLocale() == 'ar')
    @endif
@endPushOnce
<section class="our-partners-page py-5 pt-md-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 d-flex justify-content-center align-items-center py-4">
                <h1>{!!$section['title']??""!!}</h1>
            </div>
            @foreach($partners as $partner)
                <div class="col-6 col-md-4 col-lg-3 p-1 p-md-2 p-lg-4">
                    <a href="{{$section['component_target'] === '_blank' ?$partner['link']:"/".\App\Helpers\AppHelper::getSlug().$partner['link']}}"
                       class="card-partner w-100  d-flex justify-content-center align-items-center"
                       target="{{$section['component_target']}}">
                        <img loading="lazy"
                             data-src="{{$partner['image']??url('/images/placeholder.png')}}"
                             alt="{{$partner['alt']??''}}" class=" img-fluid h-100">
                    </a>
                </div>
            @endforeach

        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-4 py-3 py-lg-5 d-flex justify-content-center align-items-center">
                <div class="description description text-center">{!! $section['description'] !!} </div>
            </div>
            <div class="col-12 d-flex justify-content-center align-items-center mt-4">
                <a href="{{$section['button']["target"] === '_blank' ?$section['button']["link"]:"/".\App\Helpers\AppHelper::getSlug().$section['button']["link"]}}"
                   target="{{$section['button']["target"]}}"
                   class="btn py-2 join-us text-white"
                >
                    {{$section['button']["title"]}}

                </a>
            </div>
        </div>
    </div>
</section>

@pushOnce('scripts')

@endPushOnce

