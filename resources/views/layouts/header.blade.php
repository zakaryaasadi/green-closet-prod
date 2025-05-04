@php
    use App\Enums\UserType;use App\Helpers\AppHelper;use App\Models\Country;use GuzzleHttp\Client;
    $countries = Country::where(['status'=>\App\Enums\ActiveStatus::ACTIVE])->get();
    $client = new Client();
    $flags = [];
    $englishCodes = [];
    $client = new Client();
    foreach ($countries as $country) {
        AppHelper::setCountryInfo($country);
        $flags[] = $country->flag;
        $englishCodes[] = $country->ico;
    }
    $currentSlug = AppHelper::getLocationSettings();
    $currentCountry = $currentSlug->country;
    $currentFlag = $currentCountry->flag;
    $currentEnglishCode = $currentCountry->ico;
@endphp
    <!-- start navbar  -->
<nav>
    <nav class="navbar navbar-expand-xl navbar-light bg-white  z-index-99 w-100" id="header">
        <div class="container ">
            <a class="navbar-brand px-3" href="/{{AppHelper::getSlug()}}">
                <img loading="lazy" data-src="{{$locationSettings['header']['logo']}}" alt="" class="   header-logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="navbar-collapse collapse flex-row-reverse d-xl-flex align-items-center justify-content-center"
                 id="navbarNav">
                {{-- languages button--}}

                <div class="d-flex align-items-center justify-content-center gap-4 gap-lg-2">
                    <div
                        class="dropdown   mt-sm-0 d-flex align-item-center justify-content-start mx-0 mx-lg-2 w-fit dropdown-languages ">
                        <a href=""
                           class=" text-dark text-decoration-none dropdown-toggle d-flex align-items-center gap-1 "
                           id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <span>{{$currentSlug->language->name}}</span>
                            @if($currentSlug->language->code =='ar')
                                <img src="{{url($currentFlag)}}" alt="" class="flag-image-ar flag-icon">
                            @else
                                <img src="/images/English.png" alt="" class="flag-icon">
                            @endif

                        </a>
                        <ul class="dropdown-menu lang">
                            @foreach($languages as $lang)
                                <li>
                                    <a href="/{{AppHelper::getSlug()}}/language/{{$lang['code']}}"
                                       class="dropdown-item d-flex align-items-center justify-content-between {{$lang['name'] =='English'? 'font-Poppins':false}}">
                                        {{$lang["name"]}}
                                        @if($lang['code'] =='ar')
                                            <img src="{{url($currentFlag)}}" alt="" class="flag-image-ar flag-icon">
                                        @else
                                            <img src="/images/English.png" alt="" class="flag-icon">
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    {{-- Countries button--}}
                    <div
                        class=" d-flex align-item-center justify-content-between justify-content-sm-around  flex-sm-row my-4 my-lg-2 my-xl-0">
                        <div
                            class="dropdown   mt-sm-0 d-flex align-item-center justify-content-start mx-0 mx-lg-2 w-fit dropdown-languages ">
                            <a href=""
                               class=" text-dark text-decoration-none dropdown-toggle d-flex align-items-center gap-1 "
                               id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span>
                                        @if($currentSlug->language->code =='ar')
                                            {{$currentSlug->country->meta['translate']['name_ar']}}
                                        @else
                                            {{$currentEnglishCode}}
                                        @endif
                                    </span>
                                <img src="{{url($currentFlag)}}" alt="" class="flag-icon">

                            </a>
                            <ul class="dropdown-menu lang">
                                @foreach($countries as $country)
                                    <li>
                                        <a href="/{{AppHelper::getSlug()}}/country/{{$country->id}}"
                                           class="dropdown-item d-flex align-items-center justify-content-between {{$lang['name'] =='English'? 'font-Poppins':false}}">
                                            @if($currentSlug->language->code =='ar')
                                                {{$country->meta['translate']['name_ar']}}
                                            @else
                                                {{$englishCodes[$loop->index]}}
                                            @endif
                                            <img src="{{url($flags[$loop->index])}}" alt="" class="flag-icon">
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @if(Auth::check())
                            <div class="d-flex">

                                {{-- dropdown-notification --}}
                                {{--                            <div--}}
                                {{--                                class="dropdown d-flex align-item-center justify-content-center mx-2 mx-lg-2 mt-lg-0 dropdown-profile w-fit ">--}}
                                {{--                                <a href=""--}}
                                {{--                                   id="dropdownNotification" data-bs-toggle="dropdown" aria-expanded="false"--}}
                                {{--                                   class="text-white text-decoration-none sign-up-link  mt-lg-0">--}}
                                {{--                                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"--}}
                                {{--                                         xmlns="http://www.w3.org/2000/svg">--}}
                                {{--                                        <path fill-rule="evenodd" clip-rule="evenodd"--}}
                                {{--                                              d="M2.55859 17.0959C2.5586 16.7151 2.7133 16.3506 2.98723 16.086L4.01619 15.0922C4.40788 14.7139 4.62837 14.1922 4.62673 13.6476L4.61727 10.4946C4.60403 6.08319 8.17648 2.5 12.5879 2.5C16.99 2.5 20.5586 6.06859 20.5586 10.4707L20.5586 13.6716C20.5586 14.202 20.7693 14.7107 21.1444 15.0858L22.1444 16.0858C22.4096 16.351 22.5586 16.7107 22.5586 17.0858C22.5586 17.8668 21.9254 18.5 21.1444 18.5H16.5586C16.5586 20.7091 14.7677 22.5 12.5586 22.5C10.3495 22.5 8.55859 20.7091 8.55859 18.5H3.96267C3.18722 18.5 2.55859 17.8714 2.55859 17.0959ZM10.5586 18.5C10.5586 19.6046 11.454 20.5 12.5586 20.5C13.6632 20.5 14.5586 19.6046 14.5586 18.5H10.5586ZM18.5586 13.6716C18.5586 14.7324 18.98 15.7499 19.7302 16.5L5.4371 16.5C6.20081 15.746 6.62995 14.7161 6.62672 13.6416L6.61726 10.4886C6.60734 7.1841 9.28339 4.5 12.5879 4.5C15.8854 4.5 18.5586 7.17316 18.5586 10.4707L18.5586 13.6716Z"--}}
                                {{--                                              fill="#808191"/>--}}
                                {{--                                        --}}
                                {{--                                        <circle cx="19.0586" cy="6" r="3.5" fill="#EB5757"/>--}}
                                {{--                                        --}}
                                {{--                                    </svg>--}}
                                {{--                                </a>--}}
                                {{--                                <div--}}
                                {{--                                    class="dropdown-menu dropdown-menu-white text-small bg-transparent border-0 dropdown-notification w-fit"--}}
                                {{--                                    aria-labelledby="dropdownNotification">--}}
                                {{--                                    <div class="container-dropdown-notification">--}}
                                {{--                                        <div class="toast show mt-1" role="alert" aria-live="assertive"--}}
                                {{--                                             aria-atomic="true">--}}
                                {{--                                            <div class="toast-header justify-content-between">--}}
                                {{--                                                <small>11 mins ago</small>--}}
                                {{--                                                <div>--}}
                                {{--                                                    <strong class="mx-2">Kiswa Web</strong>--}}
                                {{--                                                    <button type="button" class="btn-close" data-bs-dismiss="toast"--}}
                                {{--                                                            aria-label="Close"></button>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                            <div class="toast-body">--}}
                                {{--                                                Hello, world! This is a toast message.--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                {{--                            </div>--}}


                                <div
                                    class="dropdown d-flex align-item-center justify-content-start mx-0 mx-lg-2 mt-lg-0 dropdown-profile w-fit">
                                    <a href=""
                                       class="user-name-image text-center text-white text-decoration-none dropdown-toggle d-flex "
                                       id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span
                                        class="w-100 text-center">
                                 {{mb_strtoupper(mb_substr(auth::user()->name,0,1,'utf-8')) }}
                                    </span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-white text-small shadow"
                                        aria-labelledby="dropdownUser1">
                                        <li>
                                            @if(auth::user()->type==UserType::CLIENT)
                                                <a class="dropdown-item  {{(request()->is(AppHelper::getSlug().'/dashboard')) ? 'active fw-bold' : '' }}"
                                                   href="/{{AppHelper::getSlug()}}/dashboard">{{__('Dashboard')}}</a>
                                            @else
                                                <a class="dropdown-item  {{(request()->is(AppHelper::getSlug().'/association')) ? 'active fw-bold' : '' }}"
                                                   href="/{{AppHelper::getSlug()}}/association">{{__('Dashboard')}}</a>
                                            @endif
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item"
                                               href="/{{AppHelper::getSlug()}}/auth/logout">{{__('Sign out')}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div
                    class=" d-flex align-item-center justify-content-between justify-content-sm-around  flex-sm-row my-4 my-lg-2 my-xl-0">
                    <div
                        class="navbar-collapse collapse flex-row-reverse d-xl-flex align-items-center justify-content-center"
                        id="navbarNav">
                        {{-- buttons--}}
                        <ul class="mx-0 mx-xl-4 navbar-nav pb-0 py-4 py-md-0 justify-content-start justify-content-lg-evenly justify-content-xxl-center  ">

                            @if(isset($locationSettings))
                                @if((Auth::check() && auth::user()->type === UserType::CLIENT) || ! Auth::check())
                                    @foreach($locationSettings['header']['buttons'] as $key => $button)
                                        <li>

                                            <a href="{{$button['target'] == '_blank' ? $button['link'] :"/".AppHelper::getSlug().$button['link']}}"
                                               class=" {{ (request()->is(AppHelper::getSlug().$button['link'])) ? 'active fw-bold' : '' }}"
                                               target="{{$button['target']}}">
                                                <button type="button"
                                                        class="btn btn-signup  my-1 my-xl-0 mx-0 mx-xl-3 w-100"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom">
                                                    {{$button['title']}}
                                                </button>
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                                @if(! Auth::check())
                                    <li>
                                        <a href="/{{AppHelper::getSlug()}}/auth/login"
                                           class=""
                                           target="">
                                            <button type="button"
                                                    class="btn sign-up my-1 my-xl-0 mx-0 mx-xl-3 w-100 {{ (request()->is(AppHelper::getSlug().'/auth/login')) ? 'active' : '' }}"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom">
                                                {{__('Login')}}
                                            </button>
                                        </a>
                                    </li>
                                @endif
                            @endif

                        </ul>
                        {{-- links --}}
                        <ul class="navbar-nav secound-list pt-0 py-4 py-md-0 flex-column flex-lg-row justify-content-start justify-content-lg-center justify-content-xxl-evenly flex-xl-grow-1   ">
                            @if(isset($locationSettings))
                                @foreach($locationSettings['header']['links'] as $link)
                                    <li class="nav-item ps-1 pt-4 pt-lg-0">
                                        <a class="nav-link {{(request()->is(AppHelper::getSlug().$link['link'])) ? 'active fw-bold' : ''}}"
                                           aria-current="page"
                                           href="{{$link['target'] == '_blank' ? $link['link']:"/".AppHelper::getSlug().$link['link']}}"
                                           target="{{$link['target']}}"
                                        >
                                            {{$link['title']}}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

            </div>


        </div>
    </nav>
</nav>
<!-- End navbar  -->
