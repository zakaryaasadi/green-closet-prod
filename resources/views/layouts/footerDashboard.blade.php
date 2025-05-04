@stack('scripts')
<footer class="footer-dashboard w-100 mt-0  text-black h-fit py-3">
    <div class="container ">
        <div class="mt-4 mb-4" style="height: 1px; background-color: #828282;"></div>
        <div class="row justify-content-around justify-content-xl-between">

            @foreach($locationSettings['footer']['links'] as $key => $link)
                <div
                    class="col-12  col-xl-2 py-3  h-100 d-flex flex-wrap flex-column align-items-center align-items-xl-start justify-content-center">
                    <p class=" text-center w-100 ">
                        <a   href="{{$link["link"]}}" class="text-decoration-none footer-imgs is_number">
                            {{$link['title']}}
                        </a>
                    </p>
                </div>
            @endforeach

                <div
                    class="col-12 col-xl-3 py-5 py-xl-0 col-xl-2 h-100 d-flex flex-wrap align-items-center align-items-xl-start justify-content-center">
                    @foreach($locationSettings['footer']['contact_us'] as  $contact)
                        <a href="{{$contact['link']}}"
                           target="_blank"
                           class="text-decoration-none  pt-3  px-2">
                    <span>
                   <img src='{{$contact['icon']}}' alt="" class="img-fluid footer-imgs">
                    </span>
                            <span class="footer-imgs is_number contact px-2">{{$contact['number']}}</span>
                        </a>
                    @endforeach
                </div>
            <div
                class="col-12 col-xl-2 py-3 py-xl-0 col-xl-2 h-100 d-flex flex-wrap flex-column align-items-center align-items-xl-start justify-content-center  social-media-section">
                <div
                    class="social--box-icon d-flex align-items-center justify-content-around   mt-3 ">
                    @foreach($locationSettings['footer']['follow_us'] as $social)
                        <a href="{{$social['url']}}" target="_blank" class="px-4 px-lg-2">
                            <img  src="{{$social['icon']}}" alt=" " class="img-fluid footer-imgs">
                        </a>
                    @endforeach
                </div>
            </div>
            <div
                class="col-12  col-xl-1 py-5 py-xl-0 col-xl-2 h-100 d-flex flex-wrap flex-column align-items-center align-items-xl-start justify-content-center">
                <a href="/{{\App\Helpers\AppHelper::getSlug()}}" class="d-flex align-items-center justify-content-center w-100">
                    <img class="footer-imgs" src="{{$locationSettings['footer']['logo']}}" alt="">
                </a>
            </div>
        </div>
    </div>
</footer>
