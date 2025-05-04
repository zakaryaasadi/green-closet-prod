@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/events.css') }}">
    <link rel="stylesheet" href="{{ mix('css/components/pagination-style.css') }}">
    @if(App::getLocale() == 'ar')
        <link rel="stylesheet" href="{{ mix('css/components/pagination-style-ar.css') }}">
    @endif
@endPushOnce
@php
    use App\Helpers\AppHelper;
@endphp
<section class="events-page d-flex flex-column    mt-5" id="">
    <div class="container">
        <h1 data-aos="fade-up" class="w-100 text-dark py-5 text-center mb-0">
            {!!$section['title']??""!!}
        </h1>
        <div class="my-1" data-aos="fade-down">{!! $section['description']?? ""!!}</div>
    </div>
    <div class="container flex-fill mb-5 d-flex flex-column ">
        <div class="row flex-fill">
            @foreach($events as $event)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 py-2 position-relative overflow-hidden box-image">
                    <a class=" text-decoration-none" href="/{{AppHelper::getSlug()}}/events/{{$event['slug']}}"
                       target="_self">
                        <img loading="lazy" data-src="{{$event['image']??url('/images/placeholder.png')}}"
                             alt="{{$event['alt']??''}}"
                             class="card-img-top" data-aos="zoom-in">
                        <h3 class="card-text text-dark mb-0 mt-2" data-aos="fade-down">{{$event['title'] }}</h3>
                        <span class="number muted text-secondary">{{$event['date']}}</span>
                    </a>
                </div>
            @endforeach
        </div>

        {{--        pagination     --}}
        <div class="row pagination  justify-content-center">
            <div
                class="col-4 col-md-3 col-lg-2  d-flex align-items-center justify-content-evenly col-xxl-1 gap-3 {{(App::getLocale() == 'en' )? "flex-row-reverse" : "" }} ">
                <a href="{{$pagination->nextPageUrl()}}"
                   class="next-news-page {{!$pagination->nextPageUrl() ? "pe-none opacity-25" : "opacity-100 pe-all"}} ">
                    <svg width="32" height="33" viewBox="0 0 32 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M0 0.177734H32V32.1777H0V0.177734ZM21.9326 7.97329L13.1877 16.1777L22.3002 23.8534L19.0222 27.4318L7.76817 16.1777L19.0222 4.92346L21.9326 7.97329Z"
                              fill="#BDBDBD"/>
                    </svg>
                </a>
                <div
                    class="pagination-number d-flex align-items-center justify-content-around flex-fill gap-3 {{(App::getLocale() == 'en' )? "flex-row-reverse" : "" }}">
                    @if($pagination->nextPageUrl())
                        <a href="{{$pagination->nextPageUrl()}}"
                           class="number text-decoration-none">{{$pagination->currentPage() + 1}}</a>
                    @endif
                    <a href=""
                       class="active pe-none number text-decoration-none currentPage">{{$pagination->currentPage()}}</a>
                    @if($pagination->previousPageUrl())
                        <a href="{{$pagination->previousPageUrl()}}"
                           class="number text-decoration-none">{{$pagination->currentPage() - 1}}</a>
                    @endif
                </div>
                <a href="{{$pagination->previousPageUrl()}}"
                   class="prev-news-page  {{!$pagination->previousPageUrl() ? "pe-none opacity-25" : "opacity-100 pe-all"}}">
                    <svg width="32" height="33" viewBox="0 0 32 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M32.0001 32.1777L6.10352e-05 32.1777L6.66302e-05 0.177734L32.0001 0.17774L32.0001 32.1777ZM10.0675 24.3822L18.8123 16.1778L9.69991 8.50203L12.9778 4.9237L24.2319 16.1778L12.9779 27.432L10.0675 24.3822Z"
                              fill="#BDBDBD"/>
                    </svg>
                </a>

            </div>
        </div>
        {{--        pagination     --}}


    </div>


</section>





@pushOnce('scripts')
    <script src="{{ mix('js/components/events.js') }}"></script>
@endPushOnce
