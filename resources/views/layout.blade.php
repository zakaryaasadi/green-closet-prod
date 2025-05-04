<html>
<head>
    @include('layouts.app')
    @yield('style')
    @if(App::getLocale() == 'en')
        <style>
            * {
                direction: ltr
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

            /*footer * {*/
            /*    direction: ltr;*/
            /*}*/

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
                    left: auto;
                }
                .dropdown-notification{
                    right: 0;
                }
                .dropdown-notification.show:after{
                    left: 90%;
                 }
                .container-dropdown-notification{
                    width: 95vw;
                }
            }
        </style>
    @endif
    <script>
        const ua = navigator.userAgent.toLowerCase();
        const is_safari = (ua.indexOf("safari/") > -1 && ua.indexOf("chrome") < 0);
        if (is_safari) {
            const video = document.getElementById('video');
            setTimeout(function () {
                video.play();
            }, 0);
        }
    </script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</head>
<body>

<div class="position-fixed top-0 w-100 h-100 loader scene d-flex align-items-center justify-content-center">
    <lottie-player
        src="/storage/green-closet-loader.json"
        background="transparent"
        speed="1"
        style="width: 300px; height: 300px;"
        loop
        autoplay>
    </lottie-player>
</div>

@include('layouts.header')

@yield('content')


@include('layouts.footer')



@yield('script')

<script src="{{ mix('js/main.js') }}"></script>






{{--<script type="module">--}}
{{--// Import the functions you need from the SDKs you need--}}
{{--import{ initializeApp } from "https://www.gstatic.com/firebasejs/9.9.4/firebase-app.js";--}}
{{--import{ getAnalytics } from "https://www.gstatic.com/firebasejs/9.9.4/firebase-analytics.js";--}}
{{--// TODO: Add SDKs for Firebase products that you want to use--}}
{{--// https://firebase.google.com/docs/web/setup#available-libraries--}}

{{--// Your web app's Firebase configuration--}}
{{--// For Firebase JS SDK v7.20.0 and later, measurementId is optional--}}
{{--const firebaseConfig ={--}}
{{--authDomain:"kiswa-client.firebaseapp.com",--}}
{{--    apiKey:"AIzaSyCrB17yIWeMaLGL-g5LBZkHS42agZAKRHQ",--}}
{{--    projectId:"kiswa-client",--}}
{{--storageBucket:"kiswa-client.appspot.com",--}}
{{--messagingSenderId:"690109941902",--}}
{{--appId:"1:690109941902:web:1cfc1d2fefb3056336e1df",--}}
{{--measurementId:"G-0X92CTWFQT"--}}
{{--};--}}

{{--// Initialize Firebase--}}
{{--const app = initializeApp(firebaseConfig);--}}
{{--const analytics = getAnalytics(app);--}}
{{--</script>--}}


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
    AOS.init({
        once: true
    });
</script>
{{--<script async>--}}
{{--    flagImage = document.querySelectorAll(".flag-image-ar")--}}

{{--    window.addEventListener("load",()=>{--}}
{{--        var url = "{{'https://restcountries.com/v3.1/alpha/'.\App\Helpers\AppHelper::getLocationSettings()->country->code}}";--}}

{{--        var requestOptions = {--}}
{{--            method: 'GET',--}}
{{--            redirect: 'follow'--}}
{{--        };--}}

{{--        async function getFlugsFetch() {--}}

{{--            const data = await fetch(url, requestOptions)--}}
{{--                .then(response => response.json())--}}
{{--                .catch(error => console.log('error', error));--}}
{{--            flagImage.forEach(e => {--}}
{{--                e.setAttribute('src', data[0].flags.png)--}}
{{--            })--}}
{{--        }--}}
{{--        getFlugsFetch()--}}
{{--    })--}}


{{--</script>--}}
<!-- AOS script -->


</body>
</html>
