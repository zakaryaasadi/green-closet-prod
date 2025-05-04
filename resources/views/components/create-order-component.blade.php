@php
    use App\Helpers\AppHelper;
    use App\Models\Setting;

    $countryId =AppHelper::getLocationSettings()->country->id;
    $getSetting = Setting::where( ['country_id' => $countryId])->get()->first();

@endphp

@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/create-order-component.css')}}">
    @if(App::getLocale() == 'en')
        <style>
            #create-order-component .box-pagination {
                flex-direction: row-reverse !important;
                justify-content: flex-end;
            }

        </style>

    @else
        <style>
            #create-order-component .card .box-pagination {
                flex-direction: row-reverse !important;
            }
        </style>
    @endif

    <style>
    </style>
@endPushOnce



<section class="  pt-0 py-lg-0 w-100  position-relative d-flex align-items-end justify-content-end"
         id="create-order-component">
    <div class=" w-100 h-100 d-flex align-items-center justify-content-center position-absolute start-0 end-0 top-0 ">
        <div class="container">
            <div class="row justify-content-between position-relative">

                <div class="col-12 col-lg-6 col-xl-4">
                </div>
                <div class="col-12 col-lg-6 col-xl-5 col-xxl-4 card-create-order">

                    <div class="card  w-100 p-3 pt-3 pt-lg-2 d-flex flex-column position-relative" data-aos="fade-down"
                         style="overflow-x: hidden">
                        <div class=" d-flex align-items-center justify-content-center p-3 w-100 py-0" style="
                    z-index: 11;
                    position: absolute;
                    top: 0;
                    left: 50%;
                    transform: translateX(-50%);
                    ">
                            <div id="liveToastErrorCreateOrder" class="toast w-100" role="alert" aria-live="assertive"
                                 aria-atomic="true">
                                <div class="toast-header ">
                                    <div class="row w-100">
                                        <strong class="col-11">{{__('Create Order')}}</strong>
                                        <button type="button" class="btn-close col-1" data-bs-dismiss="toast"
                                                aria-label="Close"></button>
                                    </div>
                                </div>
                                <div class="toast-body">

                                </div>
                            </div>
                        </div>
                        <div
                            class="redirectMessage-1  w-100 pt-0 h-100  d-flex align-items-center justify-content-evenly
                        flex-column overflow-hidden d-none   position-absolute start-0 top-0 bg-white"
                            style="z-index: 9;border-radius: 15px;">
                            <img src="https://kiswame.com/images/logo.png" alt="logo" class="img-fluid "/>
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor"
                                     class="bi bi-check2-circle display-1 text-success" viewBox="0 0 16 16">
                                    <path class="layer1"
                                          d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                                    <path class="layer2"
                                          d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                                </svg>


                                <p class="fs-5 mt-2 text-  text-center " id="message-create-order-done">

                                </p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="wave">
                                <path fill="#0099ff" fill-opacity="1"
                                      d="M0,192L34.3,165.3C68.6,139,137,85,206,64C274.3,43,343,53,411,85.3C480,117,549,171,617,165.3C685.7,160,754,96,823,90.7C891.4,85,960,139,1029,160C1097.1,181,1166,171,1234,149.3C1302.9,128,1371,96,1406,80L1440,64L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                            </svg>
                        </div>
{{--                        <div class="permission-element d-none d-lg-flex" style="z-index: 9 ">--}}
{{--                            <div--}}
{{--                                class="permission-container start-0 w-100 h-100 position-absolute top-0 start-0 bg-white d-flex align-items-center justify-content-center">--}}
{{--                                <div class="container">--}}
{{--                                    <div class="row justify-content-center">--}}
{{--                                        <div class="col-12 ">--}}
{{--                                            <div class=" py-1 px-2 border-0"--}}
{{--                                                 style="  box-shadow: 0px 11px 33px 5px #e7f6fac4;">--}}
{{--                                                <div class="card-body text-center">--}}
{{--                                                    <h5 class="card-title pb-2"> {{__('Allow the use of geolocation information To proceed to the next step')}}</h5>--}}


{{--                                                    <a type="button"--}}
{{--                                                       class="get-location-user-button btn-primary btn w-100 py-3 my-2">--}}
{{--                                                        {{__('allow')}}--}}
{{--                                                    </a>--}}
{{--                                                    <a type="button" class="text-primary get-location-should-permission"--}}
{{--                                                       onclick="deleteElement()">--}}
{{--                                                        {{__('Disallow and cancel the operation')}}--}}
{{--                                                    </a>--}}

