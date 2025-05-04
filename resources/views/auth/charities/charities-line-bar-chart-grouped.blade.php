@php
    use App\Helpers\AppHelper;
    $langCode = AppHelper::getLocationSettings()->language->code;
@endphp

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet"
          crossorigin="anonymous">
    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">
    <style>
        .selectdiv select {
            background: #FBFBFB;
            border: 1px solid #E0E0E0;
            border-radius: 5px !important;
        }

        .selectdiv:after {
            top: 6px !important;
        }
    </style>
    @if($langCode == 'ar')
        <style>
            .selectdiv:after {
                transform: rotate(87deg) !important;
                left: 11px;
                right: auto !important;
            }
        </style>
    @endif
</head>
<body class="bg-white">
<div class="container">
    <form method="GET" action="chart-bar" class="row">
        <div class="col-5">
            <div class="selectdiv w-100 position-relative py-2 py-sm-0 h-fit">

                <div class="py-0 w-100 flex">
                    <select onchange="this.form.submit()" id="select_id" name="months-select">
                        <option value="1">
                            @if($langCode == 'ar')
                                <h5>الشهر الحالي</h5>
                            @else
                                <h5>{{__('current month')}}</h5>
                            @endif

                        </option>
                        <option value="6">
                            @if($langCode == 'ar')
                                <h5>اخر ست اشهر</h5>
                            @else
                                <h5>{{__('last 6 months')}}</h5>
                            @endif

                        </option>
                        <option value="12">
                            @if($langCode == 'ar')
                                <h5>اخر سنة</h5>
                            @else
                                <h5>{{__('last year')}}</h5>
                            @endif
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-7 text-end">
            @if($langCode == 'ar')
                <h5>إحصائيات</h5>
            @else
                <h5>Reports</h5>
            @endif
{{--            <p class="text-muted is_number">Usage Yesterday, 24 June</p>--}}
        </div>
    </form>

</div>
<canvas class="chart-card w-100 " id="bar-chart-grouped"></canvas>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"
        integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha"
        crossorigin="anonymous"></script>
<script>

    orderSentences = 'Weight quantity of orders';
    containerSentences = 'Weight quantity of containers';
    totalWeightSentences = 'Total weights';
    @if($langCode == 'ar')
        totalWeightSentences = 'إحمالي الاوزان';
        containerSentences = 'إجمالي أوزان الحاويات';
        orderSentences = 'إجمالي أوزان الطلبات';
    @endif

    arrLabel = [];
    ordersWeight = [];
    containersWeight = [];
    totalWeight = [];
    @forEach($monthsName as $month)
    arrLabel.push("{{$month}}")
    @endforeach
    @forEach($orders as $order)
    ordersWeight.push("{{$order}}")
    @endforeach

    @forEach($containers as $container)
    containersWeight.push("{{$container}}")
    @endforeach

    @forEach($total as $totalWeight)
    totalWeight.push("{{$totalWeight}}")
    @endforeach

    new Chart(document.getElementById("bar-chart-grouped"), {
        type: 'bar',
        data: {
            labels: arrLabel,
            datasets: [
                {
                    label: orderSentences,
                    backgroundColor: "#73E19C",
                    data: ordersWeight
                },
                {
                    label: containerSentences,
                    backgroundColor: "#FF7EBE",
                    data: containersWeight
                },

                {
                    label: totalWeightSentences,
                    backgroundColor: "#79D5FF",
                    data: totalWeight
                }
            ]
        },
        options: {
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    margin: 100,
                    // margin: "10px",
                },
                ltr: true,
            }
        }
    });
</script>


<script>
    if (window.location.href.includes('?months-select=1'))
        document.getElementById("select_id").value = "1";
    if (window.location.href.includes('?months-select=6'))
        document.getElementById("select_id").value = "6";
    if (window.location.href.includes('?months-select=12'))
        document.getElementById("select_id").value = "12";
</script>
</body>
</html>






