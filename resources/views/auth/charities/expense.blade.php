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
        </style>


    @endif

    @if(App::getLocale() == 'en')
        <style>
            table{
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
                        <h3>{{__('Account Statement')}}
                        </h3>
                        <div class="d-flex justify-content-end flex-fill align-items-center">
                            <div class="d-flex justify-content-center justify-content-sm-end   h-100 ">
                                <div class="selectdiv w-100">
                                    <div class=" w-100">
                                        <div class="d-flex justify-content-center justify-content-sm-end   h-100 ">
                                            <div class="selectdiv w-100">
                                                <div class=" flex">
                                                    <select id="select_id" class="select-filter-expenses" name="filter">
                                                        <option value="All">{{__('All')}}</option>
                                                        <option value="processing">{{__('Processing')}}</option>
                                                        <option value="payed">{{__('Payed')}}</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>



                    <div
                        class="main-table flex-column d-flex align-items-center justify-content-center flex-fill w-100 flex-fill" id="table_data">
                        @include('auth.charities.expense-table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function showLoading() {
                $(".main-table").html("{{__('Loading...')}}")
            }

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                showLoading();
                var page = $(this).attr('href').split('page=')[1];
                fetch_data(page);
            });
            function fetch_data(page) {
                $.ajax({
                    url:  `/{{\App\Helpers\AppHelper::getSlug()}}/association/expenses-association/pagination?page=${page}&filter=${$("#select_id").val()}`  ,
                    success: function(orders) {
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

        $(document).on('change', '.select-filter-expenses', function (e) {
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
                url: "/{{\App\Helpers\AppHelper::getSlug()}}/association/expenses-association/pagination",
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