{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}

                        <div class="w-100 position-relative swiper-card-create-order-component">
                            <div class="swiper overflow-visible mySwiper-in-create-order-component-tab-content w-100"
                                 id=" ">
                                <div class="swiper-wrapper align-items-center h-100">
                                    <div
                                        class="swiper-slide align-items-start d-flex flex-column  bg-white h-100   px-0 px-md-3"
                                        id="pills-create-order-info"
                                        role="tabpanel"
                                        aria-labelledby="pills-create-order-info-tab"
                                        tabindex="0">
                                        <h2 class="log-title mb-2  ">{{__('Create Order')}}</h2>
                                        <h4 class="log-title fw-light mb-4  " style="opacity: .6">{{__('Personal Info')}}</h4>

                                        <div class="w-100 form-box d-flex flex-column ">
                                            <form class=" flex-fill d-flex flex-column justify-content-evenly"
                                                  method="POST"
                                                  action="">

                                                @csrf
                                                <div class="form-item my-2 d-flex flex-column align-items-start">
                                                    <input id="username" type="text" class="register-field    form-control py-3
                                   @error('username') is-invalid @enderror"
                                                           name="name" value="{{ old('name') }}" required
                                                           autocomplete="name"
                                                           placeholder="{{__('Name')}}"
                                                    >
                                                    @error('username')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="form-item my-2 d-flex flex-column align-items-start">
                                                    <div class="input-group dir-ltr  ">
                                                        <button
                                                            class="btn btn-outline-dark code-phone-btn dropdown-toggle border-0 d-flex align-items-center justify-content-center gap-1"
                                                            type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <div class="dir-ltr">
                                                                <span><img src="{{$flags[0]}}" alt=""
                                                                           class="flag-icon code-country-flag"></span>
                                                                <span
                                                                    class="dir-ltr code-country-text">{{$codes[0]}}</span>
                                                            </div>

                                                        </button>
                                                        <input id="phone" type="tel"
                                                               class=" dir-ltr phone-input    number is_number text-dark form-control py-3 @error('phone') is-invalid @enderror"
                                                               value="" required autocomplete="phone"
                                                               placeholder="{{__('Phone')}}"
                                                               aria-label="Text input with dropdown button"
                                                        >
                                                        <ul class="dropdown-menu">
                                                            @foreach($flags as  $flag )
                                                                <li>
                                                                    <a class="dropdown-item dir-ltr item-code" href="#"
                                                                       data-country-flag="{{$flags[$loop->index]}}"
                                                                       data-country-code="{{$codes[$loop->index]}}"
                                                                    >
                                                                        <span class=" pe-none">
                                                                            <img src="{{$flags[$loop->index]}}" alt=""
                                                                                 class="flag-icon  ">
                                                                        </span>
                                                                        <span class="dir-ltr pe-none">
                                                                            {{$codes[$loop->index]}}
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                            @endforeach

                                                        </ul>

                                                    </div>

                                                    <div class=""><input id="phoneHidden" type="hidden" name="phone"
                                                                         class="field-login-hidden">
                                                    </div>
                                                    @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                @if($errors->any())
                                                    <div class="error-container mt-4">
                                                        {{ implode('', $errors->all(':message')) }}
                                                    </div>
                                                @endif
                                            </form>
                                        </div>


                                    </div>
                                    <div
                                        class="swiper-slide align-items-start d-flex flex-column   bg-white  h-100  px-0 px-md-3"
                                        id="pills-create-order-address"
                                        role="tabpanel"
                                        aria-labelledby="pills-create-order-address-tab"
                                        tabindex="0">
                                        <h4 class="log-title mb-4">{{__('Address information')}}</h4>
                                        <div class="w-100 form-box d-flex flex-column ">
                                            <form class="row w-100 flex-fill w-100 mx-0 " method="POST"
                                                  action="">
                                                @csrf
                                                <input type="hidden" name="lng" id="lng" value="null">
                                                <input type="hidden" name="lat" id="lat" value="null">
                                                <div
                                                    class="mb-3 col-12 p-0 px-1  justify-content-between d-flex flex-column">
                                                    <select class="form-select" aria-label="Default select example"
                                                            name="province_id"
                                                            required
                                                            id="province_id"
                                                            onchange="">
                                                        @foreach($provinces as $province)
                                                            @if(\App\Helpers\AppHelper::getLocationSettings()->language->code == "ar")
                                                                <option
                                                                    value="{{$province->id}}">{{ $province->meta['translate']['name_ar'] }}</option>
                                                            @else
                                                                <option
                                                                    value="{{$province->id}}">{{ $province->meta['translate']['name_en'] }}</option>
                                                            @endif

                                                        @endforeach
                                                    </select>
                                                </div>


                                                <div
                                                    class="mb-3 col-12 p-0 px-1 col-md-6 justify-content-between d-flex flex-column">
                                                    <input type="text" class="form-control" id="InputAreaTitle"
                                                           name="title"
                                                           placeholder="{{__('Area Title')}}">

                                                </div>
                                                <div
                                                    class="mb-3 col-12 p-0 px-1 col-md-6 justify-content-between d-flex flex-column">
                                                    <input type="text" class="form-control" id="InputStreetTitle"
                                                           name="title"
                                                           placeholder="{{__('Street Title')}}">

                                                </div>


                                                <div class="mb-3 col-12 p-0 px-1 col-md-6">
                                                    <input type="text" class="form-control" id="building"
                                                           name="building" placeholder="{{__('Building')}}">
                                                </div>


                                                <div
                                                    class="mb-3 col-12 p-0 px-1 col-md-6 justify-content-between d-flex flex-column">
                                                    <input type="text" class="form-control number" id="floor_number"
                                                           name="floor_number" placeholder="{{__('Floor Number')}}">
                                                </div>

                                                <div
                                                    class="mb-3 col-12 p-0 px-1 col-md-6 justify-content-between d-flex flex-column">
                                                    <input type="text" class="form-control number" id="apartment_number"
                                                           name="apartment_number"
                                                           placeholder="{{__('Apartment Number')}}">

                                                </div>



                                                <div
                                                    class="mb-3 col-12 p-0 px-1 align-items-center justify-content-start d-none current-location-box ">
{{--                                                    <div class="form-check">--}}
{{--                                                        <input class="form-check-input" type="checkbox" value=""--}}
{{--                                                               id="currentLocationCheck">--}}
{{--                                                        <label class="form-check-label" for="currentLocationCheck">--}}
{{--                                                            {{__('Pin to current location')}}--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}
                                                </div>
                                                @if($errors->any())
                                                    <div class="error-container mt-4">
                                                        {{ implode('', $errors->all(':message')) }}
                                                    </div>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                    <div
                                        class="swiper-slide align-items-start d-flex flex-column  bg-white h-100  px-0 px-md-3"
                                        id="pills-create-order-type"
                                        role="tabpanel"
                                        aria-labelledby="pills-create-order-type-tab"
                                        tabindex="0">
                                        <h4 class="log-title mb-4">{{__('Order information')}}</h4>
                                        <div class="w-100 form-box d-flex flex-column ">

                                            <div class="w-100 row mx-0">
                                                <div class="col-12">
                                                    <select class="form-select" aria-label="Default select example"
                                                            id="orderType"
                                                            name="type"
                                                            required
                                                            onchange="getComboA(this)">

                                                        @if($getSetting->has_recycling)
                                                            <option value="2">{{ __('Recycling')}}</option>
                                                        @endif
                                                        @if(($getSetting->has_donation))
                                                            <option value="1">{{ __('Donation') }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-12 my-2 association ">
                                                </div>

                                                <div class="row w-00 mx-0">
                                                    @foreach($items as $item)
                                                        <div class="col-6 col-md-4   my-1">
                                                            <input type="checkbox" class="btn-check checkbox-items"
                                                                   id="{{$item['id']}}">
                                                            <label
                                                                class="btn btn-outline-light d-flex align-items-center gap-1 justify-content-center "
                                                                for="{{$item['id']}}">
                                                        <span><img src="{{$item['image_path']}}"
                                                                   alt="{{$item['alt']??''}}" width="35px" height="35px"
                                                                   style="object-fit: contain;"/></span>
                                                                <span class="text-dark">{{$item['title']}}</span>
                                                            </label>

                                                        </div>
                                                    @endforeach
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row box-pagination w-100 gap-2 justify-content-center py-3 w-100 mx-0">

                                    <div
                                        class="form-item px-0  flex-fill  col-5 position-relative d-none submit-create-order-btn ">
                                        <button type="submit"
                                                id="sign-up-button-create-order-componetn"
                                                class="btn btn-success flex-fill   sign-up-button"
                                                style="color: #fff">{{__('Submit')}}
                                            <div
                                                class="lds-ellipsis lds-ellipsis-register d-none position-absolute start-50 top-50 translate-middle">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </button>
                                    </div>

                                    <button type="button"
                                            class="flex-fill col-5 btn btn-primary swiper-button-next-mySwiper-in-create-order-component-tab-content">
                                        {{__("Next")}}
                                    </button>

                                    <button type="button"
                                            class="flex-fill col-5 btn btn-primary swiper-button-prev-mySwiper-in-create-order-component-tab-content">
                                        {{__("Previous")}}
                                    </button>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="swiper  mySwiper-in-create-order-component h-100 w-100">
        <div class="swiper-wrapper  h-100">
            @foreach($section['sliders'] as $key => $slider)
                @if($section['type'] == \App\Enums\MediaType::IMAGE)
                    <div class="swiper-slide h-100"
                         style=" background-image: url('{{$slider["src"]??url('/images/placeholder.png')}}');">
                        @else
                            <div class="swiper-slide h-100">
                                @endif
                                <div class="mask"></div>
                                @if($section['type'] == \App\Enums\MediaType::VIDEO)
                                    <video
                                        {{--                                        src="{{$slider['src']}}"--}}
                                        src="http://localhost/images/banner.mp4"
                                        muted
                                        autoplay
                                        loop
                                        id="video"
                                        class="w-100 h-100 position-absolute fit-cover start-0 top-0"
                                        playsinline>
                                    </video>
                                @endif
                                <div class="container z-index-99 position-relative container-slider ">
                                    <div class="row position-relative">
                                        <div
                                            class="col-12 col-lg-6 d-flex flex-column align-items-start text-white content">
                                            <h1 data-aos="fade-up" data-deuration="300" data-swiper-parallax="-300"
                                                class="title">
                                                {!!$slider['title']??""!!}
                                            </h1>
                                            <p class="font-bold fs-5 " data-aos="fade-right" data-deuration="300"
                                               data-swiper-parallax="-400">
                                                {!! $slider['sub_title'] !!}
                                            </p>
                                            @if(isset($slider['button']))
                                                <a href="{{$slider['button']['target'] == '_blank' ? $slider['button']['link'] :"/".AppHelper::getSlug().$slider['button']['link']}}"
                                                   class="cat-Button d-flex align-items-center justify-content-center py-2  text-decoration-none text-white"
                                                   data-aos="fade-right"
                                                   data-deuration="300"
                                                   data-swiper-parallax="-600">
                                                    {{$slider['button']['title']}}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                    </div>
                    <div class="container position-relative bottom-15 d-none d-lg-flex">
                        <div class="row row-pagination z-index-99">
                            <div class="box-pagination col-12 d-flex align-items-center ">

                                <div
                                    class=" d-flex align-items-center  swiper-button-next-mySwiper-in-create-order-component">
                                    <svg width="20" height="15" viewBox="0 0 20 15" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M19.6122 8.45899C19.9848 8.0863 19.9848 7.48205 19.6122 7.10936L13.5388 1.03601C13.1661 0.663319 12.5619 0.663319 12.1892 1.03601C11.8165 1.4087 11.8165 2.01295 12.1892 2.38564L17.5877 7.78418L12.1892 13.1827C11.8165 13.5554 11.8165 14.1597 12.1892 14.5323C12.5619 14.905 13.1661 14.905 13.5388 14.5323L19.6122 8.45899ZM0.041504 8.73851L18.9373 8.73851L18.9373 6.82984L0.0415038 6.82984L0.041504 8.73851Z"
                                            fill="white"/>
                                    </svg>
                                </div>
                                <div
                                    class="swiper-pagination-mySwiper-in-create-order-component h-100 d-flex align-items-center px-2 top-0 text-white number"></div>
                                <div
                                    class="  d-flex align-items-center  swiper-button-prev-mySwiper-in-create-order-component">
                                    <svg width="21" height="15" viewBox="0 0 21 15" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1.10671 7.10936C0.734018 7.48205 0.734018 8.08631 1.10671 8.459L7.18006 14.5323C7.55275 14.905 8.157 14.905 8.52969 14.5323C8.90239 14.1597 8.90239 13.5554 8.52969 13.1827L3.13116 7.78418L8.52969 2.38565C8.90239 2.01295 8.90239 1.4087 8.52969 1.03601C8.157 0.663321 7.55275 0.663321 7.18006 1.03601L1.10671 7.10936ZM20.6792 6.82984L1.78153 6.82984V8.73851L20.6792 8.73851V6.82984Z"
                                            fill="white"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</section>


<button type="button" class="btn btn-primary d-none open-otp" data-bs-toggle="modal"
        data-bs-target="#staticBackdrop"></button>

<!-- Modal -->
<div class="modal fade p-0" id="staticBackdrop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-0">

            </div>
        </div>
    </div>
</div>


<script async src="{{ mix('js/jqueryPincodeAutotab.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>


<script>
    var association = document.querySelector(".association")

    function createSelectElement() {
        var element = `
         <select class="form-select" aria-label="Default select example"  id="association_id" name="association_id" required>
        @foreach($associations as $association)
        <option value="{{$association['id']}}">{{$association['title']}}</option>
         @endforeach
        </select>`
        association.innerHTML = element;
    }

    function removeElement() {
        association.innerHTML = ""
    }

    @if($getSetting->has_donation&&!$getSetting->has_recycling)
    createSelectElement()
    @endif

    function getComboA(selectObject) {
        var value = selectObject.value;
        if (value == {{\App\Enums\OrderType::DONATION}}) {
            @if($getSetting->has_donation)
            @if(count($associations) > 0)
            createSelectElement()
            @endif
            @endif

        } else {
            removeElement()
        }
    }


    var toastTextEmptyValueNumber = `{{__('Please Enter Your Number')}}`,
        toastTextEmptyInputAreaTitle = `{{__('Please Enter Your Area title')}}`,
        toastTextEmptyInputStreetTitle = `{{__('Please Enter Your Street Title')}}`,
        toastTextEmptyValueName = `{{__('Please Enter Your Name')}}`,
        toastLoginSuccess = `{{__('Dashboard Login')}}`,
        toastTextInvalidValue = `{{__('Enter a valid number')}}`,
        SomethingWrong = `{{__('Something went wrong, please try again')}}`;
    phoneExsits = `{{__('Phone Already Exists')}}`
    AgentLogin = `{{__('Sorry, your account type is Agent')}}`
    AdminLogin = `{{__('Sorry, your account type is Admin')}}`
    AssociationOrder = `{{__('Sorry, your account type is Association')}}`;
    ActiveOrder = `{{__('Sorry, you have already active order')}}`;

    makeOrderData = {}

    function deleteToast() {
        document.querySelector(".toast-body").innerHTML = ""
    }

    function showSpinnerRegister(element) {
        $('.lds-ellipsis-register').toggleClass('d-none');
        element.target.classList.toggle("disabled");
        element.target.classList.toggle("text-transparent")
    }

    function deleteSpinnerRegister() {
        $('.lds-ellipsis-register').toggleClass('d-none');
        $("#sign-up-button-create-order-componetn").removeClass("disabled")
        $("#sign-up-button-create-order-componetn").removeClass("text-transparent")
    }

    function ShowToast(e) {
        if (typeof e === "object") {
            for (let i = 0; i < e.length; i++) {
                document.querySelector(".toast-body").innerHTML += `<p class="fs-6 text-danger">${e[i]}</p>`
            }
        } else {
            document.querySelector(".toast-body").innerHTML = `<p class="fs-6 text-danger">${e}</p>`
        }

        let toast = new bootstrap.Toast($('#liveToastErrorCreateOrder'))
        toast.show()
    }

    function removeInputValue(e) {
        $(`#${e}`).val("")
        $(`#${e}`).focus()
        $(`#${e}`).addClass("border-danger")
    }

    function allnumeric(inputTxt) {
        var numbers = /^[0-9]+$/;
        if (inputTxt.match(numbers))
            return true
        else return false
    }

    function formatDate(date, lang) {
        let d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear(),
            hours = d.getHours(),
            minutes = d.getMinutes();
        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;
        if (hours.length < 2)
            hours = '0' + hours;
        if (minutes.length < 2)
            minutes = '0' + minutes;
        let dateYY = [year, month, day].join('-'),
            dateHH = [hours, minutes].join(':');
        return `<span class="dir-ltr date"><span>${dateHH}</span> <span>${dateYY}</span></span>`
    }

    function getRedirectMessage1(message) {
        console.log(message)
        $(".redirectMessage-1").removeClass("d-none");
        $(".card .swiper-card-create-order-component").addClass("d-none")
        if (message !== null) {
            const msg = `<span class="">{{__('Your request has been created successfully One of our representatives will contact you in:')}} <br> ${formatDate(message)}</span>`
            $("#message-create-order-done").html(msg)
        } else {
            $("#message-create-order-done").text("{{__('Your request has been created successfully One of our representatives will contact you as soon as possible')}}")
        }
    }

    function removeRedirectMessage1() {
        $(".redirectMessage-1").addClass("d-none");

        $(".card .swiper-card-create-order-component").removeClass("d-none")
    }


    function deleteAllInputsValue() {
        const inputsInCardsComponent = document.querySelectorAll("#create-order-component .card input"),
            selectInCardsComponent = document.querySelectorAll("#create-order-component .card select");
        inputsInCardsComponent.forEach(input => {
            if (input.getAttribute("type") !== "checkbox" || input.getAttribute("type") !== "hidden") {
                input.value = ""
            }
            if (input.getAttribute("type") == "hidden" && input.getAttribute("id") == "phoneHidden") {
                input.value = ""
            }
            if (input.getAttribute("type") == "checkbox") {
                input.checked = false
            }
        })

        selectInCardsComponent.forEach(select => {
            // if (select.id !== "orderType") {
            //     select.selectedIndex = 0
            // } else {
            //     select.selectedIndex = 0
            //
            //     createSelectElement()
            // }
            select.selectedIndex = 0
        })
        removeElement()
        $(".code-country-text").html("{{$currentCode}}")
        $(".code-country-flag").attr("src", "{{$currentFlag}}")

    }

    function makeOrder(e, data) {
        deleteToast()
        if ($("#username").val().length === 0) {
            ShowToast(toastTextEmptyValueName)
            removeInputValue("username")
            mySwiperInCreateOrderComponentTabContent.slideTo(0)
        } else if ($("#phone").val().length === 0) {
            ShowToast(toastTextEmptyValueNumber)
            removeInputValue("phone")
            mySwiperInCreateOrderComponentTabContent.slideTo(0)
        }else if ($("#InputAreaTitle").val().length === 0) {
            mySwiperInCreateOrderComponentTabContent.slideTo(mySwiperInCreateOrderComponentTabContent.realIndex - 1)
            ShowToast(toastTextEmptyInputAreaTitle)
            removeInputValue("InputAreaTitle")
        }else if ($("#InputStreetTitle").val().length === 0) {
            mySwiperInCreateOrderComponentTabContent.slideTo(mySwiperInCreateOrderComponentTabContent.realIndex - 1)
            ShowToast(toastTextEmptyInputStreetTitle)
            removeInputValue("InputStreetTitle")
        }
        else {
            $("#username").hasClass("border-danger") ? $("#username").removeClass("border-danger") : false;
            if (allnumeric($("#phone").val())) {
                $("#phone").hasClass("border-danger") ? $("#phone").removeClass("border-danger") : false;
                showSpinnerRegister(e)
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "/{{\App\Helpers\AppHelper::getSlug() . '/make-order-home'}}",
                    data: data,
                    dataType: "html",
                    success: (response) => {
                        const res = JSON.parse(response)

                        deleteSpinnerRegister()
                        getRedirectMessage1(res.message)
                        setTimeout(() => {
                            deleteAllInputsValue()
                            removeRedirectMessage1()
                            @if($getSetting->has_donation&&!$getSetting->has_recycling)
                            createSelectElement()
                            @endif
                            mySwiperInCreateOrderComponentTabContent.slideTo(0)
                        }, 3000)
                        setTimeout(() => {
                            window.location.href = "/{{\App\Helpers\AppHelper::getSlug() . '/thank-you'}}"
                        }, 3000)
                    },
                    error: (response) => {
                        const res = response
                        switch (res.status) {
                            case 500:
                                ShowToast(SomethingWrong)
                                showSpinnerRegister(e)
                                break;
                            case 422:
                                let msg = []
                                messages = JSON.parse(res.responseText)
                                for (key in messages.message) {
                                    msg.push(messages.message[key][0])
                                }
                                ShowToast(msg)
                                showSpinnerRegister(e)
                                break;
                            case 403:
                                switch (JSON.parse(res.responseText).message) {
                                    case {{\App\Enums\UserType::ADMIN}}:
                                        ShowToast(AdminLogin, "liveToastErrorCreateOrder")
                                        showSpinnerRegister(e)
                                        break;
                                    case {{\App\Enums\UserType::AGENT}}:
                                        ShowToast(AgentLogin, "liveToastErrorCreateOrder")
                                        showSpinnerRegister(e)
                                        break;
                                    case {{\App\Enums\UserType::ASSOCIATION}}:
                                        ShowToast(AssociationOrder, "liveToastErrorCreateOrder")
                                        showSpinnerRegister(e)
                                        break;

                                    case 100:
                                        ShowToast(ActiveOrder, "liveToastErrorCreateOrder")
                                        showSpinnerRegister(e)
                                        break;
                                }
                                break;
                            default :
                                const responseData = res.responseJSON.data;
                                for (var key in responseData) {
                                    ShowToast(`<h4 class="text-danger dir-rtl">!! error ${key} </h4> : ${responseData[key]}`)
                                }
                                removeInputValue("phone")
                                showSpinnerRegister(e)
                                break;
                        }
                    },
                })
            } else {
                ShowToast(toastTextInvalidValue)
            }
        }

    }

    function ShowOtpDialog(e, data) {
        if ($("#username").val().length === 0) {
            ShowToast(toastTextEmptyValueName)
            removeInputValue("username")
            mySwiperInCreateOrderComponentTabContent.slideTo(0)
        } else if ($("#phone").val().length === 0) {
            ShowToast(toastTextEmptyValueNumber)
            removeInputValue("phone")
            mySwiperInCreateOrderComponentTabContent.slideTo(0)
        }else if ($("#InputAreaTitle").val().length === 0) {
            mySwiperInCreateOrderComponentTabContent.slideTo(mySwiperInCreateOrderComponentTabContent.realIndex - 1)
            ShowToast(toastTextEmptyInputAreaTitle)
            removeInputValue("InputAreaTitle")
        }else if ($("#InputStreetTitle").val().length === 0) {
            mySwiperInCreateOrderComponentTabContent.slideTo(mySwiperInCreateOrderComponentTabContent.realIndex - 1)
            ShowToast(toastTextEmptyInputStreetTitle)
            removeInputValue("InputStreetTitle")
        } else {
            $("#username").hasClass("border-danger") ? $("#username").removeClass("border-danger") : false;
            if (allnumeric($("#phone").val())) {
                $("#phone").hasClass("border-danger") ? $("#phone").removeClass("border-danger") : false;
                showSpinnerRegister(e)
                deleteToast()
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{AppHelper::getSlug() . '/auth/otp-dialog'}}",
                    data: data,
                    dataType: "html",
                    success: (response) => {
                        const res = response
                        console.log("success")
                        // ShowToast(toastLoginSuccess)
                        $(".modal-body").html(res)
                        $(".open-otp").click()

                        showSpinnerRegister(e)
                    },
                    error: (response) => {
                        const res = response
                        console.log(res)
                        console.log(res.status)
                        switch (res.status) {
                            case 500:
                                ShowToast(SomethingWrong)
                                showSpinnerRegister(e)
                                break;
                            case 422:
                                let msg = []
                                messages = JSON.parse(res.responseText)
                                for (key in messages.message) {
                                    msg.push(messages.message[key][0])
                                }
                                ShowToast(msg)
                                showSpinnerRegister(e)
                                break;
                            case 403:
                                switch (JSON.parse(res.responseText).message) {
                                    case {{\App\Enums\UserType::ADMIN}}:
                                        ShowToast(AdminLogin, "liveToastErrorCreateOrder")
                                        showSpinnerRegister(e)
                                        break;
                                    case {{\App\Enums\UserType::AGENT}}:
                                        ShowToast(AgentLogin, "liveToastErrorCreateOrder")
                                        showSpinnerRegister(e)
                                        break;
                                    case {{\App\Enums\UserType::ASSOCIATION}}:
                                        ShowToast(AssociationOrder, "liveToastErrorCreateOrder")
                                        showSpinnerRegister(e)
                                        break;
                                }
                                break;
                            default :
                                const responseData = res.responseJSON.data;
                                for (var key in responseData) {
                                    ShowToast(`<h4 class="text-danger dir-rtl">!! error ${key} </h4> : ${responseData[key]}`)
                                }
                                removeInputValue("phone")
                                showSpinnerRegister(e)
                                break;
                        }
                    },
                })
            } else {
                ShowToast(toastTextInvalidValue)
            }

        }

    }

    $(document).ready(function () {
        var items = []
        let allItemsCheckbox = document.querySelectorAll(".checkbox-items")
        allItemsCheckbox.forEach((item) => {
            item.addEventListener("change", () => {

                if (item.checked) {
                    console.log(item.getAttribute("id"))
                    items.push(item.getAttribute("id"))
                } else {
                    console.log(item.getAttribute("id"))
                    items = items.filter(i => i !== `${item.getAttribute("id")}`)
                }
            })
        })
        $(document).on('click', 'button[type="submit"].sign-up-button', function (e) {
            e.preventDefault();
            console.log(items);
            var makeOrderDataWitoutCode = {
                'name': $('#username').val(),
                "phone": `${$(".code-country-text").text()}${+window.phone.value}`,
                "apartment_number": $("#apartment_number").val(),
                "floor_number": $("#floor_number").val(),
                "building": $("#building").val(),
                "lat": null,
                "lng": null,
                "province_id": $("#province_id").val(),
                "area_title": $("#InputAreaTitle").val(),
                "street_title": $("#InputStreetTitle").val(),
                "type": $("#orderType").val(),
                "association_id": $("#association_id").val(),
                "items": items,
            }
            Object.assign(makeOrderData, makeOrderDataWitoutCode)

            @if($otp_active == 1)

            ShowOtpDialog(e, makeOrderDataWitoutCode)
            @else
            makeOrder(e, makeOrderDataWitoutCode)
            @endif

        })
    })
