<!-- start navbar  -->
@php
    use App\Helpers\AppHelper;
@endphp
<nav>
    <nav class="navbar navbar-expand-xl navbar-light bg-white  z-index-99 w-100" id="header">

            <a class="navbar-brand px-3" href="/dashboard">
                <img loading="lazy"  data-src="{{$locationSettings['header']['logo']}}" alt="">
            </a>


            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse flex-row-reverse d-xl-flex align-items-center"
                 id="navbarNav">
                @include('partials/language_switcher')
                <div class="mt-4 mt-lg-0 mr-4 px-2">
                    <a href="/" class="text-white text-decoration-none sign-up-link mt-4 mt-lg-0">
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.55859 17.0959C2.5586 16.7151 2.7133 16.3506 2.98723 16.086L4.01619 15.0922C4.40788 14.7139 4.62837 14.1922 4.62673 13.6476L4.61727 10.4946C4.60403 6.08319 8.17648 2.5 12.5879 2.5C16.99 2.5 20.5586 6.06859 20.5586 10.4707L20.5586 13.6716C20.5586 14.202 20.7693 14.7107 21.1444 15.0858L22.1444 16.0858C22.4096 16.351 22.5586 16.7107 22.5586 17.0858C22.5586 17.8668 21.9254 18.5 21.1444 18.5H16.5586C16.5586 20.7091 14.7677 22.5 12.5586 22.5C10.3495 22.5 8.55859 20.7091 8.55859 18.5H3.96267C3.18722 18.5 2.55859 17.8714 2.55859 17.0959ZM10.5586 18.5C10.5586 19.6046 11.454 20.5 12.5586 20.5C13.6632 20.5 14.5586 19.6046 14.5586 18.5H10.5586ZM18.5586 13.6716C18.5586 14.7324 18.98 15.7499 19.7302 16.5L5.4371 16.5C6.20081 15.746 6.62995 14.7161 6.62672 13.6416L6.61726 10.4886C6.60734 7.1841 9.28339 4.5 12.5879 4.5C15.8854 4.5 18.5586 7.17316 18.5586 10.4707L18.5586 13.6716Z" fill="#808191"/>
                            <circle cx="19.0586" cy="6" r="3.5" fill="#EB5757"/>
                        </svg>
                    </a>
                </div>


                    <div class="dropdown mt-4 mt-lg-0">
                        <a href="#"
                           class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle d-flex "
                           id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img loading="lazy"  data-src="{{asset('images/profile.png')}}" alt="hugenerd" width="30" height="30"
                                 class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-white text-small shadow"
                            aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="/{{AppHelper::getSlug()}}/dashboard/profile">{{__('Profile')}}</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/{{AppHelper::getSlug()}}/auth/logout">{{__('Sign out')}}</a></li>
                        </ul>

                    </div>


            </div>
    </nav>
</nav>
<!-- End navbar  -->
