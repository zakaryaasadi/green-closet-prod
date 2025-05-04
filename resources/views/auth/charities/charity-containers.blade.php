@extends('auth.dashboard-layout')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/components/pagination-style.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css"/>


    <style>

        html body {
            overflow-x: hidden;
            width: 100%;
        }
        .datepicker * {
            font-family: "Poppins" !important;
        }

        .accordion-button:not(.collapsed) {
            background: #008451;
            color: #fff;
        }

        .accordion-button:not(.collapsed)::after {
            filter: brightness(0.5);
        }

        .form-control {
            border-color: #6b6a6aad;

        }

        i.bi,i.fa {
            width: 35px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000000;
        }

        .selectdiv select {
            height: 75% !important;
            border-radius: 5px !important;
        }

        .selectdiv:after {
            top: 5px !important;
        }
    </style>

    @if(App::getLocale() == 'ar')
        <style>
            .selectdiv:after {
                transform: rotate(87deg) !important;
                left: 11px;
                right: auto !important;
            }

            .datepicker--nav-action svg{
                rotate: 180deg;
            }
        </style>

    @endif

    @if(App::getLocale() == 'en')
        <style>
            table {
                direction: ltr !important;
                text-align: start;
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
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row flex-nowrap home-container">
            <div class="col-2 px-sm-2 px-0 bg-white sidebar-col d-flex">
                @include('auth.components.charities-sidebar')
            </div>
            <div class="col-10 pt-3">
                <div class="container table-responsive order-container d-flex flex-column">
                    <div class="table-header d-flex py-4">

                        <div class=" w-100">
                            <div class="row">
                                <div class="col-12 d-flex">
                                    <h3 class="text-bold ">{{__('Containers Report')}}</h3>
                                    <div class="d-flex justify-content-end flex-fill align-items-center">
                                        <div class="d-flex justify-content-center justify-content-sm-end   h-100 ">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex">
                                    <div class="accordion w-100" id="accordionExample">
                                        <div class="accordion-item w-100">
                                            <h2 class="accordion-header pt-0 " id="headingOne">
                                                <button class="accordion-button dir-ltr" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                        aria-expanded="true" aria-controls="collapseOne">
                                                    {{__('Filter')}}
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show"
                                                 aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div
                                                        class="d-flex align-items-center gap-1 position-relative">
                                                        {{--                                                                        <i class="fa fa-calendar"></i>--}}
                                                        {{--                                                                        <i class="fa fa-caret-down"></i>--}}
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-12 d-flex mt-2">
                                                                    <h4>
                                                                        {{__('Filter By')}} :
                                                                    </h4>
                                                                </div>
                                                                <div class="col-12 col-md-6 col-lg-4 mt-2 mt-md-1 d-flex align-items-center gap-1">
                                                                    <i class="bi bi-search"></i>
                                                                    <input
                                                                        name="id"
                                                                        id="id"
                                                                        class="form-control  w-100"
                                                                        placeholder="{{__('ID')}}"
                                                                    /></div>
                                                                <div class="col-12 col-md-6 col-lg-4 mt-2 mt-md-1 d-flex align-items-center gap-1">
                                                                    <i class="bi bi-qr-code"></i>
                                                                    <input
                                                                        name="code"
                                                                        id="code"
                                                                        class="form-control   w-100"
                                                                        placeholder="{{__('container code')}}"
                                                                    /></div>


                                                                <div class="col-12 col-md-6 col-lg-4 mt-2 mt-md-1 d-flex align-items-center gap-1">
                                                                    <i class="bi bi-house"></i>
                                                                    <select class="form-select" aria-label="Default select example" name="province" id="province">
                                                                        <option value="" selected disabled hidden>{{__('Select Province')}}</option>
                                                                        @foreach($provinces as $province)
                                                                            @if(\App\Helpers\AppHelper::getLocationSettings()->language->code == "ar")
                                                                                <option
                                                                                    value="{{$province->id}}">{{ $province->meta['translate']['name_ar'] }}</option>
                                                                            @else
                                                                                <option
                                                                                    value="{{$province->id}}">{{ $province->meta['translate']['name_en'] }}</option>
                                                                            @endif

                                                                        @endforeach
                                                                    </select>
                                                                </div>


                                                                <div class="col-12 col-md-6 col-lg-4 mt-2 mt-md-2 d-flex align-items-center gap-1">
                                                                    <i class="bi bi-filter-left"></i>
                                                                    <select id="select_id" class="form-select select-filter-container" name="filter">
                                                                        <option value="All">{{__('All')}}</option>
                                                                        <option value="1">{{__('Clothes')}}</option>
                                                                        <option value="4">{{__('Glass')}}</option>
                                                                        <option value="3">{{__('Plastic')}}</option>
                                                                        <option value="2">{{__('Shoes')}}</option>
                                                                    </select>
                                                                </div>




                                                                <div class="col-12 d-flex mt-4">
                                                                    <h4>
                                                                        {{__('By Date')}} :
                                                                    </h4>
                                                                </div>
                                                                <div class="col-12 col-md-6 col-lg-4 mt-2 mt-md-1 d-flex align-items-center gap-1">
                                                                    <i class="bi bi-calendar"></i>
                                                                    <input
                                                                        name="from"
                                                                        id="from"
                                                                        class="form-control datepicker-here is_number   w-100"
                                                                        placeholder="{{__('From Date')}}"
                                                                        data-date-format="yyyy-mm-dd" data-language='en'
                                                                    /></div>
                                                                <div class="col-12 col-md-6 col-lg-4 mt-2 mt-md-1 d-flex align-items-center gap-2">

                                                                    <input
                                                                        name="to"
                                                                        id="to"
                                                                        data-date-format="yyyy-mm-dd" data-language='en'
                                                                        class="form-control datepicker-here is_number   w-100"
                                                                        placeholder="{{__('To Date')}}"
                                                                    />
                                                                    <button type="button" class="btn btn-success h-100"
                                                                            id="filter">
                                                                        <i class="bi bi-funnel-fill text-white"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="col-12 col-md-6 col-lg-4 mt-2 mt-md-1 d-flex align-items-center gap-2">
                                                                    <button type="button" class="btn btn-danger h-100"
                                                                            id="reset">
                                                                        <i class="fas fa-undo"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div
                        class="main-table flex-column d-flex align-items-center justify-content-center flex-fill w-100"
                        id="table_data">
                        @include('auth.charities.charity-containers-table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            function showLoading() {
                $(".main-table").html("{{__('Loading...')}}")
            }

            $(document).on('click', '.pagination a', function (event) {
                event.preventDefault();
                showLoading();
                var page = $(this).attr('href').split('page=')[1];
                var data = {}

                if (document.getElementById("from").value !== '')
                    data.start_date = $(`#from`).val();

                if (document.getElementById("select_id").value !== '' && document.getElementById("select_id").value !== 'All')
                    data.type = $(`#select_id`).val();

                if (document.getElementById("to").value !== '')
                    data.end_date = $(`#to`).val();

                if (document.getElementById("code").value !== '')
                    data.code = $(`#code`).val();

                if (document.getElementById("province").value !== '')
                    data.province_id = $(`#province`).val();

                if (document.getElementById("id").value !== '')
                    data.id = $(`#id`).val();

                fetch_data(page,data);
            });

            function fetch_data(page,data) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    data : data,
                    url: `/{{\App\Helpers\AppHelper::getSlug()}}/association/containers-association/pagination?page=${page}`,
                    success: function (orders) {
                        $('#table_data').html(orders);
                    }
                });
            }

            $(document).on('click', '#filter', function (event) {
                event.preventDefault();
                showLoading();
                var data = {}

                if (document.getElementById("from").value !== '')
                    data.start_date = $(`#from`).val();

                if (document.getElementById("select_id").value !== '' && document.getElementById("select_id").value !== 'All')
                    data.type = $(`#select_id`).val();

                if (document.getElementById("to").value !== '')
                    data.end_date = $(`#to`).val();

                if (document.getElementById("code").value !== '')
                    data.code = $(`#code`).val();

                if (document.getElementById("province").value !== '')
                    data.province_id = $(`#province`).val();

                if (document.getElementById("id").value !== '')
                    data.id = $(`#id`).val();


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    data : data,
                    url: `/{{\App\Helpers\AppHelper::getSlug()}}/association/containers-association/pagination`,
                    success: function (orders) {
                        $('#table_data').html(orders);
                    }
                });
            });

            $(document).on('click', '#reset', function (event) {
                event.preventDefault();
                showLoading();
                document.getElementById("from").value = '';
                document.getElementById("to").value = '';
                document.getElementById("id").value = '';
                document.getElementById("code").value = '';
                document.getElementById("province").value = '';
                document.getElementById("select_id").value = 'All';
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: `/{{\App\Helpers\AppHelper::getSlug()}}/association/containers-association/pagination`,
                    success: function (orders) {
                        $('#table_data').html(orders);
                    }
                });
            });

        });


    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.js" ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"
            referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.min.js"
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">
        $('#from').datepicker({
            language: 'en',
            range: false,
            multipleDates: false,
            multipleDatesSeparator: " - "
        })

        $('#to').datepicker({
            language: 'en',
            range: false,
            multipleDates: false,
            multipleDatesSeparator: " - "
        })
    </script>

    {{--    page  --}}
    <script>
        let SomethingWrong = `{{__('Something went wrong, please try again')}}`

        function showLoading() {
            $(".main-table").html("{{__('Loading...')}}")
        }

        function ShowToast(e, root) {
            $('.toast-body').html(e);
            toast = new bootstrap.Toast($(`#${root}`))
            toast.show()
        }
    </script>
    <script type="text/javascript">

    </script>

@endsection