</script>
<script>
    infoIputs = document.querySelectorAll("#pills-create-order-info input")
    userNameInput = document.querySelector("#username"),
        phoneInput = document.querySelector("#phone"),
        tabs = document.querySelectorAll(".address-tab"),
        allInputValid = false;
    infoIputs.forEach(e => {
        e.addEventListener("keyup", (event) => {
            allInputValid = userNameInput.value.length > 0 && phoneInput.value.length > 0;
            if (allInputValid) {
                tabs.forEach(tab => {
                    tab.classList.replace("d-none", "d-flex")
                })
            } else {
                tabs.forEach(tab => {
                    tab.classList.replace("d-flex", "d-none")
                })
            }


        })
    })
</script>


{{--<script--}}
{{--    src="https://maps.googleapis.com/maps/api/js?key={{config('app.map_api_key')}}&callback=initAutocomplete&v=weekly&libraries=places"--}}
{{--    async defer--}}
{{--></script>--}}



<script>
    const getLocationUserButton = document.querySelector(".get-location-user-button"),
        getLocationShouldPermission = document.querySelector(".get-location-should-permission"),
        // currentLocationCheck = document.querySelector("#currentLocationCheck")
        currentLocationBox = document.querySelector(".current-location-box");

    let latValue,
        lngValue,
        is_Current_Location = false,
        latInput = document.getElementsByName("lat")[0],
        lngInput = document.getElementsByName("lng")[0];

    // currentLocationCheck.addEventListener("change", () => {
    //     if (!currentLocationCheck.checked) {
    //         lngInput.value = "null"
    //         latInput.value = "null"
    //     } else {
    //         lngInput.value = lngValue
    //         latInput.value = latValue
    //     }
    // })

    function getCurrentLocation(permissionStatus) {
        if (permissionStatus === "granted") {
            console.log("_____________________________")
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    console.log(position.coords.latitude)
                    console.log(position.coords.longitude)
                    latInput.value = position.coords.latitude
                    lngInput.value = position.coords.longitude
                    latValue = latInput.value
                    lngValue = lngInput.value
                    is_Current_Location = true;
                    currentLocationBox.classList.replace("d-none", "d-flex")
                    // currentLocationCheck.checked = true
                    // window.location.href = `https://www.google.com/maps/@${position.coords.latitude},${position.coords.longitude},10z`
                },
                (error) => {
                    console.error("Error getting location:", error);
                }
            );
            // deleteElement()
        } else {
            haveAccess(navigator)
        }
    }

