@if(App::getLocale() == 'ar')
    <style>
        .pin-code {
            direction: ltr;
        }
    </style>

@endif

<div class="position-fixed top-0 end-0 p-3" style="z-index: 11">


    <div id="liveToastErrorOtp" class="toast" role="alert" aria-live="assertive"
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


<div class="signin p-0" id="otp-dialog">
    <div
        class="redirectMessage w-100 pt-4  d-flex align-items-center justify-content-center flex-column overflow-hidden d-none gap-5">
        <img src="{{url("/images/logo.png")}}" alt="logo" class="img-fluid "/>
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                 class="bi bi-check2-circle display-1 text-success" viewBox="0 0 16 16">
                <path class="layer1"
                      d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                <path class="layer2"
                      d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
            </svg>


            <p class="fs-5 mt-2 text-  text-center">
                {{__("will be redirected to the control panel")}}
            </p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="wave">
            <path fill="#0099ff" fill-opacity="1"
                  d="M0,192L34.3,165.3C68.6,139,137,85,206,64C274.3,43,343,53,411,85.3C480,117,549,171,617,165.3C685.7,160,754,96,823,90.7C891.4,85,960,139,1029,160C1097.1,181,1166,171,1234,149.3C1302.9,128,1371,96,1406,80L1440,64L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
        </svg>
    </div>

    <div class="p-1 p-md-5 main-box">
        <div class="form-header justify-content-center align-items-center d-flex flex-column">
            <svg width="125" height="137" viewBox="0 0 125 137" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M108.341 234.332H16.9049C8.19189 234.332 1.05066 227.185 1.05066 218.464V17.3195C1.05066 8.59821 8.19189 1.45166 16.9049 1.45166H108.341C117.054 1.45166 124.196 8.59821 124.196 17.3195V218.464C124.196 227.185 117.054 234.332 108.341 234.332Z"
                    stroke="#DEDDDD"/>
                <path
                    d="M118.534 33.1777V216.736C118.534 222.971 113.131 228.061 106.505 228.061H18.7198C12.1148 228.061 6.69147 222.971 6.69147 216.736V33.1777C6.69147 26.9427 12.0937 21.8521 18.7198 21.8521H106.526C113.131 21.8521 118.534 26.9624 118.534 33.1777Z"
                    fill="#EEFBFF"/>
                <path
                    d="M80.9716 17.4491H44.2747C41.5547 17.4491 39.3303 15.2235 39.3303 12.5002V11.6554C39.3303 8.93219 41.5547 6.70654 44.2747 6.70654H80.9716C83.6916 6.70654 85.916 8.93219 85.916 11.6554V12.4983C85.8959 15.2454 83.6693 17.4491 80.9716 17.4491Z"
                    stroke="#DEDDDD"/>
                <path
                    d="M23.6365 19.0301L22.3915 19.9382L21.1254 19.0512C21.3997 18.6499 21.8639 18.3965 22.3915 18.3965C22.898 18.3965 23.3622 18.6499 23.6365 19.0301Z"
                    fill="#DEDDDD"/>
                <path
                    d="M22.3704 16.2002C21.1042 16.2002 20.0069 16.8338 19.3316 17.7842L20.1335 18.3333C20.64 17.6363 21.463 17.1717 22.3915 17.1717C23.32 17.1717 24.1219 17.6152 24.6283 18.3333L25.4302 17.7631C24.7338 16.8127 23.6154 16.2002 22.3704 16.2002Z"
                    fill="#DEDDDD"/>
                <path
                    d="M22.3704 12.0396C19.7115 12.0396 17.3481 13.3701 15.9342 15.3976L16.7361 15.9467C17.9811 14.1726 20.0491 13.0111 22.3915 13.0111C24.6917 13.0111 26.7597 14.1515 28.0047 15.9045L28.7855 15.3342C27.3505 13.349 25.0293 12.0396 22.3704 12.0396Z"
                    fill="#DEDDDD"/>
                <path
                    d="M22.3704 14.3203C20.4712 14.3203 18.8042 15.2496 17.7701 16.6857L18.572 17.2348C19.4161 16.0521 20.8089 15.2707 22.3704 15.2707C23.932 15.2707 25.3037 16.031 26.1478 17.1926L26.9285 16.6224C25.9156 15.2496 24.2486 14.3203 22.3704 14.3203Z"
                    fill="#DEDDDD"/>
                <g clip-path="url(#clip0_2961_65651)">
                    <path d="M62.925 61.501L26.3282 90.2062V138.457H101.246L99.1647 89.7887L62.925 61.501Z"
                          fill="#008451"/>
                    <path
                        d="M29.2598 98.1131V72.109L92.2789 70.6479L93.7324 108.304L69.9463 127.85L47.2072 126.192L29.2598 98.1131Z"
                        fill="white"/>
                    <path
                        d="M26.3281 91.041L62.0874 118.494L97.28 91.041L101.282 138.457H24.9919L26.3281 91.041Z"
                        fill="#008451"/>
                    <path d="M26.3281 137.009L51.1613 112.755" stroke="#232323" stroke-width="0.5"
                          stroke-miterlimit="10"/>
                    <path d="M99.4973 137.009L74.6641 112.755" stroke="#232323" stroke-width="0.5"
                          stroke-miterlimit="10"/>
                    <path d="M45.7267 87.7685L60.647 102.689L88.766 74.5698" stroke="#6FCF97"
                          stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                </g>
                <defs>
                    <clipPath id="clip0_2961_65651">
                        <rect width="77" height="78" fill="white" transform="translate(24.2464 61.501)"/>
                    </clipPath>
                </defs>
            </svg>

            <h1 class="log-title">{{__('OTP')}}</h1>
            <span class="card-subtitle ">{{__('Please enter the verification code sent to')}}</span>
            <p id="verification-number" class="dir-ltr card-subtitle is_number"></p>

        </div>
        <form id="userLoginForm" class="mt-4" method="POST">
            @csrf

            <div class="form-item" style="display: none">
                <input  type="input" class="field form-control   "
                       value="{{ Session::get('data')}}"
                       name="login"
                       autofocus>
            </div>
            <div class="pin-code jpa  dir-ltr">
                <input type="tel" class="form-control is_number number text-dark fs-5" maxlength="1"/>
                <input type="tel" class="form-control is_number number text-dark fs-5" maxlength="1"/>
                <input type="tel" class="form-control is_number number text-dark fs-5" maxlength="1"/>
                <input type="tel" class="form-control is_number number text-dark fs-5" maxlength="1"/>
                <input type="tel" class="form-control is_number number text-dark fs-5" maxlength="1"/>
                <input type="tel" class="form-control is_number number text-dark fs-5" maxlength="1"/>
            </div>
            <div class="form-item mt-5 position-relative">
                <button style="background-color:  #008451;" type="submit"
                        class="btn signin-btn otp-button">{{__('Verify')}}
                    <div
                        class="lds-ellipsis lds-ellipsis-otp d-none position-absolute start-50 top-50 translate-middle">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </button>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $(".pin-code input").jqueryPincodeAutotab();
    })
