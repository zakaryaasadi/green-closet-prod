@php
    use App\Helpers\AppHelper
@endphp
<html>
<head>
    @include('auth.dashboard-app')

    @yield('style')
    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.1.0/daterangepicker.min.css"/>

    <style>

    </style>
    @if(App::getLocale() == 'en')
        <style>
            * {
                direction: ltr
            }

            .dropdown-toggle::before {
                display: inline-block;
                margin-left: 0.255em;
                vertical-align: 0.255em;
                content: "";
                border-top: 0.3em solid;
                border-right: 0.3em solid transparent;
                border-bottom: 0;
                border-left: 0.3em solid transparent;
            }

            @media screen and (min-width: 991px) {
                .dropdown-menu[data-bs-popper] {
                    left: auto !important;
                    right: 0 !important;
                }
            }

            @media screen and (max-width: 991px) {
                .dropdown-menu:not(.lang)[data-bs-popper] {
                    left: auto !important;
                    right: 0 !important;
                }
            }
        </style>
    @else
        <style>
            * {
                direction: rtl
            }

            footer * {
                direction: ltr;
            }

            .dropdown-toggle::before {
                display: inline-block;
                margin-left: 0.255em;
                vertical-align: 0.255em;
                content: "";
                border-top: 0.3em solid;
                border-right: 0.3em solid transparent;
                border-bottom: 0;
                border-left: 0.3em solid transparent;
            }

            .dropdown-toggle::after {
                display: none;
            }

            @media screen and (max-width: 991px) {
                .dropdown-menu.lang[data-bs-popper] {
                    left: auto !important;
                }

                .dropdown-menu[data-bs-popper] {
                    left: 0 !important;
                }

                .dropdown-notification {
                    right: 0;
                }

                .dropdown-notification.show:after {
                    left: 90%;
                }

                .container-dropdown-notification {
                    width: 95vw;
                }
            }

            .pagination-number {
                direction: ltr;
            }
        </style>
    @endif

</head>
<body>

@include('layouts.header')



@yield('content')

<div class="position-fixed top-0 w-100 h-100 loader scene d-flex align-items-center justify-content-center">
    <lottie-player
        src="https://lottie.host/6649581b-2984-4eda-8571-40d8aafdef48/LUV2opUyHM.json"
        background="transparent"
        speed="1"
        style="width: 300px; height: 300px;"
        loop
        autoplay>
    </lottie-player>
</div>

@if((str_contains(request()->url(), '/auth')))
    @include('layouts.footer')
@else
    @include('layouts.footerDashboard')
@endif



@yield('script')
<script defer>
    if ('loading' in HTMLImageElement.prototype) {
        const images = document.querySelectorAll('img[loading="lazy"]');
        images.forEach(img => {
            img.src = img.dataset.src;
        });
    } else {
        // Dynamically import the LazySizes library
        const script = document.createElement('script');
        script.src =
            'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.1.2/lazysizes.min.js';
        document.body.appendChild(script);
    }
</script>
<script>
    const counters = document.querySelectorAll('.count');
    const speed = 300;

    counters.forEach(counter => {
        const animate = () => {
            const value = +counter.getAttribute('data-target');
            const data = +counter.innerText;

            const time = value / speed;
            if (data < value) {
                counter.innerText = Math.ceil(data + time);
                setInterval(animate, 300);
            } else {
                counter.innerText = value;
            }

        }

        animate();
    });


</script>


<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js" defer></script>
<script src="{{ mix('js/dashboard.js') }}"></script>
<script>
    flagImage = document.querySelectorAll(".flag-image-ar")


    var url = "{{'https://restcountries.com/v3.1/alpha/'.AppHelper::getLocationSettings()->country->code}}";

    var requestOptions = {
        method: 'GET',
        redirect: 'follow'
    };

    async function getFlugsFetch() {
        const data = await fetch(url, requestOptions)
            .then(response => response.json())
            .catch(error => console.log('error', error));
        flagImage.forEach(e => {
            e.setAttribute('src', data[0].flags.png)
        })
    }

    getFlugsFetch()


</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.1.0/daterangepicker.min.css"/>

<script async src="{{ mix('js/jqueryPincodeAutotab.js') }}"></script>


<script>


    function convertNumber(x) {
        return x.replace(/[\u0660-\u0669\u06f0-\u06f9]/g, c => c.charCodeAt(0) & 0xf);

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
</body>
</html>
