@php
    use App\Helpers\AppHelper;
    use App\Models\Setting;
    $locationSetting = AppHelper::getLocationSettings();
    $settings=Setting::where(['country_id' => $locationSetting->country_id])->first()??Setting::where(['country_id' => null])->first();
    if ($locationSetting->language->code == 'ar')
        $title = $settings?->header_title_arabic;
    else
        $title = $settings?->header_title;

@endphp
<title>{{ $title }}</title>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1">
{{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}
<link rel="icon" href="{{$settings?->favicon??url('images/favicon.png') }}" type="image/x-icon"/>
{{--main style--}}

<link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">


<!-- cdn Styles -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">


<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet"
      crossorigin="anonymous">
<!-- bootstrap-icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.0/font/bootstrap-icons.css">
<!-- swiper style  -->
<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css"/>

@stack('styles')
<!-- JavaScript Bundle with Popper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0-beta1/js/bootstrap.bundle.min.js"

        crossorigin="anonymous"></script>


<!-- swiper  -->
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"

        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
        crossorigin="anonymous"></script>








