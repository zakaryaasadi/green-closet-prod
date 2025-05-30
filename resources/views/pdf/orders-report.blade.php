<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Title</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"

          crossorigin="anonymous" referrerpolicy="no-referrer"/>


    <style>
        .created {
            background-color: #ffc784;
            color: #876b4a;
        }

        .successful {
            background-color: #a6e35f;
            color: #ffff;
        }


        .accepted {
            background-color: #2D9CDB;
            color: #fff;
        }

        .decline {
            background-color: #7d5fa7;
            color: #fff;
        }

        .cancel {
            background-color: #c5c5c5;
            color: #fff;
        }

        .failed {
            background-color: #ff2432;
            color: #fff;
        }


        .assigned {
            background-color: #4e8799;
            color: #fff;

        }

        .delivering {
            background-color: #f95859e6;
            color: #fff;
        }

        .order-status {
            overflow: hidden;
        }

        .order-status span {
            width: 100%;
            padding: .1cm 0px;
            display: block;
            text-align: center;


        }

        thead {
            width: 100%;
        }

        tr.head {
            background-color: #008451;
            color: #fff;
            font-weight: lighter;
        }

        table td {
            min-width: .5cm;

        }

        table, th, td {
            border: .01cm solid #2f2d2d;
            border-collapse: collapse;
        }

        body {
            margin: .1cm auto;
            font-family: "Segoe UI";
        }

        .bg-primary {
            background-color: #008451;
            color: #fff;
        }

        .header {
            text-align: center;
            padding-bottom: 1cm;
        }

        .bg-dark {
            background-color: #2f2d2d;
            color: #fff;
        }

        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
    </style>

    <style>
        * {
            font-family: DejaVu Sans, sans-serif;
        }
    </style>


</head>
<body>
<div class="header">

    <img
        src="data:image/png;base64,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"
        alt="logo">
    @if($lang == 'ar')
        <h1>تقرير الطلبات</h1>
    @else
        <h1>Orders Report</h1>
    @endif
</div>

