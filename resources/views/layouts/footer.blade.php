@php
    use App\Helpers\AppHelper;
    $floatButton=null;
    $buttons=[];
    if(AppHelper::getLocationSettings()->structure['footer']['has_float_button']??false){
        $floatButton=AppHelper::getLocationSettings()->structure['footer']['float_button']??null;
        if($floatButton!=null){
            $buttons=$floatButton['buttons']??[];
        }
    }

@endphp

@stack('scripts')
<footer class="w-100 mt-0 main main-footer ">
    <div class="container h-100">
        <div class="row justify-content-around justify-content-xl-between h-100">
            <div
                class="col-12 py-3 py-xl-0 col-xl-2 h-100 d-flex flex-wrap flex-column align-items-center align-items-xl-start justify-content-center  social-media-section">
                <h4 class="text-white font-Poppins ">{{__('Follow us')}}</h4>
                <div
                    class="social--box-icon d-flex align-items-center justify-content-around   mt-3 ">
                    @foreach($locationSettings['footer']['follow_us'] as $social)
                        <a href="{{$social['target']=="_blank" ? $social["url"] : "/".AppHelper::getSlug().$social["url"]}}"
                           target="{{$social['target']}}" class="px-4 px-lg-2">
                            <img loading="lazy" data-src="{{$social['icon']}}" alt=" " class="img-fluid social-icon ">
                        </a>
                    @endforeach
                </div>
            </div>
            <div
                class="col-12 py-5 py-xl-0 col-xl-3 h-100 d-flex flex-wrap flex-column align-items-center  justify-content-center">
                @foreach($locationSettings['footer']['contact_us'] as  $contact)
                    <a href="{{$contact['target']=="_blank" ? $contact["link"] : "/".AppHelper::getSlug().$contact["link"]}}"
                       target="{{$contact['target']}}"
                       class="text-decoration-none text-white pt-3 dir-ltr  ">
                    <span>
                   <img loading="lazy" data-src='{{$contact['icon']}}' alt="" class="img-fluid">
                    </span>
                        <span class="number is_number">{{$contact['number']}}</span>
                    </a>
                @endforeach
            </div>
            @foreach($locationSettings['footer']['links'] as $key => $link)
                <div
                    class="col-12 col-xl-3 py-2 py-xl-0 h-100 d-flex flex-wrap flex-column align-items-center align-items-xl-start justify-content-center">
                    <p class="text-white text-center w-100 ">
                        <a href="{{$link['target']=="_blank" ? $link["link"] : "/".AppHelper::getSlug().$link["link"]}}" target="{{$link['target']}}"
                           class="text-decoration-none text-white    ">
                            {{$link['title']}}
                        </a>
                    </p>
                </div>
            @endforeach
            <div
                class="col-12 py-5 py-xl-0 col-xl-1 h-100 d-flex flex-wrap flex-column align-items-center align-items-xl-start justify-content-center">
                <a href="/{{AppHelper::getSlug()}}/" class="d-flex align-items-center justify-content-center w-100">
                    <img loading="lazy" data-src="{{$locationSettings['footer']['logo']}}" alt="" class="footer-logo">
                </a>
            </div>
        </div>
    </div>
    {!! AppHelper::getLocationSettings()->scripts['footer'] !!}
</footer>
@if(AppHelper::getLocationSettings()->structure['footer']['has_float_button']??false)
    @if($floatButton!=null)
        <div class="floating-container">
            @if(!empty($buttons))
                <div class="floating-button" style="background-color:{{$floatButton['color']??'#198754'}}">
                    <img loading="lazy" data-src='{{$floatButton['image']??''}}'
                         alt="" class="img-fluid w-50">
                </div>
            @else
                <a target="_blank" href="{{$floatButton['link']??''}}">
                    <div class="floating-button" style="background-color:{{$floatButton['color']??'#198754'}}">
                        <img loading="lazy" data-src='{{$floatButton['image']??''}}'
                             alt="" class="img-fluid w-50">
                    </div>
                </a>
            @endif
            <div class="element-container text-center">
                @foreach($buttons as $button)
                    <a target="_blank" href="{{$button['link']??''}}">
                <span style="background-color:{{$button['color']??'#198754'}}" class="float-element tooltip-left">
                <img loading="lazy" data-src='{{$button['image']??''}}' alt="" class="img-fluid w-50"></span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
@endif


