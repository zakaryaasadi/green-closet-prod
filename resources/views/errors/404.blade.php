<html>
<head>
    @include('layouts.app')

    <style>

        * {
            font-family: 'Poppins';
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        h1 {
            font-size: 20vw;
            color: #008451;
        }

        .page-404 {
            background-image: url("/images/404.png");
            background-size: 100% auto;
            background-position: bottom;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            height: 100vh;
        }

        a {
            color: #008451;
        }

        .fw-bold {
            font-weight: bold;
        }

        .mt-5 {
            margin-top: 100px;
        }

        p, a {
            font-size: 20px;
        }

        @media screen and (max-width: 768px) {
            h1 {
                font-size: 28vw;
            }
        }

        nsv, footer {
            display: none !important;
        }
    </style>
    <head>
<body>
<main class="page-404 d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-12">
                <h1>Oops :(</h1>
            </div>
            <div class="co-12 d-flex align-items-center justify-content-center flex-column mt-3">
                <p class="text-center fw-bold">Sorry about that,</p>
                <p class="text-center fw-bold">The page you are looking for doesn't exist</p>
            </div>
            <div class="col-12 py-5 mt-5">
                <a href="/{{\App\Helpers\AppHelper::getSlug()}}/">Go Home</a>
            </div>
        </div>
    </div>
</main>

<body>
<html>



