@php
    use App\Helpers\AppHelper;
@endphp
@extends('auth.dashboard-layout')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/components/pagination-style.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">
    @if(App::getLocale() == 'ar')
        <style>
            .profile-user-img {
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
    <script src="{{ mix('js/dashboard.js') }}"></script>


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
        const
            labelTab = document.querySelector(".label-tab"),
            boxInputs = document.querySelector(".box-inputs"),
            textPhone = "{{__('Phone')}}",
            codeNumber = "{{$country->code_number}}",
            flagSvg = "{{$country->flag}}",
            selectInput = `
                <P class="border-0 dir-rtl code-phone d-flex align-items-center justify-content-center my-0 py-0   ">

                        <span class="is_number d-inline-block span-code-number  "  style="direction: ltr;" >${codeNumber}</span>
                            <span class="d-inline-block mx-1">
                            <img src="${flagSvg}" alt="" class="img-fluid ">
                        </span>
                    </P>
            `;
        window.addEventListener("load", () => {
            codePhone = document.querySelector(".code-phone")
            if (codePhone == null) {
                boxInputs.innerHTML += selectInput;
            }
            getLoginValue();
        })
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
            var numbersAr =/[\u0660-\u0669\u06f0-\u06f9]/g;
            if (inputTxt.match(numbersAr))
                return true
            else return false
        }


        function getLoginValue() {
            $("#phone").keypress(e => {
                if (!allnumeric(e.key)) {
                    if (allnumericAr(e.key)) {
                        e.preventDefault()
                        convertNumber(e.key) !== -1 ?
                            document.getElementById("phone").value += +convertNumber(e.key) :false
                    } else {
                        e.preventDefault()
                    }
                }
            })
        }
    </script>

@endsection


