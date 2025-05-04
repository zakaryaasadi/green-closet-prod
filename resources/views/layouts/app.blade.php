@php
    use App\Helpers\AppHelper;use App\Models\Setting;
    use App\Models\LocationSettings;
    $allLocationSettings = LocationSettings::all();
    $locationSetting = AppHelper::getLocationSettings();
    $settings=Setting::where(['country_id' => $locationSetting->country_id])->first()??Setting::where(['country_id' => null])->first();
    $site_name = 'Kiswa';
    if ($locationSetting->language->code == 'ar'){
        $title = $settings?->header_title_arabic;
        $site_name = 'جرين كلوزيت';
    }
    else
        $title = $settings?->header_title;
    $section = AppHelper::getSection();
    $metaDescription = '';
    $page = \App\Models\Page::where(['country_id' => $locationSetting->country_id, 'language_id' => $locationSetting->language_id, 'slug' => $section])->first();
    if ($page != null) {
            if ($page->meta_tags != null) {
                if (array_key_exists('seo_title', $page->meta_tags))
                    $title = $title . ' - ' . $page->meta_tags['seo_title'];
                if (array_key_exists('meta_description', $page->meta_tags))
                    $metaDescription = $page->meta_tags['meta_description'];
            }
            $custom_scripts = $page->custom_scripts;
    }
@endphp
<title>@yield('seo_title', $title)</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="facebook-domain-verification" content="iukt5x8oekmukrpw81mes2m4jmzrjq"/>
<meta name="description" content="@yield('meta_description', $metaDescription)">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" href="{{$settings?->favicon??url('images/favicon.png') }}" type="image/x-icon"/>

<!-- Open Graph -->
<meta property="og:site_name" content="{{$site_name}}" />
<meta property="og:title" content="@yield('seo_title', $title)">
<meta property="og:description" content="@yield('meta_description', $metaDescription)">
<meta property="og:url" content="{{secure_url(request()->path())}}">
<link rel="canonical" href="{{secure_url(request()->path())}}" />
<meta property="og:type" content="website">
<meta property="og:image" content="{{$settings?->favicon??url('images/favicon.png') }}">
<meta property="og:image:width" content="180" />
<meta property="og:image:height" content="180" />
<meta property="og:image:type" content="image/png" />
<meta name="robots" content="follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large" />
<meta property="og:image:alt" content="@yield('seo_title', $title)" />
<meta property="og:locale" content="{{$locationSetting->slug}}">

<!-- ALT links -->
@foreach ($allLocationSettings as $item)
    @php
        $path = $item->slug;
        if ($page != null) {
            $path = $path . '/' . $page->slug;
        }
    @endphp
    <link rel="alternate" hreflang="{{$item->slug}}" href="{{ secure_url($path) }}" />
@endforeach



<!-- main style -->
<link rel="stylesheet" href="{{ mix('css/main.css') }}">


{!! $custom_scripts??' ' !!}
{!! AppHelper::getLocationSettings()->scripts['header'] !!}
<!-- Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
<!-- cdn Styles -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet"
      crossorigin="anonymous">

<!-- bootstrap-icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.0/font/bootstrap-icons.css">
<!-- AOS style  -->
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>
<!-- swiper style  -->
<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css"/>


@stack('styles')

@include('include/scripts')
<!-- JavaScript Bundle with Popper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0-beta1/js/bootstrap.bundle.min.js"

        crossorigin="anonymous"></script>


{{--<!-- AOS script -->--}}
{{--    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"

        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- swiper  -->

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"

        crossorigin="anonymous" referrerpolicy="no-referrer"></script>