{{--    function createElement() {--}}
{{--        const element = `--}}
{{--                 <div  class="permission-container start-0 w-100 h-100 position-absolute top-0 start-0 bg-white d-flex align-items-center justify-content-center">--}}
{{--            <div class="container">--}}
{{--                                <div class="row justify-content-center">--}}
{{--                                    <div class="col-12 ">--}}
{{--                  <div class=" py-1 px-2 border-0" style="  box-shadow: 0px 11px 33px 5px #e7f6fac4;">--}}
{{--              <div class="card-body text-center">--}}
{{--                <h5 class="card-title pb-2"> {{__('Allow the use of geolocation information To proceed to the next step')}}</h5>--}}


{{--                <a  type="button" class="get-location-user-button btn-primary btn w-100 py-3 my-2">--}}
{{--                {{__('allow')}}--}}
{{--        </a>--}}
{{--          <a  type="button" class="text-primary get-location-should-permission" onclick="deleteElement()"  >--}}
{{--{{__('Disallow and cancel the operation')}}--}}
{{--        </a>--}}

{{--              </div>--}}
{{--            </div>--}}
{{--               </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--         </div>--}}


{{--`--}}
{{--        const divContainer = document.querySelector(".permission-element")--}}
{{--        divContainer.innerHTML = element--}}
{{--    }--}}

