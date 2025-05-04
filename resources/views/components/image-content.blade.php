@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/image-content.css') }}">
@endPushOnce
<section class="w-100 news-image-content space">
    <div class="container overflow-hidden">
        <div class="col-12 text-center py-5">
            <h1 data-aos="fade-up">{!!$section['title']??''!!}</h1>
        </div>
        <div class="row" style="flex-direction: {{isset($section['rtl'])?$section['rtl']?'row':'row-reverse':'row'}}">
            <div class="col-12 col-lg-6 image-section my-2 my-lg-0">
                <img src="{{$section["image"]??url('/images/placeholder.png')}}"
                     width="100%"
                     alt="{{$section['alt']??''}}">
            </div>
            <div class="col-12 col-lg-6 my-2 my-lg-0 space-content">
                <div class="row content">
                    @foreach($section['contents']  as $content)
                        <div class="col-12 mb-2 ">
                            <div class="row">
                                <div class="col-1">
                                    <img src="{{$content['image']}}"
                                         alt="{{$content['alt']??''}}"
                                         class="image-size">
                                </div>
                                <div class="col-11">
                                    <h4>{{$content['title']??""}}</h4>
                                    {!! $content['description']??"" !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</section>
@pushOnce('scripts')
@endPushOnce