</script>





<script>
    try {
        let str = "{{Session::get('data')}}",
            repeat = str.length - 6;
        str = `${str.slice(0, 4)}${'*'.repeat(repeat)}${str.slice(-2)}`
        document.getElementById("verification-number").innerText = str;
    } catch (e) {
    }
    var code = '';
    var pinContainer = document.querySelector(".pin-code");

    // pinContainer.addEventListener('keyup', function (event) {
    //     var target = event.srcElement;
    //
    //     var maxLength = parseInt(target.attributes["maxlength"].value, 10);
    //     var myLength = target.value.length;
    //
    //     if (myLength >= maxLength) {
    //         var next = target;
    //         while (next = next.nextElementSibling) {
    //             if (next == null) break;
    //             if (next.tagName.toLowerCase() == "input") {
    //                 next.focus();
    //                 break;
    //             }
    //         }
    //     }
    //     if (myLength === 0) {
    //         var next = target;
    //         while (next = next.previousElementSibling) {
    //             if (next == null) {
    //                 break;
    //             }
    //             if (next.tagName.toLowerCase() == "input") {
    //                 next.focus();
    //                 break;
    //             }
    //         }
    //     }
    // }, false);
    // pinContainer.addEventListener('keydown', function (event) {
    //     var target = event.srcElement;
    //     if (event.key == "Enter") {
    //         // event.preventDefault();
    //     }
    // }, false);
</script>




<script>
    toastBodyOtp = document.querySelector("#liveToastErrorOtp .toast-body")
    toastTextInvalidValueOtp = "{{__('All fields are required')}}"
    toastInvalidCode = "{{__('Invalid Code')}}"
    $(document).ready(function () {
        function showSpinnerOtp(element) {
            $('.lds-ellipsis-otp').toggleClass('d-none');
            element.target.classList.toggle("disabled");
            element.target.classList.toggle("text-transparent")
        }

        function allnumericOtp(inputTxt) {
            var numbers = /^[0-9]+$/;
            if (inputTxt.match(numbers))
                return true
            else return false
        }

        function removerAllField() {
            codeFields = document.querySelectorAll(".jpa input")
            codeFields.forEach(ele => {
                ele.value = ""
                if (ele.classList.contains("border-danger")) {
                    ele.classList.remove("border-danger")
                }
            })
            otpCode = ""
            codeFields[0].focus();
        }

        function getRedirectMessage() {
            $(".redirectMessage").removeClass("d-none");
            $(".main-box").addClass("d-none")
        }

        function ShowToastOtp(e) {
            $('.toast-body').html(e);
            toast = new bootstrap.Toast($('#liveToastErrorOtp'))
            toast.show()
        }

        let isRedirected = false;
        console.log(isRedirected);

        $(document).on('click', 'button[type="submit"].otp-button', function (e) {
            e.preventDefault();
            codeFields = document.querySelectorAll(".jpa input")
            var boolField = true;
            codeFields.forEach(ele => {
                boolField *= allnumericOtp(ele.value.toString())
            })
            if (boolField) {
                showSpinnerOtp(e)
                otpCode = []
                codeFields.forEach(input=>{
                    otpCode.push(input.value)
                })
                var data = {
                    'code': otpCode.join(''),
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "validate-otp",
                    data: data,
                    dataType: "json",
                    success: (response) => {
                        const res = response
                        getRedirectMessage()
                        if (!isRedirected) {
                            isRedirected = true;
                            ShowToastOtp(toastLoginSuccess)
                            window.location = `${res.message}`
                        }
                    },
                    error: (response) => {
                        const res = response;
                        ShowToastOtp(toastInvalidCode)
                        showSpinnerOtp(e)
                        removerAllField()
                    }
                })
            } else {
                codeFields.forEach(ele => {
                    if (ele.value.length === 0) {
                        ele.classList.add("border-danger")
                    } else {
                        if (ele.classList.contains("border-danger")) {
                            ele.classList.remove("border-danger")
                        }
                    }
                })
                ShowToastOtp(toastTextInvalidValueOtp)
                console.log("error")
            }
        })
    })
</script>
