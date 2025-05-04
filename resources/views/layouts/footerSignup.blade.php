@stack('scripts')
<footer style="background-color: #EEFBFF;" class="w-100 mt-0  text-black h-fit py-4 main-footer">
    <div class="container ">
        <div class="row justify-content-around justify-content-xl-between ">
            <div
                class="col-12  py-5 py-xl-0  h-100 d-flex flex-wrap align-items-center align-items-xl-start justify-content-center">
                @foreach($locationSettings['footer']['contact_us'] as  $contact)
                    <a href="{{$contact['link']}}"
                       target="_blank"
                       class="text-decoration-none  pt-3  px-5 mx-5">
                    <span>
                   <img loading="lazy"  data-src='{{$contact['icon']}}' alt="" class="img-fluid footer-imgs">
                    </span>
                        <span class="number footer-imgs is_number">{{$contact['number']}}</span>
                    </a>
                @endforeach
            </div>


        </div>
    </div>
</footer>