{{--    function deleteElement() {--}}
{{--        const permissionContainer = document.querySelector(".permission-container");--}}
{{--        navigator.permissions && navigator.permissions.query({name: 'geolocation'})--}}
{{--            .then(function (PermissionStatus) {--}}
{{--                if (PermissionStatus.state === 'granted') {--}}
{{--                    permissionContainer ? permissionContainer.remove() : false--}}
{{--                } else {--}}
{{--                    permissionContainer ? permissionContainer.remove() : false--}}
{{--                }--}}
{{--            })--}}
{{--    }--}}

    function haveAccess(navigator) {
        navigator.permissions.query({name: 'geolocation'})
            .then(function (PermissionStatus) {
                if (PermissionStatus.state === 'granted') {
                    getCurrentLocation(PermissionStatus.state);
                    // deleteElement()
                } else if (PermissionStatus.state === 'prompt') {
                    // createElement();
                    const getLocationUserButton = document.querySelector(".get-location-user-button");
                    getLocationUserButton.onclick = () => {
                        // deleteElement()
                        navigator.geolocation.getCurrentPosition(
                            function () {
                                console.log("success")
                            },
                            function (error) {
                                console.log(error)
                            }
                        );
                        navigator.geolocation.getCurrentPosition((position) => {
                        });
                        navigator.permissions.query({name: 'geolocation'}).then((permissionStatus) => {
                            console.log(`geolocation permission status is ${permissionStatus.state}`);
                            permissionStatus.onchange = () => {
                                console.log(`geolocation permission status has changed to ${permissionStatus.state}`);
                                if (permissionStatus.state === "granted") {
                                    getCurrentLocation(permissionStatus.state)
                                }
                            };
                        });
                    }
                } else {
                    // createElement();
                    const getLocationUserButton = document.querySelector(".get-location-user-button");
                    getLocationUserButton.onclick = () => {
                        // deleteElement()
                        navigator.geolocation.getCurrentPosition(
                            function () {
                                console.log("success")
                            },
                            function (error) {
                                console.log(error)
                            }
                        );
                        //TODO SET ACCESS TO LOCATION
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(showPosition);
                        } else {
                            console.log("Geolocation is not supported by this browser.");
                        }

                        function showPosition(position) {
                            let latInput = document.getElementsByName("lat")[0],
                                lngInput = document.getElementsByName("lng")[0];
                            latInput.value = position.coords.latitude
                            lngInput.value = position.coords.longitude
                            is_Current_Location = true;
                            currentLocationBox.classList.replace("d-none", "d-flex")
                            // currentLocationCheck.checked = true
                        }
                    }
                }
            }) && navigator.permissions
    }

    if (navigator.geolocation) {
        // createElement();
        getLocationUserButton.onclick = () => {
            navigator.geolocation.getCurrentPosition(
                function () {
                    // deleteElement()
                },
                function () {
                    // deleteElement()
                }
            );
            //TODO SET ACCESS TO LOCATION
            navigator.geolocation.getCurrentPosition((position) => {
            });
        }
        haveAccess(navigator)
    }
    getLocationShouldPermission.addEventListener("click", () => {
        // deleteElement()
    })
    getLocationUserButton.addEventListener("click", () => {
        // deleteElement()
    })


    let InputProvinceTitle;
    let autocomplete;


    function initAutocomplete() {
        InputProvinceTitle = document.querySelector("#InputProvinceTitle");
        autocomplete = new google.maps.places.Autocomplete(InputProvinceTitle, {
            componentRestrictions: {country: ["{{AppHelper::getLocationSettings()->country->code}}"]},
            fields: ["formatted_address", "geometry", "name"],
            strictBounds: false,
            types: [],
        });

        autocomplete.addListener("place_changed", fillInAddress);
    }

    function fillInAddress() {
        is_Current_Location ? is_Current_Location : is_Current_Location = false;
        if (is_Current_Location) {

            // currentLocationCheck.checked = true
            currentLocationBox.classList.replace("d-none", "d-flex")
        }
        const place = autocomplete.getPlace();
        let address1 = "";
        address1 += place.formatted_address;
        InputProvinceTitle.value = address1
        if (!is_Current_Location) {
            latInput.value = +place.geometry.location.lat()
        }
        if (!is_Current_Location) {
            lngInput.value = +place.geometry.location.lng()
        }
    }

    // window.initAutocomplete = initAutocomplete;
