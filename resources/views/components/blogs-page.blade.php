@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/news.css') }}">
    <link rel="stylesheet" href="{{ mix('css/components/pagination-style.css') }}">
    @if(App::getLocale() == 'ar')
        <link rel="stylesheet" href="{{ mix('css/components/pagination-style-ar.css') }}">
    @endif
@endPushOnce

@php
    use App\Helpers\AppHelper;
@endphp


<section class="news-page my-5 position-relative ">
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-center flex-column mb-4">
                <h1 data-aos="fade-up">{!!$section['title']??""!!}</h1>

                <div class="my-1" data-aos="fade-down">{!! $section['description']?? ""!!}</div>
            </div>
        </div>
        <div class="w-100">
            @foreach($blogs as $item)
                <a href="/{{AppHelper::getSlug()}}/blogs/{{$item['slug']}}" class="text-dark text-decoration-none d-flex row ">
                    <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center overflow-hidden">
                        <img loading="lazy" data-src="{{$item['image']??url('/images/placeholder.png')}}"
                             class="card-img-top w-100 img-fluid h-75 fit-cover"
                             alt="{{$item['alt'] ?? '' }}" data-aos="zoom-in">
                    </div>
                    <div class="col-12 col-lg-6 d-flex flex-column justify-content-center ">
                        <h1 class="card-text" data-aos="fade-up">{{$item['title']}}</h1>
                    </div>
                </a>
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
    <script src="{{ mix('js/components/news.js') }}"></script>
@endPushOnce
