@php
    use App\Helpers\AppHelper;
@endphp
@extends('auth.dashboard-layout')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">

@endsection

@section('script')
    <script>
        const validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/,
            numbers = /^[0-9]+$/,
            usernameRegex = /^[a-zA-Z0-9 -  ]+$/,

            ValidatePhoneNumber = () => !!window.phone.value.match(numbers),
            isUserNameValid = () => !!window.username.value.match(usernameRegex),
            formIsValid = () => !!(ValidatePhoneNumber() && isUserNameValid()),
            showSpinnerElement = (element) => {
                document.querySelector('.lds-ellipsis').classList.replace('d-none', 'd-block');
                element.classList.add("disabled");
                element.classList.add("text-transparent")
            },
            showSpinner = (element) => formIsValid() ? showSpinnerElement(element) : false;
    </script>
    <script>
        var form = document.querySelector('#registerForm')
        form.addEventListener('invalid', (element) => {
            showSpinner(element);
        }, true)
    </script>


@endsection

@section('content')
    <body class="login-body">
    <main id="register-page">
        <div class="container">
            <div class="form row d-flex justify-content-center align-items-center p-2">
                <div class="reg col-12 col-md-11 col-lg-6 col-xl-5 col-xxl-4 p-3">
                    <h1 class="log-title">{{__('Register')}}</h1>
                    <form id="registerForm" class="reg-form" method="POST" action="validate-register">
                        @csrf
                        <div class="form-item">
                            <label for="username">
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.3612 11.1542C12.2612 11.1442 12.1412 11.1442 12.0312 11.1542C9.65117 11.0742 7.76117 9.12418 7.76117 6.72418C7.76117 4.27418 9.74117 2.28418 12.2012 2.28418C14.6512 2.28418 16.6412 4.27418 16.6412 6.72418C16.6312 9.12418 14.7412 11.0742 12.3612 11.1542Z"
                                        stroke="#8696BB" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path
                                        d="M7.36114 14.8442C4.94114 16.4642 4.94114 19.1042 7.36114 20.7142C10.1111 22.5542 14.6211 22.5542 17.3711 20.7142C19.7911 19.0942 19.7911 16.4542 17.3711 14.8442C14.6311 13.0142 10.1211 13.0142 7.36114 14.8442Z"
                                        stroke="#8696BB" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                {{__('Username')}}</label>
                            <input id="username" type="text" class="register-field is_number form-control
                                   @error('username') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}" required autocomplete="name"
                                   autofocus>
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-item">
                            <label for="phone">
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <mask id="mask0_1995_59379" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0"
                                          y="0" width="25" height="24">
                                        <rect x="0.201172" width="24" height="24" fill="#D9D9D9"/>
                                    </mask>
                                    <g mask="url(#mask0_1995_59379)">
                                        <rect x="7.26418" y="4.51553" width="9.18981" height="14.5665" rx="1.65"
                                              stroke="#8696BB" stroke-width="0.7"/>
                                        <path d="M10.1332 17.0864H13.4358" stroke="#8696BB" stroke-width="0.7"
                                              stroke-linecap="round"/>
                                    </g>
                                </svg>
                                {{__('Phone')}}
                            </label>
                            <div class=" d-flex align-items-center box-inputs">
                                <input id="phone" type="tel"
                                       class=" dir-ltr register-field is_number is_number form-control @error('phone') is-invalid @enderror"
                                       value="" required
                                       autocomplete="phone"
                                       autofocus
                                       pattern="[0-9]"

                                >
                                <P class="dir-ltr code-phone d-flex align-items-center justify-content-center bg-transparent border-0 ">
                                    <span class="d-inline-block mx-1">
                                 <img src="" alt="" class="img-fluid img-flag ">
                                </span>
                                    <span class="is_number d-inline-block span-code-number"></span>

                                </P>
                                <input id="phoneHidden" type="hidden" name="phone" class="field-login-hidden">


                            </div>
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-item position-relative ">
                            <button style="background-color:  #008451;" type="submit"
                                    class="btn signin-btn sign-up-button">{{__('Register')}}
                                <div
                                    class="lds-ellipsis lds-ellipsis-register d-none position-absolute start-50 top-50 translate-middle">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </button>
                        </div>

                        <div class="error-container mt-4">
                            @if($errors->any())
                                {{ implode('', $errors->all(':message')) }}
                        </div>
                        @endif


                        <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">


                            <div id="liveToastError" class="toast" role="alert" aria-live="assertive"
                                 aria-atomic="true">
                                <div class="toast-header ">
                                    <div class="d-flex align-items-center justify-content-between w-100">
                                        <strong class=" ">{{__('Dashboard Login')}}</strong>
                                        <button type="button" class="btn-close col-1" data-bs-dismiss="toast"
                                                aria-label="Close"></button>
                                    </div>
                                </div>
                                <div class="toast-body d-flex flex-wrap">
                                </div>
                            </div>


                        </div>
                    </form>
                </div>

            </div>
        </div>
    </main>
    </body>


    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary d-none open-otp" data-bs-toggle="modal" data-bs-target="#staticBackdrop"></button>

    <!-- Modal -->
    <div class="modal fade p-0" id="staticBackdrop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-0">

                </div>
            </div>
        </div>
    </div>



    <script>
        let codeNumber = "{{$code_number}}",
            flagSvgIcon = "{{$flag}}",
            flag = document.querySelector(".img-flag"),
            codeText = document.querySelector(".span-code-number");
        flag.setAttribute("src", flagSvgIcon)
        codeText.innerHTML = codeNumber;
        window.phone.addEventListener("keyup", () => {
            window.phoneHidden.value = `+${+codeNumber}${+window.phone.value}`
        })

    </script>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <script>
        var toastTextEmptyValueNumber = `{{__('Please Enter Your Number')}}`,
            toastTextEmptyValueName = `{{__('Please Enter Your Name')}}`,
            toastLoginSuccess = `{{__('Dashboard Login')}}`,
            toastTextInvalidValue = `{{__('Enter a valid number')}}`,
            SomethingWrong = `{{__('Something went wrong, please try again')}}`;
            phoneExsits = `{{__('Phone Already Exists')}}`;

        $(document).ready(function () {
            function showSpinnerRegister(element) {
                $('.lds-ellipsis-register').toggleClass('d-none');
                element.target.classList.toggle("disabled");
                element.target.classList.toggle("text-transparent")
            }

            function ShowToast(e) {
                $('.toast-body').html(e);
                toast = new bootstrap.Toast($('#liveToastError'))
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

            $(document).on('click', 'button[type="submit"].sign-up-button', function (e) {
                e.preventDefault();
                if ($("#username").val().length === 0) {
                    ShowToast(toastTextEmptyValueName)
                    removeInputValue("username")
                } else if ($("#phone").val().length === 0) {
                    ShowToast(toastTextEmptyValueNumber)
                    removeInputValue("phone")
                } else {
                    $("#username").hasClass("border-danger") ? $("#username").removeClass("border-danger") : false;
                    if (allnumeric($("#phone").val())) {
                        $("#phone").hasClass("border-danger") ? $("#phone").removeClass("border-danger") : false;
                        showSpinnerRegister(e)
                        var data = {
                            'name': $('#username').val(),
                            "phone": $("#phoneHidden").val()
                        }
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "POST",
                            url: "validate-register",
                            data: data,
                            dataType: "html",
                            success: (response) => {
                                const res = response
                                ShowToast(toastLoginSuccess)
                                $(".modal-body").html(res)
                                $(".open-otp").click()
                                showSpinnerRegister(e)
                            },
                            error: (response) => {
                                const res = response
                                switch (res.status) {
                                    case 500:
                                        ShowToast(SomethingWrong)
                                        showSpinnerRegister(e)
                                        break;
                                    case 422:
                                        ShowToast(phoneExsits)
                                        showSpinnerRegister(e)
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
            })
        })
    </script>




@endsection
