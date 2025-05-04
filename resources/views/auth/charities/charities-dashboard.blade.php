@extends('auth.dashboard-layout')
@php
    use App\Helpers\AppHelper;
    $settings = \App\Models\Setting::whereCountryId(AppHelper::getLocationSettings()->country_id)?->first() ?? \App\Models\Setting::where(['country_id' => null])->first();
    if (AppHelper::getLocationSettings()->language->code == 'ar')
        $currency = $settings->currency_ar;
    else
        $currency = $settings->currency_en;
@endphp
@section('style')
    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">

    <style>
        .selectdiv select {
            background: #FBFBFB;
            border: 1px solid #E0E0E0;
            border-radius: 5px !important;
        }

        .selectdiv:after {
            top: 5px !important;
        }
    </style>


    @if(App::getLocale() == 'ar')
        <style>
            .welcome-user-charities-img {
                transform: rotateY(360deg) !important;
            }

            .money svg {
                transform: none !important;
            }

            .selectdiv:after {
                transform: rotate(87deg) !important;
                left: 11px;
                right: auto !important;
            }
        </style>
    @endif

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"
            integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE"
            crossorigin="anonymous"></script>


    <script src="{{ mix('js/dashboard.js') }}"></script>

@endsection
@section('content')
    <div class="container-fluid">
        <div class="row flex-nowrap home-container">
            <div class="col-2 px-sm-2 px-0 bg-white sidebar-col d-flex">
                @include('auth.components.charities-sidebar')
            </div>
            <div class="col-10 pt-3">
                <div class="w-100 align-items-end main-container  ">
                    <div class="row">
                        <div class="col-12  d-flex justify-content-between flex-column ">
                            <div class="row flex-fill welcome-user-charities mb-4 mx-1 d-flex">
                                <img class="welcome-user-charities-img " src="{{asset('/images/charities-home.png')}}"
                                     alt="">
                                <div class="row d-flex flex-row align-items-start">
                                    <div class="col-12 col-lg-3 col-xl-3 col-md-6 h-100 d-none d-md-block">
                                        <a href="{{$association->url}}">
                                            <img src="{{$association->thumbnail??url('/images/placeholder.png')}}"
                                                 alt=""
                                                 class="association-logo img-fluid w-100 h-100 ">

                                        </a>
                                    </div>
                                    <div class="col-12 col-lg-4 col-xl-4 col-md-6">
                                        <h1 class="text-bold">
                                            <a href="{{$association->url}}" target="_blank"
                                               class="text-decoration-none text-dark">
                                                @if(App::getLocale() == 'ar')
                                                    {{ $association->meta['translate']['title_ar']}}
                                                @else
                                                    {{ $association->meta['translate']['title_en']}}
                                                @endif

                                            </a>

                                        </h1>
                                        <h5>{{__('Glad to have you back today, we hope you had a nice and bright day')}}</h5>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 ">
                            <div class="row  d-flex justify-content-between">
                                <div class="col-12 col-md-6 col-lg-3  mb-2 mb-lg-0 points-card h-fit">
                                    <div class=" points-inner-card py-2 pt-3 sent d-flex align-items-center">
                                        <div class="container">
                                            <div class="row w-100">
                                                <div class="col-8">
                                                    <span>{{__('Total Orders')}}</span>
                                                </div>
                                                <div class="col-3 d-flex align-items-center justify-content-center">
                                                    <img class="card-icon" src="{{asset('/images/total-orders.png')}}"
                                                         alt="">
                                                </div>
                                            </div>
                                            <div class="row w-100 d-flex flex-row justify-content-between pt-2">
                                                <div class="col-7">
                                                    <h3 class="is_number text-bold">{{$orderCounts}}</h3></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3  mt-2 mt-md-0 points-card h-fit">
                                    <div class=" points-inner-card py-2 pt-3  containers d-flex align-items-center  ">
                                        <div class="container">
                                            <div class="row w-100">
                                                <div class="col-8 ">
                                                    <span>{{__('Containers Number')}}</span>
                                                </div>
                                                <div class="col-3 d-flex align-items-center justify-content-center">
                                                    <img class="card-icon" src="{{asset('/images/containers.png')}}"
                                                         alt="">
                                                </div>
                                            </div>
                                            <div class="row w-100 d-flex flex-row justify-content-between pt-2">
                                                <div class="col-7">
                                                    <h3 class="is_number text-bold">{{$containersCount}}</h3></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3  mt-2 mt-md-0 points-card h-fit">

                                    <div class=" points-inner-card py-2 pt-3  sent d-flex align-items-center all">
                                        <div class="container">
                                            <div class="row w-100">
                                                <div class="col-8 ">
                                                    <span>{{__('Total Weight')}}</span>
                                                </div>
                                                <div class="col-3 d-flex align-items-center justify-content-center">
                                                    <img class="card-icon" src="{{asset('/images/total-weight.png')}}"
                                                         alt="">
                                                </div>

                                            </div>
                                            <div class="row w-100 d-flex flex-row justify-content-between pt-2">
                                                <div class="col-7">
                                                    <h3 class="is_number text-bold">{{$totalWeight}}kg</h3></div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3  mt-2 mt-md-0 points-card h-fit d-none">

                                    <div class=" points-inner-card py-2 pt-3  finance d-flex align-items-center all">
                                        <div class="container">
                                            <div class="row w-100">
                                                <div class="col-8 ">
                                                    <span>{{__('Financial Dues')}}</span>
                                                </div>
                                                <div class="col-3 d-flex align-items-center justify-content-center">
                                                    <img class="card-icon" src="{{asset('/images/total-payments.png')}}"
                                                         alt="">
                                                </div>
                                            </div>
                                            <div class="row w-100 d-flex flex-row justify-content-between pt-2">
                                                <div class="col-4">
                                                    <h3 class="is_number text-bold">{{$financial}}{{$currency}} </h3></div>

                                                @if($financial > 0 )
                                                    <a class=" w-fit py-2 link money col-8 money-btn text-center px-2"
                                                       href="/{{AppHelper::getSlug()}}/association/add-expense">
                                                        {{__('get money')}}

                                                        <svg width="24" height="16" viewBox="0 0 24 16" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M22.3079 9C22.8601 9 23.3079 8.55228 23.3079 8C23.3079 7.44772 22.8601 7 22.3079 7L22.3079 9ZM1.00114 7.29289C0.610621 7.68342 0.61062 8.31658 1.00114 8.7071L7.36511 15.0711C7.75563 15.4616 8.3888 15.4616 8.77932 15.0711C9.16984 14.6805 9.16984 14.0474 8.77932 13.6569L3.12247 8L8.77932 2.34314C9.16984 1.95262 9.16984 1.31946 8.77932 0.928931C8.3888 0.538407 7.75563 0.538407 7.36511 0.928931L1.00114 7.29289ZM22.3079 7L1.70825 7L1.70825 9L22.3079 9L22.3079 7Z"
                                                                fill="white"/>
                                                        </svg>
                                                    </a>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 row">
                        <div class="col-12  col-lg-12  mt-2 mt-lg-0 bg-white p-2 pt-3">
                            <div class="container">

                                <iframe src="/{{\App\Helpers\AppHelper::getSlug()}}/association/chart-bar?months=1"
                                        frameborder="0" class="w-100 iframe-chart">

                                </iframe>
                            </div>
                        </div>
                        <div class="col-12  col-lg-6  mt-2 mt-lg-0 bg-white p-2 pt-3 d-none">

                            <div class="container">

                                <iframe src="/{{\App\Helpers\AppHelper::getSlug()}}/association/chart-line?months=1"
                                        frameborder="0" class="w-100 iframe-chart">

                                </iframe>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection


