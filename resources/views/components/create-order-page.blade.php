@php
    use App\Helpers\AppHelper;
    use App\Models\Setting;

    $countryId =AppHelper::getLocationSettings()->country->id;
    $getSetting = Setting::where( ['country_id' => $countryId])->get()->first();

@endphp
@pushOnce('styles')
    <link rel="stylesheet" href="{{ mix('css/components/create-order.css')}}">
    @if(App::getLocale() == 'ar')
        <style>
        </style>
    @endif
@endPushOnce
<main>
    <section class="create-order-page d-flex align-items-start justify-content-center w-100 py-5 py-lg-0   ">
        <div class="container  ">
            <div class="row h-100 justify-content-center">
                <div class="col-12 col-lg-6 h-100   d-flex align-items-center justify-content-center">
                    <form class="row p-2 p-lg-5 bg-white" action="/{{AppHelper::getSlug()}}/make-order" method="POST">
                        @csrf
                        <div class="col-12 mt-2">
                            <h1 class="mx-0">{{ __('Create Order') }}</h1>
                            <h3 class="mt-4 px-0"> {{ __('Order details') }}</h3>
                        </div>
                        <div class="col-12">
                            <h6 class="d-flex align-items-center px-0 ">
                                <span class="mx-1 d-block">
                                       <img src="{{asset(url('/images/order-type.png'))}}" alt="order-type">
                                </span>
                                <span class=" d-block"> {{ __('Order type') }}</span>
                            </h6>
                            <select class="form-select" aria-label="Default select example" name="type" required
                                    onchange="getComboA(this)">
{{--                                <option value="" selected disabled hidden>{{__('Order type')}}</option>--}}
                            @if($getSetting->has_recycling)
                                    <option value="2">{{ __('Recycling')}}</option>
                                @endif
                                @if($getSetting->has_donation)
                                    <option value="1">{{ __('Donation') }}</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-12 mt-2 association ">
                        </div>


                        <div class="col-12 mt-2">
                            <h3 class="mt-2 px-0">{{ __('Address') }}</h3>
                            <h6 class="d-flex align-items-center px-0 ">
                            <span class="mx-1 d-block">
                                <img src="{{asset(url('/images/address.png'))}}" alt="address">
                            </span>
                                <span class=" d-block">{{ __('Select Address') }}</span>
                            </h6>
                            <select class="form-select" aria-label="example" name="address_id" required>
                                @foreach($addresses as $address)
                                    <option
                                        {{$loop-> index == 1  ? "selected" : "" }} value="{{$address['id']}}">{{$address['title']}}</option>
                                @endforeach
                            </select>
                            <a href="/{{AppHelper::getSlug()}}/dashboard/addresses"
                               class="mt-2 d-flex align-items-center gap-1">
                                <span class="text-primary">+</span>
                                {{ __('Add New address') }}
                            </a>

                        </div>
                        <div class="col-12 mt-3  position-relative">
                            <button onclick="showSpinner(this)" type="submit"
                                    class="btn btn-primary w-100">{{ __('Send Order') }}</button>
                            <div class="lds-ellipsis d-none position-absolute start-50 top-50 translate-middle">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>

                            </span>

                        </div>
                        <div class="toast-body">
                            @if($errors)
                                <p class="text-danger"> {{ implode('', $errors->all(':message')) }}</p>
                            @else
                                can't log in right now , something went wrong
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>


@pushOnce('scripts')
    <script>
        function showSpinner(element) {
            document.querySelector('.lds-ellipsis').classList.replace('d-none', 'd-block');
            element.classList.add("disabled");
            element.classList.add("text-transparent")
        }
    </script>
    <script>
        var association = document.querySelector(".association")

        function createSelectElement() {
            var element = `
         <select class="form-select" aria-label="Default select example" name="association_id" required>
        @foreach($associations as $association)
            <option value="{{$association['id']}}">{{$association['title']}}</option>
         @endforeach
            </select>
`
            association.innerHTML = element;
        }

        function removeElement() {
            association.innerHTML = ""
        }

        @if($getSetting->has_donation&&!$getSetting->has_recycling)
        createSelectElement()
        @endif

        function getComboA(selectObject) {
            var value = selectObject.value;
            if (value == {{\App\Enums\OrderType::DONATION}}) {
                @if($getSetting->has_donation)
                @if(count($associations) > 0)
                createSelectElement()
                @endif
                @endif

            } else {
                removeElement()
            }
        }

    </script>

@endPushOnce



