@extends('auth.dashboard-layout')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/components/pagination-style.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">

    <style>
        .selectdiv {
            height: fit-content !important;
            width: fit-content !important;
        }

        .selectdiv :after {
            top: 15% !important;
        }
    </style>
    @if(App::getLocale() == 'ar')
        <style>
            .selectdiv:after {
                transform: rotate(87deg) translateX(0) !important;
                right: auto !important;
                top: 25% !important;
                left: 6px;
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
                <div class="col-2  px-sm-2 px-0 bg-white sidebar-col d-flex">
                    @include('auth.components.sidebar')
                </div>
                <div class="col-10 pt-5 pt-lg-3">
                    <div class="container table-responsive order-container m-0">

                        <div class="d-flex flex-column h-100">
                            <div class="table-header d-flex py-4">
                                <div class="d-flex flex-column w-100 title">
                                    <h3>{{__('My Points')}}</h3>
                                    <h4 class="userPointsCounts">{{__('You Have ')}}<span
                                            class="userPoints is_number count"
                                            data-target="{{$userPointsCounts}}">0</span> {{__('Point')}}
                                    </h4>
                                </div>

                                <div class="d-flex justify-content-center justify-content-sm-end col-4 h-100 ">
                                    <div class="selectdiv w-100">
                                        <div class=" flex">
                                            <select id="select_id" class="select-filter-points" name="filter">
                                                <option value="Active">{{__('Active')}}</option>
                                                <option value="Finish">{{__('Finish')}}</option>
                                                <option value="All">{{__('All')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="main-table flex-column d-flex align-items-center justify-content-center flex-fill w-100" id="table_data">
                                @include('auth.components.points-client-table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

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
                    url:  `/{{\App\Helpers\AppHelper::getSlug()}}/dashboard/points-client/pagination?page=${page}&filter=${$("#select_id").val()}`  ,
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

        $(document).on('change', '.select-filter-points', function (e) {
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
                url: "/{{\App\Helpers\AppHelper::getSlug()}}/dashboard/points-client/pagination",
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
