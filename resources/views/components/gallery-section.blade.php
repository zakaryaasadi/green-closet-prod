@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/gallery.css') }}">
    <link rel="stylesheet" href="https://rawgit.com/LeshikJanz/libraries/master/Bootstrap/baguetteBox.min.css">
@endPushOnce
<section class="  mt-5 " id="gallery-page">
    <div class="container">
        <h1 class="w-100  text-dark py-5 text-center mb-0">
            {!!$section->structure['title']??""!!}
        </h1>
    </div>

    <div class="container mb-5">
        <div class=" gallery-container">
            <div class="tz-gallery">
                <div class="row">
                    @foreach($section->structure['images'] as $image)
                        <div class="col-12 col-md-6 col-lg-4 col-xl-3 py-2 position-relative overflow-hidden box-image">
                            <a class="lightbox" href="{{$image['image']??url('/images/placeholder.png')}}"
                               data-view="{{__('View')}}">
                                <img loading="lazy"
                                     alt="{{$image['alt']??''}}"
                                     data-src="{{$image['image']??url('/images/placeholder.png')}}"
                                     class="card-img-top" data-aos="zoom-in">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>


</section>
@pushOnce('scripts')
    <script src="{{ mix('js/components/gallery.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js"
            integrity="sha512-7KzSt4AJ9bLchXCRllnyYUDjfhO2IFEWSa+a5/3kPGQbr+swRTorHQfyADAhSlVHCs1bpFdB1447ZRzFyiiXsg=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"></script>
    <script>
        baguetteBox.run('.tz-gallery', {
            animation: 'fadeIn',
            noScrollbars: true
        });
    </script>
@endPushOnce
