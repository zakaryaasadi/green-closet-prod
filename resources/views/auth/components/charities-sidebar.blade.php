@php
    use App\Helpers\AppHelper;
@endphp
<div
    class="sidebar-container d-flex flex-column align-items-center align-items-sm-start pt-2 text-white w-100 ">
    <ul class="px-0 nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100 position-sticky"
        id="menu">
        <li>
            <a href="/{{AppHelper::getSlug()}}/association"
               class="nav-link px-0 align-middle d-flex align-items-center justify-content-center justify-content-md-start {{ (request()->is(AppHelper::getSlug().'/association')) ? 'active fw-bold' : '' }} ">
                <svg width="33" height="33" viewBox="0 0 33 33" fill="white" stroke="#008451"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M13.4546 5.75488H6.73071C6.31485 5.7554 5.91616 5.92082 5.62211 6.21488C5.32805 6.50894 5.16262 6.90762 5.16211 7.32348V11.3577C5.16245 11.7736 5.3278 12.1725 5.62188 12.4667C5.91596 12.7609 6.31473 12.9264 6.73071 12.9269H13.4546C13.8706 12.9266 14.2696 12.7611 14.5638 12.4669C14.858 12.1727 15.0235 11.7737 15.0238 11.3577V7.32348C15.0233 6.90751 14.8578 6.50873 14.5636 6.21465C14.2694 5.92058 13.8705 5.75522 13.4546 5.75488V5.75488Z"
                        stroke="#008451"/>
                    <path
                        d="M13.4546 14.7222H6.73071C6.31473 14.7227 5.91596 14.8882 5.62188 15.1824C5.3278 15.4766 5.16245 15.8754 5.16211 16.2914V25.7043C5.16262 26.1201 5.32805 26.5188 5.62211 26.8129C5.91616 27.1069 6.31485 27.2724 6.73071 27.2729H13.4546C13.8705 27.2725 14.2694 27.1072 14.5636 26.8131C14.8578 26.519 15.0233 26.1202 15.0238 25.7043V16.2914C15.0235 15.8753 14.858 15.4764 14.5638 15.1822C14.2696 14.8879 13.8706 14.7225 13.4546 14.7222V14.7222Z"
                        stroke="#008451"/>
                    <path
                        d="M25.1088 20.0983H18.3856C17.9696 20.0986 17.5706 20.264 17.2764 20.5583C16.9822 20.8525 16.8167 21.2514 16.8164 21.6675V25.7017C16.8169 26.1177 16.9824 26.5164 17.2766 26.8105C17.5708 27.1046 17.9697 27.2699 18.3856 27.2703H25.1095C25.5254 27.2698 25.924 27.1043 26.2181 26.8103C26.5121 26.5162 26.6776 26.1175 26.6781 25.7017V21.6675C26.6777 21.2514 26.5123 20.8525 26.2181 20.5583C25.9239 20.264 25.5249 20.0986 25.1088 20.0983V20.0983Z"
                        stroke="#008451"/>
                    <path
                        d="M25.1088 5.75488H18.3856C17.9697 5.75522 17.5708 5.92058 17.2766 6.21465C16.9824 6.50873 16.8169 6.90751 16.8164 7.32348V16.737C16.8167 17.1531 16.9822 17.552 17.2764 17.8462C17.5706 18.1405 17.9696 18.3059 18.3856 18.3062H25.1095C25.5255 18.3057 25.9243 18.1402 26.2183 17.846C26.5124 17.5518 26.6777 17.153 26.6781 16.737V7.32348C26.6776 6.90751 26.5121 6.50873 26.2179 6.21465C25.9237 5.92058 25.5248 5.75522 25.1088 5.75488V5.75488Z"
                        stroke="#008451"/>
                </svg>
                <span class="ms-1 d-none d-md-inline">{{__('Dashboard')}}</span>
            </a>
        </li>
        <li>
            <a href="/{{AppHelper::getSlug()}}/association/orders"
               class="nav-link px-0 align-middle d-flex align-items-center justify-content-center justify-content-md-start {{ (request()->is(AppHelper::getSlug().'/association/orders')) ? 'active fw-bold' : '' }}">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="white" stroke="#008451"
                     xmlns="http://www.w3.org/2000/svg">
                    <mask id="mask0_3324_3483" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="32"
                          height="32">
                        <rect width="32" height="32" fill="red"/>
                    </mask>
                    <g mask="url(#mask0_3324_3483)">
                        <mask id="path-2-inside-1_3324_3483" fill="white">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M9.36291 5C8.25835 5 7.36292 5.89543 7.36292 7V25C7.36292 26.1046 8.25835 27 9.36292 27H22.637C23.7416 27 24.637 26.1046 24.637 25V7C24.637 5.89543 23.7416 5 22.637 5C23.7416 5 24.637 5.89543 24.637 7L24.637 9.06822C24.637 9.12115 24.5941 9.16406 24.5412 9.16406H24.208C21.9572 9.16406 20.1326 7.33941 20.1326 5.0886C20.1326 5.03967 20.1722 5 20.2212 5H9.36291Z"/>
                        </mask>
                        <path
                            d="M24.637 7H26.637V6.99999L24.637 7ZM24.637 9.06822L22.637 9.06821V9.06822H24.637ZM9.36292 7L9.36291 7V3C7.15378 3 5.36292 4.79086 5.36292 7H9.36292ZM9.36292 25V7H5.36292V25H9.36292ZM9.36292 25H9.36292H5.36292C5.36292 27.2091 7.15378 29 9.36292 29V25ZM22.637 25H9.36292V29H22.637V25ZM22.637 25V29C24.8462 29 26.637 27.2091 26.637 25H22.637ZM22.637 7V25H26.637V7H22.637ZM22.637 7H22.637H26.637C26.637 4.79086 24.8462 3 22.637 3V7ZM22.637 7L22.637 7.00001L26.637 6.99999C26.637 4.79086 24.8462 3 22.637 3V7ZM22.637 6.99999L22.637 9.06821L26.637 9.06822L26.637 7.00001L22.637 6.99999ZM22.637 9.06822C22.637 8.01659 23.4895 7.16406 24.5412 7.16406V11.1641C25.6987 11.1641 26.637 10.2257 26.637 9.06822H22.637ZM24.5412 7.16406H24.208V11.1641H24.5412V7.16406ZM24.208 7.16406C23.0618 7.16406 22.1326 6.23484 22.1326 5.0886H18.1326C18.1326 8.44398 20.8526 11.1641 24.208 11.1641V7.16406ZM22.1326 5.0886C22.1326 6.14424 21.2768 7 20.2212 7V3C19.0677 3 18.1326 3.93509 18.1326 5.0886H22.1326ZM9.36291 7H20.2212V3H9.36291V7Z"
                            fill="white" mask="url(#path-2-inside-1_3324_3483)"/>
                        <path
                            d="M22.0405 6H22.8899C23.3026 6 23.6371 6.33451 23.6371 6.74714V7.40874C22.9129 7.21063 22.3241 6.68452 22.0405 6Z"
                            stroke="#008451" stroke-width="1.74714"/>
                    </g>
                </svg>
                <span class="ms-1 d-none d-md-inline">{{__('Orders')}}</span></a>
        </li>
        <li>
            <a href="/{{AppHelper::getSlug()}}/association/containers"
               class="nav-link px-0 align-middle d-flex align-items-center justify-content-center justify-content-md-start {{ (request()->is(AppHelper::getSlug().'/association/containers')) ? 'active fw-bold' : '' }}">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="white" xmlns="http://www.w3.org/2000/svg">
                    <mask id="mask0_3341_7954" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="32"
                          height="32">
                        <rect width="32" height="32" fill="#D9D9D9"/>
                    </mask>
                    <g fill="white" mask="url(#mask0_3341_7954)">
                        <rect x="8.92358" y="14.4025" width="4.39015" height="1.0975" rx="0.548752" fill="white"/>
                        <rect x="8.92358" y="16.5" width="8.15297" height="1.0975" rx="0.548752" fill="white"/>
                        <rect x="5.92358" y="6.40247" width="20.153" height="19.195" rx="1" stroke="#008451"
                              stroke-width="4" mask="url(#path-2-inside-1_3341_7954)"/>
                    </g>
                </svg>

                <span class="ms-1 d-none d-md-inline">{{__('Containers Report')}}</span> </a>
        </li>
        <li>
            <a href="/{{AppHelper::getSlug()}}/association/containers-details"
               class="nav-link px-0 align-middle d-flex align-items-center justify-content-center justify-content-md-start {{ (request()->is(AppHelper::getSlug().'/association/containers-details')) ? 'active fw-bold' : '' }}">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="white" xmlns="http://www.w3.org/2000/svg">
                    <mask id="mask0_3341_7954" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="32"
                          height="32">
                        <rect width="32" height="32" fill="#D9D9D9"/>
                    </mask>
                    <g fill="white" mask="url(#mask0_3341_7954)">
                        <rect x="8.92358" y="14.4025" width="4.39015" height="1.0975" rx="0.548752" fill="white"/>
                        <rect x="8.92358" y="16.5" width="8.15297" height="1.0975" rx="0.548752" fill="white"/>
                        <rect x="5.92358" y="6.40247" width="20.153" height="19.195" rx="1" stroke="#008451"
                              stroke-width="4" mask="url(#path-2-inside-1_3341_7954)"/>
                    </g>
                </svg>

                <span class="ms-1 d-none d-md-inline">{{__('Containers Details Report')}}</span> </a>
        </li>
        <li class="d-none">
            <a href="/{{AppHelper::getSlug()}}/association/expense"
               class="nav-link px-0 align-middle d-flex align-items-center justify-content-center justify-content-md-start {{ (request()->is(AppHelper::getSlug().'/association/expense')) ? 'active fw-bold' : '' }}">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="#008451" xmlns="http://www.w3.org/2000/svg">
                    <mask id="mask0_3341_9342" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="32"
                          height="32">
                        <rect width="32" height="32" fill="#008451"/>
                    </mask>
                    <g mask="url(#mask0_3341_9342)">
                        <g clip-path="url(#clip0_3341_9342)">
                            <path
                                d="M11.2632 5.38953C11.2632 4.83724 10.8155 4.38953 10.2632 4.38953C9.7109 4.38953 9.26318 4.83724 9.26318 5.38953L11.2632 5.38953ZM9.55608 28.0667C9.9466 28.4572 10.5798 28.4572 10.9703 28.0667L17.3343 21.7027C17.7248 21.3122 17.7248 20.679 17.3343 20.2885C16.9437 19.898 16.3106 19.898 15.92 20.2885L10.2632 25.9453L4.60633 20.2885C4.21581 19.898 3.58264 19.898 3.19212 20.2885C2.80159 20.679 2.80159 21.3122 3.19212 21.7027L9.55608 28.0667ZM9.26318 5.38953L9.26318 27.3595L11.2632 27.3595L11.2632 5.38953L9.26318 5.38953Z"
                                fill="#008451"/>
                            <path
                                d="M21.3369 27.3596C21.3369 27.9118 21.7846 28.3596 22.3369 28.3596C22.8892 28.3596 23.3369 27.9118 23.3369 27.3596L21.3369 27.3596ZM23.044 4.68243C22.6535 4.29191 22.0203 4.29191 21.6298 4.68243L15.2658 11.0464C14.8753 11.4369 14.8753 12.0701 15.2658 12.4606C15.6564 12.8511 16.2895 12.8511 16.6801 12.4606L22.3369 6.80375L27.9938 12.4606C28.3843 12.8511 29.0175 12.8511 29.408 12.4606C29.7985 12.0701 29.7985 11.4369 29.408 11.0464L23.044 4.68243ZM23.3369 27.3596L23.3369 5.38954L21.3369 5.38954L21.3369 27.3596L23.3369 27.3596Z"
                                fill="#008451"/>
                        </g>
                    </g>
                    <defs>
                        <clipPath id="clip0_3341_9342">
                            <rect width="28" height="25" fill="#008451" transform="translate(2 3.5)"/>
                        </clipPath>
                    </defs>
                </svg>


                <span class="ms-1 d-none d-md-inline">{{__('Account Statement')}}</span> </a>
        </li>
        <li class="d-none">
            <a href="/{{AppHelper::getSlug()}}/association/payments-record"
               class="nav-link px-0 align-middle d-flex align-items-center justify-content-center justify-content-md-start {{ (request()->is(AppHelper::getSlug().'/association/payments-record')) ? 'active fw-bold' : '' }}">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="#008451" xmlns="http://www.w3.org/2000/svg">
                    <mask id="mask0_3341_9342" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="32"
                          height="32">
                        <rect width="32" height="32" fill="#008451"/>
                    </mask>
                    <g mask="url(#mask0_3341_9342)">
                        <g clip-path="url(#clip0_3341_9342)">
                            <path
                                d="M11.2632 5.38953C11.2632 4.83724 10.8155 4.38953 10.2632 4.38953C9.7109 4.38953 9.26318 4.83724 9.26318 5.38953L11.2632 5.38953ZM9.55608 28.0667C9.9466 28.4572 10.5798 28.4572 10.9703 28.0667L17.3343 21.7027C17.7248 21.3122 17.7248 20.679 17.3343 20.2885C16.9437 19.898 16.3106 19.898 15.92 20.2885L10.2632 25.9453L4.60633 20.2885C4.21581 19.898 3.58264 19.898 3.19212 20.2885C2.80159 20.679 2.80159 21.3122 3.19212 21.7027L9.55608 28.0667ZM9.26318 5.38953L9.26318 27.3595L11.2632 27.3595L11.2632 5.38953L9.26318 5.38953Z"
                                fill="#008451"/>
                            <path
                                d="M21.3369 27.3596C21.3369 27.9118 21.7846 28.3596 22.3369 28.3596C22.8892 28.3596 23.3369 27.9118 23.3369 27.3596L21.3369 27.3596ZM23.044 4.68243C22.6535 4.29191 22.0203 4.29191 21.6298 4.68243L15.2658 11.0464C14.8753 11.4369 14.8753 12.0701 15.2658 12.4606C15.6564 12.8511 16.2895 12.8511 16.6801 12.4606L22.3369 6.80375L27.9938 12.4606C28.3843 12.8511 29.0175 12.8511 29.408 12.4606C29.7985 12.0701 29.7985 11.4369 29.408 11.0464L23.044 4.68243ZM23.3369 27.3596L23.3369 5.38954L21.3369 5.38954L21.3369 27.3596L23.3369 27.3596Z"
                                fill="#008451"/>
                        </g>
                    </g>
                    <defs>
                        <clipPath id="clip0_3341_9342">
                            <rect width="28" height="25" fill="#008451" transform="translate(2 3.5)"/>
                        </clipPath>
                    </defs>
                </svg>


                <span class="ms-1 d-none d-md-inline">{{__('Payments record')}}</span> </a>
        </li>
        {{--        <li>--}}
        {{--            <a href="/{{AppHelper::getSlug()}}/association/financial-dues"--}}
        {{--               class="nav-link px-0 align-middle d-flex align-items-center justify-content-center justify-content-md-start {{ (request()->is(AppHelper::getSlug().'/association/financial-dues')) ? 'active fw-bold' : '' }}">--}}
        {{--                <svg width="22" height="22" viewBox="0 0 22 22" fill="white" stroke="#008451" xmlns="http://www.w3.org/2000/svg">--}}
        {{--                    <path--}}
        {{--                        d="M11.1058 1.15103L11.1053 1.15102C5.44115 1.01514 0.680423 5.40627 0.56655 10.8035L11.1058 1.15103ZM11.1058 1.15103C17.0175 1.28745 21.5418 5.75435 21.434 11.1978M11.1058 1.15103L21.434 11.1978M21.434 11.1978C21.326 16.5253 16.5786 20.9585 11.0253 20.8501L21.434 11.1978ZM11.0251 20.8501C4.98918 20.7297 0.453124 16.3041 0.566546 10.8037L11.0251 20.8501Z"--}}
        {{--                        stroke="white"/>--}}
        {{--                    <path--}}
        {{--                        d="M9.95354 5.33939C10.1095 3.78257 10.3075 3.42462 11.0034 3.4303C11.6633 3.43598 11.8553 3.75985 12.0533 5.29962C12.4792 5.29962 12.9292 5.28825 13.3791 5.3053C14.099 5.33371 14.549 5.70871 14.537 6.25984C14.531 6.81098 14.075 7.18597 13.3551 7.19734C12.3892 7.2087 11.4234 7.19166 10.4575 7.20302C9.51559 7.21438 9.02965 7.70302 9.01765 8.59506C9.01165 9.5212 9.50359 10.0382 10.4575 10.0723C10.8714 10.0894 11.2854 10.0723 11.6993 10.078C13.3911 10.1121 14.7589 11.2598 14.9629 12.811C15.1909 14.561 14.249 16.0212 12.6052 16.4928C12.4072 16.5496 12.2153 16.6007 12.0353 16.6462C11.8733 18.2087 11.6693 18.5609 10.9614 18.5325C10.2835 18.5041 10.0855 18.1575 9.96553 16.6462C9.50359 16.6462 9.02965 16.6575 8.55571 16.6462C7.8658 16.6235 7.48184 16.2769 7.48784 15.7087C7.49384 15.1405 7.87779 14.8053 8.58571 14.7939C9.52759 14.7825 10.4755 14.7996 11.4174 14.7882C12.4612 14.7769 13.0252 14.2428 13.0072 13.3053C12.9892 12.3962 12.4492 11.9246 11.4054 11.9189C10.9674 11.9132 10.5295 11.936 10.0915 11.9019C8.41773 11.7712 7.21188 10.6291 7.0379 9.03824C6.85192 7.34507 7.76981 5.97007 9.40161 5.4928C9.56358 5.4303 9.74356 5.39053 9.95354 5.33939Z"--}}
        {{--                        fill="white"/>--}}
        {{--                </svg>--}}
        {{--                <span class="ms-1 d-none d-md-inline">{{__('Financial Dues')}}</span> </a>--}}
        {{--        </li>--}}


    </ul>

</div>

