<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{$invoice->id}}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"

          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet"
          crossorigin="anonymous">


    <style>
        p {
            margin: 0;
            padding: 0;
        }

        .table-head {
            background: rgb(11, 161, 208);
            color: #fff;
        }

        .table-head td,
        .table-head span {
            color: #fff;
        }

        body {
            background: rgb(255, 255, 255);
            background: linear-gradient(-90deg, rgba(255, 255, 255, 1) 82%, rgba(236, 236, 236, 0.62) 100%, rgba(255, 255, 255, 1) 100%);

        }

        .block {
            display: inline-block;
        }

        .w-100 {
            width: 100%;
        }

        .bg-black {
            background-color: rgb(11, 161, 208);
            color: #fff;
        }

        .bg-black td,
        .bg-black td span {
            color: #fff;
        }

        .main-table,
        .main-table *:not(span) {
            border: 1px solid rgb(11, 161, 208) !important;
            border-collapse: collapse;
        }

        .main-table tr,
        .main-table tr td {
            border: 1px solid rgb(11, 161, 208) !important;

        }


        .footer {
            width: 100%;
            height: 1.5cm;
            background-color: rgb(11, 161, 208);
            position: absolute;
            bottom: 0;
            left: 0;
            border-radius: 100px 100px 0 0;
        }

    </style>
</head>
<body>
<div class="fw-bold" style="display: flex    ; align-items: center; justify-content: space-between;width: 100% ">


    <div style="float: left ;width: 30%">
        <img
            src="data:image/png;base64,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"
            alt="logo" width="114" height="39">
    </div>
    <div class="" style="float: right;width: 70%; text-align: right">
        <p style="margin: 0; padding: 0">Kiswa Operating and Recycling</p>
        <p style="margin: 0; padding: 0">جرين كلوزيت للتشغيل والتدوير ش.ذ.م.م</p>
        <p style="margin-top: 1cm">{{$address}}</p>
    </div>


</div>
<hr>
<table class="table-content" style="width: 100%; margin-top: .1cm;">

    <tbody>

    <tr class="table-head" style=" ">
        <td style="padding: .2cm;font-weight: bold;">Donation Receipt</td>
        <td style="padding: .2cm;font-weight: bold"></td>
        <td style="padding: .2cm;font-weight: bold"></td>
        <td style="text-align: right ;padding: .2cm;font-weight: bold;">الإيصال تبرع</td>
    </tr>

    <tr style="  ">
        <td style="padding: .2cm;">
            <span>Order No : </span> <span>{{$order->id}}</span>
        </td>
        <td style="padding: .2cm;text-align: start">
        </td>
        <td style="padding: .2cm">
        </td>
        <td style="text-align: right ;padding: .2cm;">رقم الطلب</td>
    </tr>
    <tr style="  ">
        <td style="padding: .2cm;">
            <span>Receipt No :</span> <span>{{$invoice->id}}</span>

        </td>
        <td style="padding: .2cm;text-align: start">

        </td>
        <td style="padding: .2cm">

        </td>
        <td style="text-align: right ;padding: .2cm;">رقم الإيصال</td>
    </tr>
    <tr style="  ">
        <td style="padding: .2cm;">
            <span>Receipt Date :</span> <span>{{$invoice->created_at}}</span>
        </td>
        <td style="padding: .2cm;text-align: start">

        </td>
        <td style="padding: .2cm">

        </td>
        <td style="text-align: right ;padding: .2cm;">التاريخ</td>
    </tr>
    <tr style="  ">
        <td style="padding: .2cm;">
            <span>Ex. Del. Date : </span> <span>{{$order->ends_at}}</span>

        </td>
        <td style="padding: .2cm;text-align: start">

        </td>
        <td style="padding: .2cm">
        </td>
        <td style="text-align: right ;padding: .2cm;"> تاريخ التسليم</td>
    </tr>
    <tr class="table-head" style="margin-top: 0cm ">
        <td style="padding: .2cm;padding-bottom: 0;font-weight: bold;">DONOR INFORMATION</td>
        <td style="padding: .2cm;padding-top: 0;font-weight: bold"></td>
        <td style="padding: .2cm;padding-top: 0;font-weight: bold;"></td>
        <td style="text-align: right ;padding: .2cm;padding-bottom: 0;font-weight: bold">
            <p style="">: AGENT NAME </p>
            <p style="text-align: right"> : اسم المندوب </p>
        </td>
    </tr>
    <tr class="table-head" style="margin-top: 0cm;padding-top: 0 ">
        <td style="padding: .2cm;padding-top: 0;font-weight: bold;">معلومات المتبرع</td>
        <td style="padding: .2cm;padding-top: 0;font-weight: bold"></td>
        <td style="padding: .2cm;padding-top: 0;font-weight: bold;"></td>
        <td style="padding-right: .2cm;font-weight: bold;text-align: right;color: #fff">
            {{$order->agent?->name ?? ''}}
        </td>
    </tr>

    <tr>
        <td style="padding: .2cm; text-align: start" class="border-s-1">
            <span style="font-weight: bold;display: inline-block;float: left">Name :</span>
            <span style=" display: inline-block;float: right">{{$order->customer?->name ??" "}}</span>

        </td>
    </tr>


    <tr>
        <td style="padding: .2cm; text-align: start" class="border-s-1">
            <span style="font-weight: bold;display: inline-block;float: left">Phone No : </span>
            <span style=" display: inline-block;float: right">{{$order->customer?->phone ??" "}}</span>
        </td>
    </tr>
    <tr>
        <td style="padding: .2cm; text-align: start" class="border-s-1">
            <span style="width:50%;font-weight: bold;display: inline-block;float: left">Apartment :</span>
            <span style="width: 50%; display: inline-block;float: right">
                {{$order->address?->location_province ?? " "}}
            </span>
        </td>
    </tr>

    </tbody>
</table>


<table class="main-table" style="margin-top: .5cm;width: 100%">
    <tr class="bg-black">

        <td style="padding: .2cm">

            <span class="block w-100 fl- " style="text-align: start;float: left">Description </span>
            <br>
            <span
                class="block w-100 fl- " style="text-align: start;float: left">وصف</span>
        </td>
        <td style="padding: .2cm">

            <span class="block w-100 fl- " style="text-align: start;float: left">Weight/kg</span>
            <br>
            <span class="block w-100 fl- " style="text-align: start;float: left">الوزن</span>

        </td>
    </tr>


    @foreach($order->items as $item)
        @if($item->pivot->weight>0)
            <tr>
                <td style="padding: .2cm">
                    <span class="block w-100 fl- "
                          style="text-align: start;float: left">{{ $item->meta['translate']['title_en']}} </span>
                    <br>
                    <span class="block w-100 fl- "
                          style="text-align: start;float: left">{{ $item->meta['translate']['title_ar']}}</span>
                </td>
                <td style="padding: .2cm">{{$item->pivot->weight}} Kg
                </td>
            </tr>
        @endif
    @endforeach
</table>

<div class="footer"></div>
</body>
</html>

