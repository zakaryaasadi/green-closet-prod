@php
    use App\Helpers\AppHelper@endphp
@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/contact-us.css')}}">

    @if(App::getLocale() == 'ar')
        <style>
            .contact-us-page .contact-us-map {
                right: auto !important;
                left: 0;
            }
        </style>
    @endif
@endPushOnce
<section class="contact-us-page  position-relative overflow-hidden d-flex align-items-center py-4 py-md-0 ">

    <div class="container main-container">
        <div class="row flex-column-reverse flex-md-row">

            <div class="col-12 col-md-6 p-2">
                <div class="box h-100 w-100 p-1 p-lg-5">
                    <svg class="svg-1" width="143" height="42" viewBox="0 0 143 42" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M0.900391 41.7721C0.900391 41.8449 0.900391 41.9176 0.900391 41.9918H142.682C142.65 37.4159 138.732 33.7228 133.909 33.7228H119.994L120.326 33.6487C117.462 28.1993 111.531 24.4577 104.679 24.4577C103.786 24.4579 102.895 24.5214 102.011 24.6478C102.16 23.7307 102.235 22.8031 102.235 21.8739C102.235 10.1572 90.4508 0.65625 75.9184 0.65625C62.6247 0.65625 51.629 8.6085 49.8553 18.9316C46.7301 16.951 43.104 15.9048 39.4041 15.9165C29.3802 15.9165 21.1921 23.3741 20.6691 32.7645C18.5055 31.5126 16.0468 30.8612 13.5472 30.8775C6.56401 30.8748 0.900391 35.7513 0.900391 41.7721Z"
                            fill="white"/>
                    </svg>


                    <svg class="svg-2" width="143" height="42" viewBox="0 0 143 42" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M0.944336 41.7301C0.944336 41.8029 0.944336 41.8756 0.944336 41.9498H142.726C142.694 37.3739 138.776 33.6808 133.953 33.6808H120.038L120.37 33.6067C117.505 28.1573 111.575 24.4157 104.723 24.4157C103.83 24.4159 102.939 24.4794 102.055 24.6058C102.204 23.6887 102.279 22.7611 102.279 21.8319C102.279 10.1152 90.4948 0.614258 75.9624 0.614258C62.6686 0.614258 51.673 8.56651 49.8992 18.8896C46.7741 16.909 43.148 15.8628 39.4481 15.8745C29.4242 15.8745 21.2361 23.3321 20.7131 32.7225C18.5494 31.4706 16.0908 30.8192 13.5911 30.8355C6.60796 30.8328 0.944336 35.7093 0.944336 41.7301Z"
                            fill="white" fill-opacity="0.49"/>
                    </svg>


                    <h1 class="text-white pt-3  px-2 py-4">{{$section['form']['title']}}</h1>
                    <h4 class="text-white ">{{$section['title']}}</h4>
                    <div class="text-white ">
                        {!! $section['description'] !!}


                    </div>
                    <div class="row">
                        @foreach($section['contact'] as $contact)
                            <div class="col-12   d-flex my-2 text-white ">

                                @if(isset($contact['icon']))
                                    <span class="d-block px-1">
                                    <img loading="lazy" data-src="{{$contact['icon']}}"
                                         alt="{{$contact['alt']??''}}"
                                         class="info-icon"/>
                                           </span>
                                @endif
                                <div class="contact-info">
                                    <h5>{{$contact['title']}}</h5>
                                    <p class="dir-ltr">
                                        <a href="{{$contact['info-link']}}" class="text-white number " target="_blank">
                                            {{$contact['info']}}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


            </div>
            <div class="col-12 col-md-6">
                <div class="container">
                    <div id="contact-us-message">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                    <form class="py-4 pb-5 row  " action="/{{AppHelper::getSlug()}}/contact" method="POST"
                          id="contact-form">

                        @csrf
                        @foreach($section['form']['fields'] as $key => $field)
                            <div class=" {{$loop->index == 0 || $loop->index == 1 ?'col-md-6':''}} col-12 mt-3 ">
                                <label class="form-label d-flex align-item-center">
                                    <span class="icon px-1">
                                        @if(isset($field['icon']))
                                            <img loading="lazy" data-src="{{$field['icon']}}"
                                                 alt="icon {{$field['title']}}">
                                        @endif
                                    </span>
                                    <span class="d-block">
                                        {{$field['title']}}
                                    </span>
                                </label>
                                @php
                                    $type = '';
                                    $name = '';
                                    if ($field['type'] == \App\Enums\FieldType::EMAIL)
                                        $type = 'email';
                                    if ($field['type'] == \App\Enums\FieldType::TEXT)
                                        $type = 'text';

                                    if ($field['name'] == \App\Enums\FieldNameEnum::NAME)
                                        $name = 'name';
                                    if ($field['name'] == \App\Enums\FieldNameEnum::EMAIL)
                                        $name = 'email';
                                    if ($field['name'] == \App\Enums\FieldNameEnum::PHONE)
                                        $name = 'phone';
                                    if ($field['name'] == \App\Enums\FieldNameEnum::DETAILS)
                                        $name = 'details';
                                @endphp
                                @if($field['type'] != \App\Enums\FieldType::TEXTAREA)
                                    <input name="{{$name}}" type="{{$type}}"
                                           placeholder="{{$field['title']}}"
                                           class="form-control number  {{ $errors->has($name) ? 'is-invalid' : '' }}"
                                           value="{{ old($name) }}" required>
                                    @if ($errors->has($name))
                                        <span class="text-danger">{{ $errors->first($name) }}</span>
                                    @endif
                                @else
                                    <textarea name="{{$name}}" rows="10"
                                              class="form-control number {{ $errors->has($name) ? 'is-invalid' : '' }}"
                                              required></textarea>
                                    @if ($errors->has($name))
                                        <span class="text-danger">{{ $errors->first('message')}}</span>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                        <!-- Google reCaptcha v2 -->
                        <div class=" mt-3 col-12 col-md-3  mt-3     ">
                            <button
                                class="g-recaptcha btn btn-primary"
                                data-sitekey={{config('recaptcha.api_site_key')}}
                                    data-callback='onSubmit'>{{$section['form']['button']['title']}}</button>
                        </div>
                    </form>
                    @if(Session::has('payload'))
                        <div class="mt-3 alert alert-primary" role="alert">
                            <h5>{{ Session::get('payload')}}</h5>
                        </div>
                        {{ Session::forget('payload') }}
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    function onSubmit(token) {
        document.getElementById("contact-form").submit();
    }
</script>
@pushOnce('scripts')

@endPushOnce
