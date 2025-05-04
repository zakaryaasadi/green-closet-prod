@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/our_app.css') }}">
@endPushOnce
@php
    use App\Helpers\AppHelper;
@endphp
<section class="our-app-section d-flex align-items-center justify-content-center position-relative">
    <div class="container mt-5 overflow-hidden">
        <div class="row">
            <div class="col-12 text-center d-flex flex-column align-items-center">
                <h1 class="text-maastricht-blue" data-aos="fade-up">
                    {!!$section['title']??""!!}
                </h1>
                <div class="text-maastricht-blue fs-5 text-center" data-aos="fade-down">
                    {!!$section['description']!!}
                </div>
            </div>
            <div class="col-12 align-items-center justify-content-center  ">
                <div class="row justify-content-center ">
                    @foreach($section["apps"] as  $app)
                        <div
                            class="col-6 col-md-4 col-lg-3 mt-3 align-items-center justify-content-center d-flex ">

                            <a href="{{$app['target'] === '_blank' ?$app['link']:"/".AppHelper::getSlug().$app['link']}}"
                               target="{{$app['target']}}" data-aos="zoom-out"
                               class="w-fit w-100 justify-content-center align-items-center d-flex  text-decoration-none w-100">
                        <span class="d-block w-100">
                         <img class="w-100  icon" loading="lazy" data-src="{{$app['icon']}}" alt="Download App Icon  "
                              data-aos="zoom-out">
                        </span>
                            </a>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
        <div class="row contact">
            <div class="col-12 mt-5 text-center ">
                <p class="fs-5 text-maastricht-blue" data-aos="fade-up">
                    {{$section['title_contact']}}
                </p>
            </div>
            <div class="col-12 align-items-center justify-content-center">
                <div class="row justify-content-center ">
                    @foreach($section["contact"] as  $contact)
                        <div
                            class="col-6 col-md-4 col-lg-3 mt-3 align-items-center justify-content-center d-flex ">
                            <a href="{{$contact['link']}}" target="_blank" data-aos="zoom-out"
                               class="py-3 py-md-0 justify-content-center align-items-center d-flex text-maastricht-blue text-decoration-none btn Our btn-primary w-100">
    <span class="d-block mx-2">
     <img loading="lazy" data-src="{{$contact['icon']}}"
          alt="{{$contact['alt']??''}}" data-aos="zoom-out"
          class="icon">
    </span>
                                <span class="d-block number text-white " data-aos="fade-up">{{$contact["number"]}}
    </span>
                            </a>
                        </div>
                    @endforeach
                </div>


            </div>
        </div>

    </div>
    <lottie-player src="/storage/bicikle.json"
                   background="transparent" speed=".5" style="width: 100%;" loop autoplay
                   id="ourAppLottie"></lottie-player>
</section>

@pushOnce('scripts')
    <script src="{{ mix('js/components/our_app.js') }}"></script>

@endPushOnce
