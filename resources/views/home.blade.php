@php
    use App\Enums\SectionType;
    use App\Helpers\AppHelper
@endphp

@extends('layout')



@section('style')
@endsection
@section('content')
    <main id="home-page">
        @foreach($data->sections as $section)
            @switch($section->type)
                @case(SectionType::FAQS)
                    <x-faq-section :section="$section->structure"></x-faq-section>
                    @break
                @case(SectionType::OUR_APPS_HOME)
                    <x-our-app-section :section="$section->structure"></x-our-app-section>
                    @break
                @case(SectionType::IMAGE_SLIDER_HEADER)
                    <x-image-slider-header :section="$section->structure"></x-image-slider-header>
                    @break
                @case(SectionType::CARDS_HOME)
                    <x-cards-home :section="$section->structure"></x-cards-home>
                    @break
                @case(SectionType::VIDEO_BANNER)
                    <x-video-banner :section="$section->structure"></x-video-banner>
                    @break
                @case(SectionType::IMAGE_CONTENT_SECTION)
                    <x-image-content :section="$section->structure"></x-image-content>
                    @break
                @case(SectionType::NEWS_HOME)
                    <x-news-section :section="$section->structure"></x-news-section>
                    @break
                @case(SectionType::HOW_WE_WORK)
                    <x-how-we-work :section="$section->structure"></x-how-we-work>

                    @break
                @case(SectionType::LOTTIE_SECTION)
                    <x-lottie-section :section="$section->structure"></x-lottie-section>
                    @break
                @case(SectionType::KISWA_BENEFITS_HOME)
                    <x-kiswa-benefits-home-card :section="$section->structure"></x-kiswa-benefits-home-card>
                    @break
                @case(SectionType::KISWA_BENEFITS_HOME_WITH_MASK)
                    <x-kiswa-benefits-home :section="$section->structure"></x-kiswa-benefits-home>
                    @break
                @case(SectionType::KISWA_OFFERS_HOME)
                    <x-offers-section :section="$section"></x-offers-section>
                    @break
                @case(SectionType::OUR_PARTNERS_HOME)
                    <x-partners-section :section="$section->structure"></x-partners-section>
                    @break
                @case(SectionType::GALLERY_PAGE)
                    <x-gallery-section :section="$section"></x-gallery-section>
                    @break
                @case(SectionType::EVENTS_PAGE)
                    <x-events-section :section="$section->structure"></x-events-section>
                    @break
                @case(SectionType::NEWS_PAGE)
                    <x-news-page :section="$section->structure"></x-news-page>
                    @break
                @case(SectionType::BLOGS_PAGE)
                    <x-blogs-page :section="$section->structure"></x-blogs-page>
                    @break
                @case(SectionType::OUR_PARTNERS_PAGE)
                    <x-our-partners-page :section="$section->structure"></x-our-partners-page>
                    @break
                @case(SectionType::OFFER_PAGE)
                    <x-offers-page :section="$section->structure"></x-offers-page>
                    @break
                @case(SectionType::CONTACT_US)
                    <x-contact-us :section="$section->structure"></x-contact-us>
                    @break
                @case(SectionType::CREATE_ORDER)
                    <x-create-order-page :section="$section->structure"></x-create-order-page>
                    @break
                @case(SectionType::SLIDER_COMPONENT)
                    <x-slider-component :section="$section->structure"></x-slider-component>
                    @break
                @case(SectionType::CARDS_COMPONENT)
                    <x-cards-component :section="$section->structure"></x-cards-component>
                    @break
                @case(SectionType::WHAT_DO_WE_RECEIVE)
                    <x-what-do-we-receive-component :section="$section->structure"></x-what-do-we-receive-component>
                    @break
                @case(SectionType::CREATE_ORDER_COMPONENT)
                    <x-create-order-component :section="$section->structure"></x-create-order-component>
                    @break

            @endswitch
        @endforeach
    </main>
@endsection

@section('script')
    @if($data->slug == '/')
        <script src="https://unpkg.com/@lottiefiles/lottie-interactivity@latest/dist/lottie-interactivity.min.js"
                defer></script>
        <script type="module">
            LottieInteractivity.create({
                player: "#lottie",
                mode: "scroll",
                container: "#lottie_container",
                actions: [
                    {
                        visibility: [0.1, 0.45],
                        type: "seek",
                        frames: [0, 250]
                    }
                ]
            });
        </script>
        <script type="module">
            LottieInteractivity.create({
                player: "#ourAppLottie",
                mode: 'scroll',
                actions: [
                    {
                        visibility: [0, 1],
                        type: 'seek',
                        frames: [0, 500],
                    },
                ]
            });
        </script>
    @endif




@endsection