</script>


<script>

    var mySwiperInCreateOrderComponent = new Swiper(".mySwiper-in-create-order-component", {
        pagination: {
            el: ".swiper-pagination-mySwiper-in-create-order-component",
            type: "fraction",
        },
        navigation: {
            nextEl: ".swiper-button-next-mySwiper-in-create-order-component",
            prevEl: ".swiper-button-prev-mySwiper-in-create-order-component",
        },
        effect: "fade",
        speed: 800,
        parallax: true,
        autoplay: {
            delay: 4500,
            disableOnInteraction: false,
        },
        loop: false,
    });
    rowPagination = document.querySelector(".mySwiper-in-create-order-component .row-pagination ")
    mySwiperInCreateOrderComponent.slides.length === 1 ? rowPagination.classList.add("d-none") : false

</script>


<script>
    var mySwiperInCreateOrderComponentTabContent = new Swiper(".mySwiper-in-create-order-component-tab-content", {
        spaceBetween: 30,
        navigation: {
            nextEl: ".swiper-button-next-mySwiper-in-create-order-component-tab-content",
            prevEl: ".swiper-button-prev-mySwiper-in-create-order-component-tab-content",
        },
        allowTouchMove: false
    });
    submitCreateOrderBtn = document.querySelector("#create-order-component .submit-create-order-btn")


    mySwiperInCreateOrderComponentTabContent.on('slideChange', function () {
        if (mySwiperInCreateOrderComponentTabContent.realIndex + 1 == mySwiperInCreateOrderComponentTabContent.slides.length) {
            submitCreateOrderBtn.classList.replace("d-none", "d-flex")
        } else {
            submitCreateOrderBtn.classList.replace("d-flex", "d-none")
        }
    });
</script>
<script>


    function convertNumber(fromNum) {
        return fromNum.replace(/[\u0660-\u0669\u06f0-\u06f9]/g, c => c.charCodeAt(0) & 0xf);

    }

    function allnumeric(inputTxt) {
        var numbers = /^[0-9]+$/;
        if (inputTxt.match(numbers))
            return true
        else return false
    }

    function allnumericAr(inputTxt) {
        var numbersAr = /[\u0660-\u0669\u06f0-\u06f9]/g;
        if (inputTxt.match(numbersAr))
            return true
        else return false
    }

    $("#phone").keypress(e => {
        if (!allnumeric(e.key)) {
            if (allnumericAr(e.key)) {
                e.preventDefault()
                convertNumber(e.key) !== -1 ?
                    document.getElementById("phone").value += +convertNumber(e.key) : false
            } else {
                e.preventDefault()
            }
        }
    })
</script>

<script>


    $(document).ready(function () {
        $(".item-code").on("click", (e) => {
            e.preventDefault()
            $(".code-country-text").text(e.target.dataset.countryCode)
            $(".code-country-flag").attr("src", e.target.dataset.countryFlag)
        })
    })


</script>
