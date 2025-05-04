@php
    use App\Helpers\AppHelper;
@endphp
@extends('auth.dashboard-layout')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">

    @if(App::getLocale() == 'ar')
        <style>
            .toast-header strong {
                text-align: right
            }

            ul#pills-tab li .nav-link:before {
                transform-origin: left;
            }

            ul#pills-tab li:nth-Child(2n) .nav-link:before {
                transform-origin: right;
            }


        </style>
    @else
        <style>


            ul#pills-tab li .nav-link:before {
                transform-origin: right;
            }

            ul#pills-tab li:nth-Child(2n) .nav-link:before {
                transform-origin: left;
            }
        </style>
    @endif
@endsection

@section('script')
    <script>
        const
            labelTab = document.querySelector(".label-tab"),
            boxInputs = document.querySelector(".box-inputs"),
            textPhone = "{{__('Phone')}}",
            codeNumber = "{{$code_number}}",
            flagSvg = "{{$flag}}",
            selectInput = `
                <P class="border-0 dir-rtl code-phone d-flex align-items-center justify-content-center   ">

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
            window.phone.onkeypress = (e) => {
                if (!allnumeric(e.key)) {
                    if (allnumericAr(e.key)) {
                        e.preventDefault()
                        convertNumber(e.key) !== -1 ?
                        document.getElementById("phone").value += +convertNumber(e.key) :false
                    } else {
                        e.preventDefault()
                    }
                }
            }
            window.phone.onkeyup = () => {
                window.loginHidden.value = `+${+codeNumber}${+window.phone.value}`
            }
        }
    </script>

@endsection

@section('content')
    <body class="login-body">
    <main id="login-page">
        <section class="login-form">
            <div class="form w-100">
                <div class="signin">
                    <h1 class="log-title">{{__('Sign in')}}</h1>

                    <form id="userLoginForm" class="mt-4" method="POST" action="validate-login">
                        @csrf
                        <div class="form-item">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-phone" role="tabpanel"
                                     aria-labelledby="pills-phone-tab" tabindex="0">
                                    <label for="login" class="text-center">
                                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12.3612 11.1542C12.2612 11.1442 12.1412 11.1442 12.0312 11.1542C9.65117 11.0742 7.76117 9.12418 7.76117 6.72418C7.76117 4.27418 9.74117 2.28418 12.2012 2.28418C14.6512 2.28418 16.6412 4.27418 16.6412 6.72418C16.6312 9.12418 14.7412 11.0742 12.3612 11.1542Z"
                                                stroke="#8696BB" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path
                                                d="M7.36114 14.8442C4.94114 16.4642 4.94114 19.1042 7.36114 20.7142C10.1111 22.5542 14.6211 22.5542 17.3711 20.7142C19.7911 19.0942 19.7911 16.4542 17.3711 14.8442C14.6311 13.0142 10.1211 13.0142 7.36114 14.8442Z"
                                                stroke="#8696BB" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span class="label-tab">
                                                    {{__('Phone')}}
                                        </span>
                                    </label>

                                    <div class=" d-flex align-items-center box-inputs">
                                        <input id="phone"
                                               type="tel"
                                               class="dir-ltr field field-login is_number form-control my-0 @error('phone') is-invalid @enderror"
                                               value="" required
                                               autocomplete="phone"
                                               autofocus
                                               pattern="[0-9]"
                                        >
                                        <input id="loginHidden" type="hidden" name="login" class="field-login-hidden">
                                    </div>
                                    @error('login')
                                    <p class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </p>
                                    @enderror
                                </div>

                            </div>


                        </div>
                        <div class="form-item mt-5 d-flex justify-content-center position-relative">
                            <div class="col-12 position-relative">
                                <button style="background-color:  #008451;" type="submit"
                                        class="btn signin-btn w-100 login-button"
                                >{{__('Sign in')}}
                                    <div
                                        class="lds-ellipsis lds-ellipsis-login d-none position-absolute start-50 top-50 translate-middle">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </button>
                            </div>


                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                        <div class="justify-content-center text-center mt-4"><span> {{__('have account ?')}} <a
                                    style="color:  #008451;!important;"
                                    href="/{{AppHelper::getSlug()}}/auth/register">{{__('create new account')}} </a></span>
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
                    </form>
                </div>
            </div>
        </section>
    </main>

    </body>
    <button type="button" class="btn btn-primary d-none open-otp" data-bs-toggle="modal"
            data-bs-target="#staticBackdrop"></button>

    <!-- Modal -->
    <div class="modal fade p-0" id="staticBackdrop" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-0">

                </div>
            </div>
        </div>
    </div>



    <script>


        document.addEventListener("DOMContentLoaded", function () {
            var $noUser = {!! json_encode($noUser) !!};
            var liveToastError = $('#liveToastError')
            toastBody = $('.toast-body'),
                toastTextNotExist = `{{__('Phone Doesnt Exist')}}`
            toastTextEmptyValue = `{{__('Please Enter Your Number')}}`
            toastLoginSuccess = `{{__('Dashboard Login')}}`
            toastTextInvalidValue = `{{__('Enter a valid number')}}`
            SomethingWrong = `{{__('Something went wrong, please try again')}}`
            AgentLogin = `{{__('Sorry, your account type is Agent')}}`
            AdminLogin = `{{__('Sorry, your account type is Admin')}}`

            $(document).ready(function () {
                function allnumeric(inputTxt) {
                    var numbers = /^[0-9]+$/;
                    if (inputTxt.match(numbers))
                        return true
                    else return false
                }

                function showSpinnerLogin(element) {
                    $('.lds-ellipsis-login').toggleClass('d-none');
                    element.target.classList.toggle("disabled");
                    element.target.classList.toggle("text-transparent");
                }

                function ShowToast(e, root) {
                    $('.toast-body').html(e);
                    toast = new bootstrap.Toast($(`#${root}`))
                    toast.show()
                }


                function userNotFound(element) {
                    showSpinnerLogin(element)
                    ShowToast(toastTextNotExist, "liveToastError")
                }

                $(document).on('click', 'button[type="submit"].login-button', function (e) {
                    e.preventDefault();
                    if (window.phone.value.length == 0) {
                        ShowToast(toastTextEmptyValue, "liveToastError")
                    } else {
                        if (allnumeric(window.phone.value)) {
                            showSpinnerLogin(e)
                            var data = {
                                'login': $('.field-login-hidden').val(),
                            }
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: "POST",
                                url: "validate-login",
                                data: data,
                                dataType: "html",
                                success: (response) => {
                                    // ShowToast(toastLoginSuccess, "liveToastError")
                                    $(".modal-body").html(response)
                                    $(".open-otp").click()
                                    showSpinnerLogin(e)

                                },
                                error: (response) => {
                                    const res = response
                                    switch (res.status) {
                                        case 500:
                                            ShowToast(SomethingWrong, "liveToastError")
                                            showSpinnerLogin(e)
                                            break;
                                        case 403:
                                            switch (JSON.parse(res.responseText).message) {
                                                case {{\App\Enums\UserType::ADMIN}}:
                                                    ShowToast(AdminLogin, "liveToastError")
                                                    showSpinnerLogin(e)
                                                    break;
                                                case {{\App\Enums\UserType::AGENT}}:
                                                    ShowToast(AgentLogin, "liveToastError")
                                                    showSpinnerLogin(e)
                                                    break;
                                            }
                                            break;
                                        default :
                                            userNotFound(e);
                                            break;
                                    }
                                },
                            })
                        } else {
                            ShowToast(toastTextInvalidValue, "liveToastError")
                        }
                    }
                })


            })

        });


    </script>

@endsection








