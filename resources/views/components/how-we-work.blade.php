@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/how-we-work.css') }}">
    @if(App::getLocale() == 'ar')
        <link rel="stylesheet" href="{{ mix('css/components/how-we-work-ar.css') }}">
    @endif
@endPushOnce

<section class="how-we-work mt-5 ">
    <div class="container h-100">
        <div class="row h-100"
             style="flex-direction: {{isset($section['rtl'])?$section['rtl']?'row':'row-reverse':'row'}}">
            <div class="col-12 text-center py-5">
                <h1 data-aos="fade-up">{!!$section['title']??""!!}</h1>
            </div>
            <div class="col-12 col-lg-6 d-flex align-items-start justify-content-center px-4 px-sm-2 ">
                <div class="boxs accordion position-relative w-100 d-flex flex-column gap-4 " id="accordionExample">
                    @foreach($section['steps'] as  $step)
                        <div class="w-100 container-box position-relative"
                             data-image-src="{{$step["image"]??url('/images/placeholder.png')}}" data-index="">
                            <div class="title border-0" data-bs-toggle="collapse"
                                 data-bs-target="#collapse{{$loop->index + 1}}" aria-expanded="true"
                                 aria-controls="collapse{{$loop->index + 1}}">
                                <h1 class="px-3 d-flex align-items-center justify-content-flex-start py-3 py-lg-0 position-relative"
                                    data-aos="fade-up"
                                    data-number="{{$loop->index + 1}}">
                                    {{$step['title']}}
                                </h1>
                            </div>
                            <div class="content  px-3 pb-1 accordion-collapse collapse {{$loop->index == 0 ? "show" : "" }}  border-0  "
                                 id="collapse{{$loop->index + 1}}" aria-labelledby="heading{{$loop->index + 1}}"
                                 data-bs-parent="#accordionExample">
                                <div class="description" data-aos="fade-left">{!! $step['description'] !!}</div>
                                <div class="col-12 col-lg-6 d-flex d-lg-none align-items-start justify-content-center image-container"
                                     style="background-image: url('{{$section['steps'][0]["image"]??url('/images/placeholder.png')}}'); {{$section['steps'][0]["image"]??'background-size:cover'}} ">
                                </div>

                                @if(isset($step["buttons"]))
                                    @foreach($step['buttons'] as $button)
                                        <a href="{{$button['target']=="_blank"? $button['link']:"/".\App\Helpers\AppHelper::getSlug().$button["link"]}}"
                                           target="{{$button['target']}}"
                                           class="mb-1 btn {{$loop->index==0 ? 'btn-primary' : 'btn-outline-primary'}}"
                                           data-aos="fade-down">
                                            {{$button['title']}}
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-12 col-lg-6 d-none d-lg-flex align-items-start justify-content-center image-container"
                 style="background-image: url('{{$section['steps'][0]["image"]??url('/images/placeholder.png')}}'); {{$section['steps'][0]["image"]??'background-size:cover'}} ">
            </div>
        </div>
    </div>
</section>
@pushOnce('scripts')
    <script src="{{ mix('js/components/how-we-work.js') }}"></script>
@endPushOnce