@section('content')
    <main class="pt-xl-0 bg-transparent dashboard-page">
        <div class="container-fluid">

            <div class="row flex-nowrap home-container">

                <div class="col-2 px-sm-2 px-0 bg-white sidebar-col d-flex">
                    @include('auth.components.sidebar')
                </div>
                <div class="col-10 pt-3 ">


                    <div class=" d-flex w-100 profile-back h-100  justify-content-between flex-column">
                        <div class="d-flex  px-2 px-lg-3 welcome-user px-0 px-lg-1 py-5 py-xl-3 w-100">
                            <div class="row">
                                <div class="col-12 col-md-6  col-lg-6 col-sm-12 col-xs-12 mt-2 mt-md-0 ">
                                    <h1>{{__('Welcome Back ')}}{{$user->name}} </h1>
                                    <h5>{{__('Glad to have you back today, we hope you had a nice and bright day')}}</h5>

                                </div>
                                <div
                                    class="col-12 col-md-6  col-lg-6 col-sm-12 col-xs-12 mt-2 mt-md-0 d-flex flex-column justify-content-start">
                                    <h1 class="points is_number"> {{__('You Have ')}}<span
                                            class="is_number count" data-target="{{$points['all']}}">0</span></h1>
                                    <div class="progress-container position-relative ">
                                        <svg class="progress-btn position-absolute" width="56" height="29"
                                             viewBox="0 0 56 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect x="0.476562" y="0.977417" width="55.1575" height="27.5541"
                                                  rx="13.777"
                                                  fill="#00AAA3"/>
                                        </svg>
                                        <p class="position-absolute number is_number count" style=" color: white;
                                                font-size: 15px;" data-target="{{500-$points['remain']}}">
                                            <span>0</span>
                                        </p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="0"
                                                 aria-valuemin="0"
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                    <span
                                        class="left-points mt-2">{{__('You have ')}}<span
                                            class="is_number count" data-target="{{$points['remain']}}">1</span> {{__(' points left to reach the level ')}} <span
                                            class="is_number count"
                                            data-target="{{$points['level'] +1}}">1</span> </span>
                                </div>

                            </div>
                            <div class="row mt-2">
                                <div class="col-12  col-xl-6 mt-2 mt-md-0 personal-info ">
                                    <div class="  points-inner-card p-2   ">
                                        <div class="container">
                                            <div class="row w-100">
                                                <div
                                                    class=" col-12 d-flex mt-2 d-flex align-items-center  justify-content-between">
                                                        <span
                                                            class="col-6 request-table-title"> {{__('Personal Info')}}</span>

                                                    <a type="button"
                                                       class="px-2 py-2 d-flex align-items-center gap-1 edit-profile">
                                                                    <span class="d-none d-md-flex">
                                                                         {{__("Edit")}}
                                                                    </span>
                                                        <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <g clip-path="url(#clip0_2775_62570)">
                                                                <path
                                                                    d="M17.7643 1.00142C17.6785 1.03263 17.5381 1.09115 17.4522 1.13797C17.3547 1.18869 15.5522 2.96781 12.7469 5.77694L8.19768 10.334L7.89336 11.8556C7.63195 13.1821 7.60074 13.3928 7.63585 13.5177C7.68657 13.6854 7.89726 13.8844 8.06112 13.9234C8.13916 13.939 8.65416 13.8532 9.57884 13.6698C10.3474 13.5177 11.038 13.3772 11.1122 13.3577C11.2214 13.3265 12.15 12.4174 15.8175 8.74604C20.9558 3.59986 20.5735 4.02904 20.5735 3.40869C20.5696 2.87417 20.4954 2.74932 19.6449 1.89878C19.0714 1.32525 18.8919 1.16918 18.7085 1.08725C18.4393 0.9624 18.0023 0.923385 17.7643 1.00142ZM18.8139 2.74152C19.3445 3.27213 19.4303 3.37357 19.4108 3.4516C19.3952 3.50233 19.2274 3.70131 19.0324 3.89638L18.6812 4.24753L17.9867 3.55305L17.2962 2.86247L17.6707 2.49182C17.8814 2.28503 18.0765 2.12117 18.1194 2.12117C18.1623 2.12117 18.4471 2.37087 18.8139 2.74152ZM17.1596 4.40359L17.8424 5.08636L14.2568 8.67191L10.6713 12.2575L9.83634 12.4213C9.37986 12.515 8.9936 12.5774 8.97799 12.5657C8.96629 12.5501 9.02872 12.1677 9.11845 11.7112L9.28232 10.8802L12.8601 7.29856C14.8265 5.33216 16.4456 3.72081 16.4573 3.72081C16.469 3.72081 16.785 4.02904 17.1596 4.40359Z"
                                                                    fill="#008451"></path>
                                                                <path
                                                                    d="M2.35292 4.18898C1.59602 4.34504 0.979569 4.88736 0.725967 5.62476L0.63623 5.88616V12.5383V19.1905L0.725967 19.448C0.948357 20.0957 1.44776 20.5951 2.09152 20.8175L2.35292 20.9072H9.00511H15.6573L15.9187 20.8175C16.5547 20.5951 17.0346 20.123 17.2843 19.4597L17.374 19.2295L17.3857 14.6569C17.3935 10.1194 17.3935 10.0804 17.3155 9.92429C17.2257 9.74872 17.0033 9.61217 16.8083 9.61217C16.6132 9.61217 16.3908 9.74872 16.3011 9.92429C16.223 10.0765 16.223 10.1428 16.223 14.5008C16.223 19.4714 16.2425 19.1554 15.9304 19.4636C15.6144 19.7797 16.1762 19.7563 9.00511 19.7563C1.83401 19.7563 2.39584 19.7797 2.07981 19.4636C1.76379 19.1476 1.7872 19.7094 1.7872 12.5383C1.7872 5.36725 1.76379 5.92908 2.07981 5.61305C2.38804 5.30093 2.07201 5.32043 7.04262 5.32043C11.4007 5.32043 11.467 5.32043 11.6192 5.2424C11.7947 5.15267 11.9313 4.93028 11.9313 4.7352C11.9313 4.54012 11.7947 4.31773 11.6192 4.22799C11.467 4.14996 11.4046 4.14996 6.988 4.15386C4.5261 4.15776 2.43876 4.17337 2.35292 4.18898Z"
                                                                    fill="#008451"></path>
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_2775_62570">
                                                                    <rect width="19.9761" height="19.9761" fill="white"
                                                                          transform="translate(0.616699 0.950684)"></rect>
                                                                </clipPath>
                                                            </defs>
                                                        </svg>
                                                    </a>
                                                    <i type="button" class="bi bi-x-circle d-none exit-edit fs-4 text-danger"></i>
                                                </div>
                                                <div class="col-12 mt-4">
                                                    <div class="col-7 d-flex flex-column">
                                                        <span class="title_info"> {{__('Full Name')}}</span>
                                                        <span class="sub_info">
                                                            <input type="text" readonly value="{{$user->name}}"
                                                                   name="name"
                                                                   class="form-control bg-transparent border-0 input-personal-info input-personal-info-name">
                                                       </span>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-4 d-flex flex-column flex-md-row ">
                                                    <div class="col-12 col-md-7 d-flex flex-column">
                                                        <span class="title_info"> {{__('Phone Number')}}</span>
                                                        <form id="userLoginForm" class="mt-0 d-none" method="POST"
                                                              action="validate-login">
                                                            @csrf
                                                            <div class="form-item">
                                                                <div class="tab-content" id="pills-tabContent">
                                                                    <div class="tab-pane fade show active"
                                                                         id="pills-phone" role="tabpanel"
                                                                         aria-labelledby="pills-phone-tab" tabindex="0">
                                                                        <div
                                                                            class=" d-flex align-items-center box-inputs">
                                                                            <input id="phone" type="tel"
                                                                                   class="dir-ltr  is_number form-control my-0 @error('phone') is-invalid @enderror"
                                                                                   value="" required
                                                                                   autocomplete="phone"
                                                                                   autofocus
                                                                                   pattern="[0-9]"
                                                                            >
                                                                            <input id="loginHidden" type="hidden"
                                                                                   name="login"
                                                                                   class="field-login-hidden">
                                                                        </div>
                                                                        @error('login')
                                                                        <p class="invalid-feedback d-block"
                                                                           role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </p>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="form-item mt-5 d-flex justify-content-center position-relative">
                                                                <div class="col-12 position-relative">
                                                                </div>
                                                            </div>
                                                            <a type="button"
                                                               class="px-2 py-2 save-button  align-items-center gap-1 save-profile text-success text-decoration-none d-flex w-fit">
                                                                     <span class="d-none d-md-flex ">
                                                                                {{__("Save")}}
                                                                    </span>
                                                                <svg width="22" height="22" viewBox="0 0 22 22"
                                                                     fill="none"
                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M1.55029 1.03493C0.824115 1.15801 0.167689 1.83085 0.0446091 2.57753C-0.00872549 2.90574 -0.00872549 20.0877 0.0446091 20.4159C0.167689 21.1831 0.820012 21.8354 1.58721 21.9585C1.91542 22.0118 19.0974 22.0118 19.4256 21.9585C20.1928 21.8354 20.8451 21.1831 20.9682 20.4159C20.9928 20.2682 21.0092 17.2979 21.0092 12.6947C21.0092 6.11813 21.001 5.19503 20.9477 5.08016C20.8656 4.90784 17.0419 1.09237 16.8942 1.03903C16.7547 0.985699 1.85799 0.985699 1.55029 1.03493ZM3.81906 4.8381C3.81906 6.52839 3.83547 7.84535 3.86008 7.98894C3.94214 8.49357 4.31958 9.05563 4.74626 9.3059C4.83652 9.35923 5.02114 9.44128 5.15242 9.48641C5.38627 9.56847 5.49294 9.56847 10.0141 9.56847C15.1342 9.56847 14.8388 9.58488 15.3106 9.29769C15.6922 9.06794 15.9629 8.73152 16.1352 8.27203C16.2255 8.02997 16.2255 8.00535 16.2419 4.98169L16.2542 1.93752H16.3855C16.5045 1.93752 16.6932 2.11393 18.2932 3.71397L20.0656 5.48632L20.0574 12.9121C20.0451 20.0672 20.041 20.3421 19.9671 20.4815C19.8605 20.6826 19.7046 20.8426 19.5117 20.9451C19.3722 21.019 19.2574 21.0354 18.7445 21.0477L18.1373 21.0641V16.465C18.1373 11.3859 18.1538 11.6936 17.8748 11.5624C17.7476 11.5008 17.1117 11.4967 10.5064 11.4967C3.90111 11.4967 3.2652 11.5008 3.13802 11.5624C2.85903 11.6936 2.87545 11.3859 2.87545 16.465V21.0641L2.27235 21.0477C1.78824 21.0354 1.63644 21.0149 1.52157 20.9575C1.32054 20.8549 1.16053 20.6949 1.05797 20.5021L0.967708 20.338V11.4967C0.967708 2.95087 0.97181 2.65138 1.04566 2.51189C1.19335 2.22881 1.4231 2.04419 1.70619 1.97444C1.77593 1.95803 2.27646 1.94572 2.82621 1.94162L3.81906 1.93752V4.8381ZM15.2655 4.92015C15.2655 7.72227 15.2573 7.91509 15.1875 8.071C15.0932 8.28023 14.8224 8.52639 14.6214 8.57973C14.5147 8.60844 13.0213 8.62485 9.99356 8.62485C5.75141 8.62485 5.51346 8.62075 5.35755 8.5469C5.15242 8.45665 4.9637 8.27203 4.86113 8.06279C4.78728 7.91509 4.78318 7.75919 4.77087 4.97759C4.76677 3.36524 4.77087 2.01957 4.77908 1.99085C4.79549 1.94572 5.735 1.93752 10.0346 1.93752H15.2655V4.92015ZM17.1937 16.7481V21.0559H10.5064H3.81906V16.7481V12.4403H10.5064H17.1937V16.7481Z"
                                                                        fill="#008451"/>
                                                                </svg>


                                                            </a>
                                                        </form>

                                                        <span class="sub_info is_number old-phone   ">
                                                        {{$user->phone}}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12  col-xl-6   mt-2 mt-xl-0 ">
                                    @if(count($addresses) > 0)
                                        <div class=" points-inner-card p-2 pb-5 pt-0 h-100  ">
                                            <div class="container">

                                                <div class="d-flex justify-content-between pt-2 header-address">
                                                    <span
                                                        class="col-6 request-table-title"> {{__('Places & Addresses')}}</span>
                                                    <div class="col-6 d-flex d-flex justify-content-end">
                                                        <a href="/{{AppHelper::getSlug()}}/dashboard/addresses">
                                                            <button type="button"
                                                                    class="btn btn-primary d-none d-md-flex  "
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-placement="button">
                                                                {{__('Add New Address')}}
                                                            </button>
                                                            <span class="d-flex d-md-none">
                                                                         <i class="bi bi-plus-circle text-primary fs-3"></i>
                                                                     </span>
                                                        </a>
                                                    </div>
                                                </div>
                                                @foreach ($addresses as $address)
                                                    <div class="row mt-4 addresses-row">
                                                        <div class="col-9 col-md-6  d-flex gap-2  ">
                                                            <div class="location-svg slide-top ">
                                                                <svg width="29" height="41" viewBox="0 0 29 41"
                                                                     fill="none"
                                                                     xmlns="http://www.w3.org/2000/svg"
                                                                     class=""
                                                                >
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                          d="M4.41713 5.27917C6.87738 2.74947 9.89365 1.32407 13.5497 0.97163C14.1438 0.908974 16.1014 1.00296 16.825 1.12044C19.8489 1.62168 22.5681 3.05492 24.7389 5.27917C25.8966 6.46963 26.7116 7.63658 27.4581 9.16381C28.4026 11.0905 28.8444 12.9153 28.9434 15.2179C29.0652 18.1078 28.0903 21.3816 26.1708 24.4987C24.2717 27.5988 14.5653 40.9946 14.5653 40.9946C14.5653 40.9946 4.09002 26.6437 2.31488 23.3474C1.44656 21.734 0.867683 20.152 0.486841 18.3976C-0.488115 13.8081 1.01241 8.78004 4.41713 5.27917ZM9.65428 13.5387C10.379 11.7908 11.8658 10.5579 13.667 10.2236C14.4664 10.0757 15.4682 10.1524 16.2409 10.4209C18.0634 11.062 19.4063 12.6291 19.7953 14.5798C20.0671 15.9332 19.79 17.4346 19.0439 18.6017C18.2819 19.7907 17.2108 20.5743 15.7986 20.9743C15.3083 21.1113 13.8375 21.1113 13.3473 20.9743C11.9351 20.5743 10.864 19.7907 10.1019 18.6017C9.15869 17.1168 8.98283 15.1661 9.65428 13.5387Z"
                                                                          fill="#008451"/>
                                                                </svg>
                                                            </div>
                                                            <div class="d-flex flex-column ">
                                                                    <span
                                                                        class="title_info"> {{$address->location_province}}
                                                            </span>
                                                                <span
                                                                    class="sub_info">{{$address->location_title}}
                                                                </span>
                                                            </div>


                                                        </div>
                                                        <div class="col-3 col-md-6 d-flex flex-row justify-content-end">
                                                            <a href="/{{AppHelper::getSlug()}}/dashboard/addresses/{{$address['id']}}"
                                                               class="px-2 py-2 d-flex align-items-center gap-1">
                                                                    <span class="d-none d-md-flex">
                                                                         {{__('Edit')}}
                                                                    </span>
                                                                <svg width="21" height="21" viewBox="0 0 21 21"
                                                                     fill="none"
                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                    <g clip-path="url(#clip0_2775_62570)">
                                                                        <path
                                                                            d="M17.7643 1.00142C17.6785 1.03263 17.5381 1.09115 17.4522 1.13797C17.3547 1.18869 15.5522 2.96781 12.7469 5.77694L8.19768 10.334L7.89336 11.8556C7.63195 13.1821 7.60074 13.3928 7.63585 13.5177C7.68657 13.6854 7.89726 13.8844 8.06112 13.9234C8.13916 13.939 8.65416 13.8532 9.57884 13.6698C10.3474 13.5177 11.038 13.3772 11.1122 13.3577C11.2214 13.3265 12.15 12.4174 15.8175 8.74604C20.9558 3.59986 20.5735 4.02904 20.5735 3.40869C20.5696 2.87417 20.4954 2.74932 19.6449 1.89878C19.0714 1.32525 18.8919 1.16918 18.7085 1.08725C18.4393 0.9624 18.0023 0.923385 17.7643 1.00142ZM18.8139 2.74152C19.3445 3.27213 19.4303 3.37357 19.4108 3.4516C19.3952 3.50233 19.2274 3.70131 19.0324 3.89638L18.6812 4.24753L17.9867 3.55305L17.2962 2.86247L17.6707 2.49182C17.8814 2.28503 18.0765 2.12117 18.1194 2.12117C18.1623 2.12117 18.4471 2.37087 18.8139 2.74152ZM17.1596 4.40359L17.8424 5.08636L14.2568 8.67191L10.6713 12.2575L9.83634 12.4213C9.37986 12.515 8.9936 12.5774 8.97799 12.5657C8.96629 12.5501 9.02872 12.1677 9.11845 11.7112L9.28232 10.8802L12.8601 7.29856C14.8265 5.33216 16.4456 3.72081 16.4573 3.72081C16.469 3.72081 16.785 4.02904 17.1596 4.40359Z"
                                                                            fill="#008451"/>
                                                                        <path
                                                                            d="M2.35292 4.18898C1.59602 4.34504 0.979569 4.88736 0.725967 5.62476L0.63623 5.88616V12.5383V19.1905L0.725967 19.448C0.948357 20.0957 1.44776 20.5951 2.09152 20.8175L2.35292 20.9072H9.00511H15.6573L15.9187 20.8175C16.5547 20.5951 17.0346 20.123 17.2843 19.4597L17.374 19.2295L17.3857 14.6569C17.3935 10.1194 17.3935 10.0804 17.3155 9.92429C17.2257 9.74872 17.0033 9.61217 16.8083 9.61217C16.6132 9.61217 16.3908 9.74872 16.3011 9.92429C16.223 10.0765 16.223 10.1428 16.223 14.5008C16.223 19.4714 16.2425 19.1554 15.9304 19.4636C15.6144 19.7797 16.1762 19.7563 9.00511 19.7563C1.83401 19.7563 2.39584 19.7797 2.07981 19.4636C1.76379 19.1476 1.7872 19.7094 1.7872 12.5383C1.7872 5.36725 1.76379 5.92908 2.07981 5.61305C2.38804 5.30093 2.07201 5.32043 7.04262 5.32043C11.4007 5.32043 11.467 5.32043 11.6192 5.2424C11.7947 5.15267 11.9313 4.93028 11.9313 4.7352C11.9313 4.54012 11.7947 4.31773 11.6192 4.22799C11.467 4.14996 11.4046 4.14996 6.988 4.15386C4.5261 4.15776 2.43876 4.17337 2.35292 4.18898Z"
                                                                            fill="#008451"/>
                                                                    </g>
                                                                    <defs>
                                                                        <clipPath id="clip0_2775_62570">
                                                                            <rect width="19.9761" height="19.9761"
                                                                                  fill="white"
                                                                                  transform="translate(0.616699 0.950684)"/>
                                                                        </clipPath>
                                                                    </defs>
                                                                </svg>
                                                            </a>


                                                        </div>
                                                    </div>
                                                    <div class="profile-row mt-4 "></div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div
                                            class=" points-inner-card flex-column  d-flex align-items-center justify-content-center w-100 h-100 bg-white">
                                            <span
                                                class="p-3 col-12 request-table-title"> {{__('Places & Addresses')}}</span>
                                            <div
                                                style="z-index: 9"
                                                class=" w-100 position-relative d-flex justify-content-center flex-fill empty-address d-flex align-items-center">

                                                <a href="/{{AppHelper::getSlug()}}/dashboard/addresses">
                                                    <button type="button"
                                                            class="btn btn-primary position-relative   d-md-flex  "
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="button">
                                                        {{__('Add New Address')}}
                                                    </button>

                                                </a>

                                            </div>


                                        </div>

                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class=" profile-user d-none d-md-flex">
                            <img class="profile-user-img w-100 img-fluid " src="{{asset('/images/welcome-user.png')}}"
                                 alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">


            <div id="liveToastError" class="toast" role="alert" aria-live="assertive"
                 aria-atomic="true">
                <div class="toast-header ">
                    <div class="row w-100">
                        <strong class="col-11">{{__('Dashboard Login')}}</strong>
                        <button type="button" class="btn-close col-1" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                    </div>
                </div>
                <div class="toast-body">
                </div>
            </div>
        </div>
    </main>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary d-none open-otp" data-bs-toggle="modal"
            data-bs-target="#staticBackdrop"></button>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-0">
                </div>
            </div>
        </div>
    </div>
    <script>



        $(document).on('click', '.exit-edit', function (e) {
            e.preventDefault()
            $(".save-profile").removeClass("d-flex")
            $(".save-profile").addClass("d-none")
            $('.edit-profile').removeClass("d-none")
            $('.edit-profile').addClass("d-flex")
            document.querySelectorAll(".input-personal-info").forEach(element => {
                element.classList.toggle("bg-transparent")
                element.classList.toggle("border-0")
                element.readOnly = true
            })
            $(".exit-edit").removeClass("d-block")
            $(".exit-edit").addClass("d-none")
            $("#userLoginForm").addClass("d-none")
            $(".old-phone").removeClass("d-none")
            document.querySelector("input[name=name]").value=`{{$user->name}}`;

        })

        $(document).on('click', '.edit-profile', function (e) {
            e.preventDefault()
            $(".save-profile").removeClass("d-none")
            $(".save-profile").addClass("d-flex")
            $('.edit-profile').removeClass("d-flex")
            $('.edit-profile').addClass("d-none")

            document.querySelectorAll(".input-personal-info").forEach(element => {
                element.classList.toggle("bg-transparent")
                element.classList.toggle("border-0")
                element.readOnly = false
            })
            $(".exit-edit").removeClass("d-none")
            $(".exit-edit").addClass("d-block")
            $("#userLoginForm").removeClass("d-none")
            $(".old-phone").addClass("d-none")
        })

        {{--var $noUser = {!! json_encode($noUser) !!};--}}
        var liveToastError = $('#liveToastError')
        toastBody = $('.toast-body'),
            toastTextAlreadytExist = `{{__('Phone Already Exists')}}`
            toastEditPhoneSuccess = `{{__('You will redirect to login page!')}}`
            toastEditNameSuccess = `{{__("Your personal Info has been updated")}}`
            toastTextInvalidValue = `{{__('Enter a valid number')}}`
            SomethingWrong = `{{__('Something went wrong, please try again')}}`

        $(document).ready(function () {

            function ShowToast(e, root) {
                $('.toast-body').html(e);
                toast = new bootstrap.Toast($(`#${root}`))
                toast.show()
            }

            function allnumeric(inputTxt) {
                var numbers = /^[0-9]+$/;
                if (inputTxt.match(numbers))
                    return true
                else return false
            }

            const spinner = `<div class="spinner-border text-info" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>`;
            const saveHtml = `<span class="d-none d-md-flex ">
                 {{__("Save")}}
            </span>
        <svg width="22" height="22" viewBox="0 0 22 22"
             fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path
                d="M1.55029 1.03493C0.824115 1.15801 0.167689 1.83085 0.0446091 2.57753C-0.00872549 2.90574 -0.00872549 20.0877 0.0446091 20.4159C0.167689 21.1831 0.820012 21.8354 1.58721 21.9585C1.91542 22.0118 19.0974 22.0118 19.4256 21.9585C20.1928 21.8354 20.8451 21.1831 20.9682 20.4159C20.9928 20.2682 21.0092 17.2979 21.0092 12.6947C21.0092 6.11813 21.001 5.19503 20.9477 5.08016C20.8656 4.90784 17.0419 1.09237 16.8942 1.03903C16.7547 0.985699 1.85799 0.985699 1.55029 1.03493ZM3.81906 4.8381C3.81906 6.52839 3.83547 7.84535 3.86008 7.98894C3.94214 8.49357 4.31958 9.05563 4.74626 9.3059C4.83652 9.35923 5.02114 9.44128 5.15242 9.48641C5.38627 9.56847 5.49294 9.56847 10.0141 9.56847C15.1342 9.56847 14.8388 9.58488 15.3106 9.29769C15.6922 9.06794 15.9629 8.73152 16.1352 8.27203C16.2255 8.02997 16.2255 8.00535 16.2419 4.98169L16.2542 1.93752H16.3855C16.5045 1.93752 16.6932 2.11393 18.2932 3.71397L20.0656 5.48632L20.0574 12.9121C20.0451 20.0672 20.041 20.3421 19.9671 20.4815C19.8605 20.6826 19.7046 20.8426 19.5117 20.9451C19.3722 21.019 19.2574 21.0354 18.7445 21.0477L18.1373 21.0641V16.465C18.1373 11.3859 18.1538 11.6936 17.8748 11.5624C17.7476 11.5008 17.1117 11.4967 10.5064 11.4967C3.90111 11.4967 3.2652 11.5008 3.13802 11.5624C2.85903 11.6936 2.87545 11.3859 2.87545 16.465V21.0641L2.27235 21.0477C1.78824 21.0354 1.63644 21.0149 1.52157 20.9575C1.32054 20.8549 1.16053 20.6949 1.05797 20.5021L0.967708 20.338V11.4967C0.967708 2.95087 0.97181 2.65138 1.04566 2.51189C1.19335 2.22881 1.4231 2.04419 1.70619 1.97444C1.77593 1.95803 2.27646 1.94572 2.82621 1.94162L3.81906 1.93752V4.8381ZM15.2655 4.92015C15.2655 7.72227 15.2573 7.91509 15.1875 8.071C15.0932 8.28023 14.8224 8.52639 14.6214 8.57973C14.5147 8.60844 13.0213 8.62485 9.99356 8.62485C5.75141 8.62485 5.51346 8.62075 5.35755 8.5469C5.15242 8.45665 4.9637 8.27203 4.86113 8.06279C4.78728 7.91509 4.78318 7.75919 4.77087 4.97759C4.76677 3.36524 4.77087 2.01957 4.77908 1.99085C4.79549 1.94572 5.735 1.93752 10.0346 1.93752H15.2655V4.92015ZM17.1937 16.7481V21.0559H10.5064H3.81906V16.7481V12.4403H10.5064H17.1937V16.7481Z"
                fill="#008451"/>
        </svg>`


            $(document).on('click', '.save-button', function (e) {

                e.preventDefault();
                $('.save-button').html(spinner)
                if (allnumeric(window.phone.value) || window.phone.value.length == 0) {
                    if ($('.field-login-hidden').val().length > 0 && $('.input-personal-info-name').val().length > 0) {
                        var data = {
                            'phone': $('.field-login-hidden').val(),
                            'name': $('.input-personal-info-name').val(),
                        }
                    } else if ($('.field-login-hidden').val().length > 0) {
                        var data = {
                            'phone': $('.field-login-hidden').val(),
                        }
                    } else if ($('.input-personal-info-name').val().length > 0) {
                        var data = {
                            'name': $('.input-personal-info-name').val(),
                        }
                    } else {
                        var data = {}
                    }
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "profile/update",
                        data: data,
                        dataType: "html",
                        success: (response) => {
                            const res = response
                            ShowToast(toastEditPhoneSuccess, "liveToastError")
                            jsonRes = JSON.parse(res)
                            window.location = jsonRes.link
                        },
                        error: (response) => {
                            const res = response
                            console.log(res)
                            switch (res.status) {
                                case 500:
                                    ShowToast(SomethingWrong, "liveToastError")
                                    $('.save-button').html(saveHtml)
                                    break;
                                case 422 :
                                    ShowToast(toastTextAlreadytExist, "liveToastError")
                                    $('.save-button').html(saveHtml)
                                    break;
                                case 302 :
                                    ShowToast(toastEditNameSuccess, "liveToastError")
                                    jsonRes = JSON.parse(res.responseText)
                                    window.location = jsonRes.link
                                    break;
                                default :
                                    $('.save-button').html(saveHtml)
                                    console.log("default")
                                    break;
                            }
                        },
                    })
                } else {
                    ShowToast(toastTextInvalidValue, "liveToastError")
                    $('.save-button').html(saveHtml)
                }
            })
        })

    </script>

@endsection
