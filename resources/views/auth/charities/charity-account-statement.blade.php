@extends('auth.dashboard-layout')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/components/pagination-style.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">
    <style>
        .selectdiv select {
            height: 75% !important;
            border-radius: 5px !important;
        }
        .selectdiv:after {
            top: 20px !important;
        }
    </style>

    @if(App::getLocale() == 'ar')
        <style>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"
            integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha"
            crossorigin="anonymous"></script>
    <script src="{{ mix('js/dashboard.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>

        if (window.location.href.includes('?filter=Active'))
            document.getElementById("select_id").value = "Active";
        if (window.location.href.includes('?filter=Finish'))
            document.getElementById("select_id").value = "Finish";
        else if (window.location.href.includes('?filter=All'))
            document.getElementById("select_id").value = "All";
        else if (!window.location.href.includes('?filter'))
            document.getElementById("select_id").value = "All";

    </script>

@endsection


@section('content')
    <div class="container-fluid">
        <div class="row flex-nowrap home-container">
            <div class="col-2 px-sm-2 px-0 bg-white sidebar-col d-flex">
                @include('auth.components.charities-sidebar')
            </div>
            <div class="col-10 pt-3">
                <div class="container table-responsive order-container">
                    <div class="table-header d-flex py-4">
                        <div class="d-flex flex-column w-100">
                            <h3 class="text-bold ">{{__('Account Statement')}}</h3>
                        </div>
                        <div class="d-flex justify-content-end w-100 ">
                            <div class="selectdiv">
                                <form method="GET" action="points">
                                    <div class="py-2 flex">
                                        <select onchange="this.form.submit()" id="select_id" name="filter">
                                            <option value="Active">{{__('Active')}}</option>
                                            <option value="Finish">{{__('Finish')}}</option>
                                            <option value="All">{{__('All')}}</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <table class="table my-2" id="table-id">
                        <thead>
                        <tr>
                            <th>{{__('count')}}</th>
                            <th>{{__('used')}}</th>
                            <th>{{__('ends at')}}</th>
                            <th>{{__('status')}}</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($points as $point)
                            <tr>
                                <td class="is_number">
                                    @if($point->count > 300)
                                        <span class="high is_number">{{$point->count}}</span>
                                    @elseif($point->status <300)
                                        <span class="low is_number">{{$point->count}}</span>
                                    @endif

                                </td>
                                <td class="is_number">
                                    @if($point->used = '1')
                                        <svg class="used" id="Layer_1" data-name="Layer 1"
                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 122.88">
                                            <defs>
                                                <style>.cls-1 {
                                                        fill: #00a912;
                                                    }

                                                    .cls-1, .cls-2 {
                                                        fill-rule: evenodd;
                                                    }

                                                    .cls-2 {
                                                        fill: #fff;
                                                    }</style>
                                            </defs>
                                            <title>confirm</title>
                                            <path class="cls-1"
                                                  d="M61.44,0A61.44,61.44,0,1,1,0,61.44,61.44,61.44,0,0,1,61.44,0Z"/>
                                            <path class="cls-2"
                                                  d="M42.37,51.68,53.26,62,79,35.87c2.13-2.16,3.47-3.9,6.1-1.19l8.53,8.74c2.8,2.77,2.66,4.4,0,7L58.14,85.34c-5.58,5.46-4.61,5.79-10.26.19L28,65.77c-1.18-1.28-1.05-2.57.24-3.84l9.9-10.27c1.5-1.58,2.7-1.44,4.22,0Z"/>
                                        </svg>
                                    @endif
                                </td>
                                <td class="is_number">{{$point->ends_at}}</td>
                                <td>
                                    @if($point->status == '1')
                                        <span>{{__('Active')}}</span>
                                    @elseif($point->status == '2')
                                        <span>{{__('Finish')}}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class='pagination-container pb-4 py-4'>
                        <div class="row pagination  justify-content-center">
                            <div
                                class="col-4 col-md-3 col-lg-2  d-flex align-items-center justify-content-evenly  ">

                                <div
                                    class="pagination-number d-flex align-items-center justify-content-around flex-fill">
                                    @if($pagination->nextPageUrl())
                                        <a href="{{$pagination->nextPageUrl()}}"
                                           class="number text-decoration-none is_number">{{$pagination->currentPage() + 1}}</a>
                                    @endif
                                    <a href=""
                                       class="active pe-none number text-decoration-none currentPage mx-2 is_number">{{$pagination->currentPage()}}</a>
                                    @if($pagination->previousPageUrl())
                                        <a href="{{$pagination->previousPageUrl()}}"
                                           class="number text-decoration-none is_number">{{$pagination->currentPage() - 1}}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