<table style="width: 100%; text-align: center; ">
    <tbody>
    @if($lang == 'ar')
        <tr class="head bg-primary">
            <th>الرمز</th>
            <th>البلد</th>
            <th>المستخدم</th>
            <th>العنوان</th>
            <th>العميل</th>
            <th>الجمعية</th>
            <th>الحالة</th>
            <th>النوع</th>
            <th>الوزن</th>
            <th>القيمة</th>
            <th>الوقت الكلي</th>
            <th>بداية المهمة</th>
            <th>نهاية المهمة</th>
            <th>المنصة</th>
            <th>حالة الدفع</th>
            <th>وقت الانشاء</th>
        </tr>
    @else
        <tr class="head bg-primary">
            <th>ID</th>
            <th>country</th>
            <th>customer</th>
            <th>address</th>
            <th>agent</th>
            <th>association</th>
            <th>status</th>
            <th>type</th>
            <th>weight</th>
            <th>value</th>
            <th>total time</th>
            <th>start at</th>
            <th>ends at</th>
            <th>platform</th>
            <th>payment status</th>
            <th>created at</th>
        </tr>
    @endif
    @foreach($orders as $order)
        @if($lang == 'ar')
            <tr>
                <td class="bg-primary">{{$order->id}}</td>
                <td>{{$order->country->meta['translate']['name_ar']??"-----"}}</td>
                <td>{{$order->customer?->name??'-----'}}</td>
                <td>
                    <a href=https://www.google.com/maps/{{"@".$order->location->getLat()}},{{$order->location->getLng()}},128m/data=!3m1!1e3
                       class="text-muted text-decoration-none" target="_blank">
                        {{$order->address->location_province??"Order Location"}}
                    </a>
                </td>
                <td>{{$order->agent?->name??''}}</td>
                <td>{{$order->association?->meta['translate']['title_ar']??"شركة جرين كلوزيت"}}</td>
                <td class="order-status">
                    @if($order->status == '1')
                        <span type="button"
                              class="btn btn-sm  created ">تم الانشاء</span>
                    @elseif($order->status == '2')
                        <span type="button"
                              class="btn btn-sm assigned ">مسند</span>
                    @elseif($order->status == '3')
                        <span type="button"
                              class="btn btn-sm accepted ">مقبول</span>
                    @elseif($order->status == '4')
                        <span type="button"
                              class="btn btn-sm decline ">مرفوض</span>
                    @elseif($order->status == '5')
                        <span type="button"
                              class="btn btn-sm cancel ">ملغي</span>
                    @elseif($order->status == '6')
                        <span type="button"
                              class="btn btn-sm delivering ">جاري توصيله</span>
                    @elseif($order->status == '7')
                        <span type="button"
                              class="btn btn-sm failed ">فشل</span>
                    @elseif($order->status == '8')
                        <span type="button"
                              class="btn btn-sm successful ">ناجح</span>
                    @endif

                </td>
                <td>
                    @if($order->type == '1')
                        تبرع
                    @elseif($order->type == '2')
                        اعادة تدوير
                    @endif
                </td>
                <td>{{$order->weight??"-----"}}</td>
                <td>{{$order->value??"-----"}}</td>
                <td>{{$order->total_time??"-----"}}</td>
                <td>{{$order->start_at??"-----"}}</td>
                <td>{{$order->ends_at??"-----"}}</td>
                <td>
                    @if($order->platform == '1')
                        موبايل
                    @elseif($order->platform == '2')
                        الموقع
                    @elseif($order->platform == '3')
                        مكالمة
                    @endif
                </td>
                <td>
                    @if($order->payment_status)
                        @if($order->payment_status == '1')
                            غير مدفوع
                        @elseif($order->payment_status == '2')
                            مدفوع
                        @endif
                    @else
                        -----
                    @endif

                </td>
                <td>{{$order->created_at}}</td>
            </tr>

        @else
            <tr>
                <td class="bg-primary">{{$order->id}}</td>
                <td>{{$order->country->meta['translate']['name_en']??"-----"}}</td>
                <td>{{$order->customer?->name??'-----'}}</td>
                <td>
                    <a href=https://www.google.com/maps/{{"@".$order->location->getLat()}},{{$order->location->getLng()}},128m/data=!3m1!1e3
                       class="text-muted text-decoration-none" target="_blank">
                        {{$order->address->location_province??"Order Location"}}
                    </a>
                </td>
                <td>{{$order->agent?->name??''}}</td>
                <td>{{$order->association?->meta['translate']['title_en']??"Green Closet Company"}}</td>
                <td class="order-status">
                    @if($order->status == '1')
                        <span type="button"
                              class="btn btn-sm  created ">Created</span>
                    @elseif($order->status == '2')
                        <span type="button"
                              class="btn btn-sm assigned ">Assigned</span>
                    @elseif($order->status == '3')
                        <span type="button"
                              class="btn btn-sm accepted ">Accepted</span>
                    @elseif($order->status == '4')
                        <span type="button"
                              class="btn btn-sm decline ">Declined</span>
                    @elseif($order->status == '5')
                        <span type="button"
                              class="btn btn-sm cancel ">Canceled</span>
                    @elseif($order->status == '6')
                        <span type="button"
                              class="btn btn-sm delivering ">Delivering</span>
                    @elseif($order->status == '7')
                        <span type="button"
                              class="btn btn-sm failed ">Failed</span>
                    @elseif($order->status == '8')
                        <span type="button"
                              class="btn btn-sm successful ">Successful</span>
                    @endif


                </td>
                <td>
                    @if($order->type == '1')
                        Donation
                    @elseif($order->type == '2')
                        Recycling
                    @endif
                </td>
                <td>{{$order->weight??"-----"}}</td>
                <td>{{$order->value??"-----"}}</td>
                <td>{{$order->total_time??"-----"}}</td>
                <td>{{$order->start_at??"-----"}}</td>
                <td>{{$order->ends_at??"-----"}}</td>
                <td>{{$order->platform??"-----"}}</td>
                <td>
                    @if($order->payment_status)
                        @if($order->payment_status == '1')
                            Unpaid
                        @elseif($order->payment_status == '2')
                            Paid
                        @endif
                    @else
                        -----
                    @endif

                </td>
                <td>{{$order->created_at}}</td>
            </tr>
        @endif
    @endforeach
    </tbody>

</table>
</body>
</html>
