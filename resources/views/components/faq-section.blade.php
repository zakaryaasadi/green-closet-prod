@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/faq.css') }}">
    @if(App::getLocale() == 'ar')
        <link rel="stylesheet" href="{{ mix('css/components/faq_ar.css') }}">
    @endif
@endPushOnce

<div id="faqs-page" class="position-relative d-flex  align-items-center justify-content-center">
    <div class="wave-top position-absolute top-0 start-0">
        <img loading="lazy" data-src="https://green-closet.com/images/mask-faqs.png" alt="" class="w-100">

    </div>
    <div class="third-section overflow-hidden w-100 py-5 py-lg-0">
        <div class="container-lg">
            <div class="row">
                <div class="col-12 text-center ">
                    <h1 class="" data-aos="fade-up">
                        {!!$section['title']??""!!}
                    </h1>
                    <div data-aos="fade-down">{!! $section['description']??"" !!}</div>
                </div>
            </div>
            <div class="accordion accordion-flush">
                <dl>
                    @foreach($section['faqs'] as $index => $faq)
                        <dt>
                            <a href="#accordion1" aria-expanded="true"   aria-controls="accordion{{$index}}"
                               class="accordion-title accordionTitle js-accordionTrigger" data-aos="fade-left"
                               data-aos-delay="100"
                               data-aos-duration="800">
                                {{$faq['question']}}</a>

                        </dt>
                        <dd class="accordion-content accordionItem is-collapsed" id="accordion{{$index}}"
                            aria-hidden="true">
                            <p> {{$faq['answer']}}</p>
                        </dd>
                    @endforeach
                </dl>
            </div>
        </div>
    </div>




    <div class="wave-bottom position-absolute bottom-0 start-0">
        <img loading="lazy" data-src="/images/mask-faqs.png" alt="" class="w-100">
    </div>
</div>
@pushOnce('scripts')
    <script src="{{ mix('js/components/faq.js') }}"></script>
@endPushOnce

