@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/what-do-we-receive-component.css') }}">
@endPushOnce
<div class="cards-group overflow-hidden my-5 container">
    <div class="row justify-content-center cards overflow-hidden">
        <div class="col-12 text-center">
            <h1 data-aos="fade-up">{!! $section['title']??"" !!}</h1>
        </div>
        <div class="row px-4">
            @foreach($section['cards'] as $card)
                <div class="col-4 col-md-4 col-lg-4 card-box px-0 px-md-4">
                    <div
                        class="rounded d-flex flex-column align-items-center justify-content-center"
                        data-aos="zoom-out">
                        <img loading="lazy" data-src="{{$card['image']??url('/images/placeholder.png')}}"
                             alt="{{$card['alt']??''}}"
                             class="img-fluid"
                             data-aos="zoom-in">
                        <p class="fs-4 text-center"
                           data-aos="fade-up">
                            {{$card['title']}}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
