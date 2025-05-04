@php
    use App\Helpers\AppHelper;
@endphp
@extends('auth.dashboard-layout')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/components/pagination-style.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">
    <style>
        .selectdiv:after {

            top: 35% !important;
        }
    </style>

    @if(App::getLocale() == 'ar')
        <style>
            .selectdiv:after {
                transform: rotate(87deg) translateX(-50%) !important;
                left: 11px;
                right: auto !important;
                top: 35% !important;
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





    <main class="pt-xl-0 bg-transparent dashboard-page">



        <div class="container-fluid">

            <div class="row flex-nowrap home-container">
                <div class="col-2 px-sm-2 px-0 bg-white sidebar-col d-flex">
                    @include('auth.components.sidebar')
                </div>
                <div class="col-10  pt-2 pt-lg-3">
                    <div class="container table-responsive order-container m-0 d-flex flex-column">


                        <div class="table-header d-flex py-4">
                            <h3>{{__('Orders')}}

                            </h3>
                            <div class="d-flex justify-content-end w-100 align-items-center">
                                <a class="mx-2" href="/{{AppHelper::getSlug()}}/create-order">
                                    <button type="button"
                                            class="btn  my-1 btn-primary d-none d-md-flex  "
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="button">
                                        {{__('Create New Order')}}
                                    </button>
                                    <span class="d-flex d-md-none">
                                        <i class="bi bi-plus-circle text-primary fs-3"></i>
                                    </span>
                                </a>
                                <div class="d-flex justify-content-center justify-content-sm-end col-4 h-100 ">
                                    <div class="selectdiv w-100">
                                        <div class=" flex">
                                            <select id="select_id" class="select-filter-orders" name="filter">
                                                <option value="All">{{__('All')}}</option>
                                                <option value="Created">{{__('Created')}}</option>
                                                <option value="Assigned">{{__('Assigned')}}</option>
                                                <option value="Accepted">{{__('Accepted')}}</option>
                                                <option value="Declined">{{__('Declined')}}</option>
                                                <option value="Canceled">{{__('Canceled')}}</option>
                                                <option value="Delivering">{{__('Delivering')}}</option>
                                                <option value="Failed">{{__('Failed')}}</option>
                                                <option value="Successful">{{__('Successful')}}</option>
                                                <option value="Postponed">{{__('Postponed')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div
                            class="main-table flex-column d-flex align-items-center justify-content-center flex-fill w-100"
                            id="table_data">
                            @include('auth.components.orders-client-table')
                        </div>
                    </div>
                </div>
            </div>
            <div class=" " style="z-index: 11">
                <div id="liveToastError" class="toast" role="alert" aria-live="assertive"
                     aria-atomic="true">
                    <div class="toast-header bg-danger ">
                        <div class="row w-100">
                            <strong class="col-11 bg-danger text-white">{{__('Error')}}</strong>
                            <button type="button" class="btn-close col-1" data-bs-dismiss="toast"
                                    aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="toast-body">

                    </div>
                </div>
            </div>
        </div>
    </main>


    <script>
        $(document).ready(function () {
            @if($errors->any())
                ShowToast(`{{__('Sorry, you have already active order')}}`,"liveToastError")
            @endif

            function showLoading() {
                $(".main-table").html("{{__('Loading...')}}")
            }

            $(document).on('click', '.pagination a', function (event) {
                event.preventDefault();
                showLoading();
                var page = $(this).attr('href').split('page=')[1];
                fetch_data(page);
            });

            function fetch_data(page) {
                $.ajax({
                    url: `/{{AppHelper::getSlug()}}/dashboard/orders-client/pagination?page=${page}&filter=${$("#select_id").val()}`,
                    success: function (orders) {
                        $('#table_data').html(orders);
                    }
                });
            }
        });
    </script>
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

        $(document).on('change', '.select-filter-orders', function (e) {
            showLoading();
            e.preventDefault();
            var data = {
                'filter': $(e.target).val(),
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "GET",
                url: "/{{AppHelper::getSlug()}}/dashboard/orders-client/pagination",
                data: data,
                dataType: "html",
                success: (response) => {
                    const res = response
                    $(".main-table").html(res)
                },
                error: () => {
                    ShowToast(SomethingWrong, "liveToastError")
                },
            })
        })
    </script>

@endsection



