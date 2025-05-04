@extends('auth.dashboard-layout')
@php
    use App\Helpers\AppHelper;
@endphp
@section('style')
    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">


    @if(App::getLocale() == 'ar')
        <style>
            .welcome-user-img {
                transform: rotateY(360deg) !important;
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

    <script>

        var valeur = 500 - {{$points['remain']}}; //dynamic
        valeur = (valeur * 100) / 500;
        var btn = valeur - 7;
        var number = valeur - 3;
        var progressbar = document.querySelector('.progress-bar')
        progressbar.style.width = valeur + '%';
        progressbar.setAttribute('aria-valuenow', valeur)

        var numberr = document.querySelector('.number')
        var progressbtn = document.querySelector('.progress-btn')

        @if(App::getLocale()== 'ar')
            numberr.style.right = number + '%';
        progressbtn.style.right = btn + '%';
        @else
            numberr.style.left = number + '%';
        progressbtn.style.left = btn + '%';
        @endif
    </script>

    <script>

        new Chart(document.getElementById("pie-chart"), {
            type: 'pie',
            data: {
                labels: ["{{__('Active')}}", "{{__('Finish')}}"],
                datasets: [{
                    label: "{{__('This month points status')}}",
                    backgroundColor: ["#6FCF97", "#F2994A"],
                    data: [{{$points['active']}}, {{$points['finish']}}]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: "{{__('This month points status')}}",
                },
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                    }
                }
            }
        });
    </script>

    <script>
        new Chart(document.getElementById("doughnut-chart"), {
            type: 'doughnut',
            data: {
                labels: [
                    "{{__('Accepted')}}",
                    "{{__('Successful')}}",
                    "{{__('Created')}}",
                    "{{__('Delivering')}}",
                    "{{__('Assigned')}}",
                    "{{__('Declined')}}",
                    "{{__('Canceled')}}",
                    "{{__('Failed')}}",
                    "{{__('Postponed')}}"],
                datasets: [
                    {label: "{{__('This month orders status')}}",
                        backgroundColor:
                            [
                                "#2D9CDB",
                                "#a6e35f",
                                "#ffc784",
                                "#f95859e6",
                                "#4e8799",
                                "#7d5fa7",
                                "#c5c5c5",
                                "#ff2432",
                                "#853e15ba"
                            ],
                        data: [
                            {{$orders['accepted']}},
                            {{$orders['successful']}},
                            {{$orders['created']}},
                            {{$orders['delivering']}},
                            {{$orders['assigned']}},
                            {{$orders['declined']}},
                            {{$orders['canceled']}},
                            {{$orders['failed']}},
                            {{$orders['postponed']}}
                        ],

                    }
                ]
            },
            options: {
                title: {
                    display: true,
                    text: '{{__('This month orders status')}}'
                },
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                    }
                }
            }
        });
        // }

    </script>
    <script>
        new Chart(document.getElementById("doughnut-empty-chart"),
            {
                type: 'doughnut',
                data: {
                    labels: ["{{__('Empty')}}"],
                    datasets: [
                        {
                            label: "{{__('This month orders status')}}",
                            backgroundColor: ["#2D9CDB"],
                            data: [100],

                        }
                    ]
                },
                options: {
                    title: {
                        display: true,
                        text: '{{__('This month orders status')}}'
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                        }
                    }
                }
            });
    </script>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row flex-nowrap home-container">
            <div class="col-2 px-sm-2 px-0 bg-white sidebar-col d-flex">
                @include('auth.components.sidebar')
            </div>
            <div class="col-10 pt-3">
                <div class="w-100 align-items-end main-container  ">
                    <div class="row">
                        <div class="col-12 col-xl-8 d-flex justify-content-between flex-column ">

                            <div class="row flex-fill welcome-user mb-4 mx-1">
                                <img class="welcome-user-img " src="{{asset('/images/welcome-user.png')}}" alt="">
                                <h1>{{__('Welcome Back !')}} </h1>
                                <h5>{{__('Glad to have you back today, we hope you had a nice and bright day')}}</h5>
                                <h3 class="points is_number count" data-target="{{$points['all']}}">0</h3>
                                <div class="progress-container position-relative">
                                    <svg class="progress-btn position-absolute" width="56" height="29"
                                         viewBox="0 0 56 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.476562" y="0.977417" width="55.1575" height="27.5541" rx="13.777"
                                              fill="#00AAA3"/>
                                    </svg>
                                    <p class="position-absolute number is_number count" style=" color: white;
                                                font-size: 15px;" data-target="{{500 - $points['remain']}}">0
                                    </p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                                <span
                                    class="left-points mt-2 py-3">{{__('You have ')}}<span
                                        class="is_number count " data-target="{{$points['remain']}}">0</span> {{__(' points left to reach the level ')}} <span
                                        class="is_number count " data-target="{{$points['level'] + 1}}">0</span> </span>
                            </div>
                            <div class="row  d-flex justify-content-between">
                                <div class="col-12 col-lg-4  mb-2 mb-lg-0 points-card">
                                    <div class=" points-inner-card sent d-flex align-items-center h-100">
                                        <div class="container">
                                            <div class="row w-100">
                                                <div class="col-8">
                                                    <span>{{__('Used Points')}}</span>
                                                    <h3 class="is_number count" data-target="{{$points['used']}}">0</h3>
                                                </div>
                                                <div class="col-3 d-flex align-items-center justify-content-center">

                                                    <img class=" " src="{{asset('/images/points.png')}}" alt="">

                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4  mt-2 mt-md-0 points-card">
                                    <div class=" points-inner-card  sent d-flex align-items-center h-100  ">
                                        <div class="container">
                                            <div class="row w-100">
                                                <div class="col-8 ">
                                                    <span>{{__('Active Points')}}</span>
                                                    <h3 class="is_number count" data-target="{{$points['active']}}">
                                                        0</h3>
                                                </div>
                                                <div class="col-3 d-flex align-items-center justify-content-center">
                                                    <img class=" " src="{{asset('/images/points.png')}}" alt="">

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4  mt-2 mt-md-0 points-card">

                                    <div class=" points-inner-card  sent d-flex align-items-center all h-100">
                                        <div class="container">
                                            <div class="row w-100">
                                                <div class="col-8 ">
                                                    <span>{{__('Finish Points')}}</span>
                                                    <h3 class="is_number count" data-target="{{$points['finish']}}">
                                                        0</h3>
                                                </div>
                                                <div class="col-3 d-flex align-items-center justify-content-center">
                                                    <img class=" " src="{{asset('/images/points1.png')}}" alt="">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="col-12 col-xl-4   mt-3 mt-xl-0 ">
                            <div class="bg-white py-2 rounded-3 px-1 h-100 last-orders d-flex flex-column">
                                <div class="d-flex justify-content-between mt-2 mt-xl-0 p-2">
                                    <span class=" request-table-title"> {{__('Latest Requests')}}</span>
                                    <a class="link"
                                       href="/{{AppHelper::getSlug()}}/dashboard/orders"> {{__('View All')}}
                                    </a>
                                </div>


                                <div
                                    class="table-responsive d-flex justify-content-center  align-items-center p-2 flex-column flex-fill">
                                    @if(count(($orders['lastOrders']))>0)
                                        <table class="table">
                                            <thead>
                                            <tr>

                                                <th scope="col">{{__('Number')}}</th>
                                                <th scope="col">{{__('Weight')}}</th>
                                                <th scope="col">{{__('Status')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($orders['lastOrders'] as $order )
                                                <tr>
                                                    <td class="is_number count " data-target="{{$order->id}}">0</td>
                                                    <td class="is_number count " data-target="{{$order->weight}}">0</td>
                                                    <td class="is_number  buttons-in-tables">

                                                        @if($order->status == \App\Enums\OrderStatus::CREATED)
                                                            <span type="button"
                                                                  class="btn btn-sm  created ">{{__('Created')}}</span>
                                                        @elseif($order->status == \App\Enums\OrderStatus::ASSIGNED)
                                                            <span type="button"
                                                                  class="btn btn-sm assigned ">{{__('Assigned')}}</span>
                                                        @elseif($order->status == \App\Enums\OrderStatus::ACCEPTED)
                                                            <span type="button"
                                                                  class="btn btn-sm accepted ">{{__('Accepted')}}</span>
                                                        @elseif($order->status == \App\Enums\OrderStatus::DECLINE)
                                                            <span type="button"
                                                                  class="btn btn-sm decline ">{{__('Declined')}}</span>
                                                        @elseif($order->status == \App\Enums\OrderStatus::CANCEL)
                                                            <span type="button"
                                                                  class="btn btn-sm cancel ">{{__('Canceled')}}</span>
                                                        @elseif($order->status == \App\Enums\OrderStatus::DELIVERING)
                                                            <span type="button"
                                                                  class="btn btn-sm delivering ">{{__('Delivering')}}</span>
                                                        @elseif($order->status == \App\Enums\OrderStatus::FAILED)
                                                            <span type="button"
                                                                  class="btn btn-sm failed ">{{__('Failed')}}</span>
                                                        @elseif($order->status == \App\Enums\OrderStatus::SUCCESSFUL)
                                                            <span type="button"
                                                                  class="btn btn-sm successful ">{{__('Successful')}}</span>
                                                        @elseif($order->status == \App\Enums\OrderStatus::POSTPONED)
                                                            <span type="button"
                                                                  class="btn btn-sm postponed ">{{__('Postponed')}}</span>
                                                        @endif

                                                    </td>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @elseif(count(($orders['lastOrders']))==0)

                                        <div
                                            class="empty-order-box d-flex align-items-center justify-content-center gap-2 h-100 w-100 flex-column py-3 ">
                                            <h5 class=" text-muted">{{__('Oh Unfortunately')}}</h5>
                                            <h6 class="w-100  text-center text-muted">{{__('No orders available')}}</h6>
                                            <a href="/{{AppHelper::getSlug()}}/create-order"
                                               class="btn btn-primary sidebar-btn w-fit">
                                                {{__('Create New Order')}}
                                            </a>
                                        </div>

                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 row">
                        <div class="col-12   col-lg-6  mt-2 mt-lg-0">
                            <canvas class="chart-card" id="pie-chart"></canvas>
                            @if($points['all'] == 0)
                                <span
                                    class="mt-3 d-flex">{{__('You dont have orders yet! Save the environment and make order!')}}</span>
                            @endif
                        </div>
                        <div class="col-12  col-lg-6  mt-2 mt-lg-0">
                            @if($orders['total']==0)
                                <canvas class="chart-card" id="doughnut-empty-chart"></canvas>
                                <span
                                    class="mt-3 d-flex">{{__('You dont have orders yet! Save the environment and make order!')}}</span>
                            @else
                                <canvas class="chart-card" id="doughnut-chart"></canvas>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
