const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

let jsOutput = 'public/js';
let jsOutputLibraries = 'public/js/libraries';
let jsComponentsOutput = 'public/js/components';
let cssOutput = 'public/css';
let cssOutputLibraries = 'public/css/libraries';
let cssComponentsOutput = 'public/css/components';


mix.js('resources/js/app.js', jsOutput)
    .js('resources/js/main.js', jsOutput)
    .js(['resources/js/dashboard.js'], jsOutput)
    .js(['resources/js/aos.js'], jsOutput)
    .js(['resources/js/jqueryPincodeAutotab.js'], jsOutput)
    .js(['resources/js/components/faq.js'], jsComponentsOutput)
    .js(['resources/js/components/our_app.js'], jsComponentsOutput)
    .js(['resources/js/components/news.js'], jsComponentsOutput)
    .js(['resources/js/components/gallery.js'], jsComponentsOutput)
    .js(['resources/js/components/events.js'], jsComponentsOutput)
    .js(['resources/js/components/slider-section-in-home-page.js'], jsComponentsOutput)
    .js(['resources/js/components/how-we-work.js'], jsComponentsOutput)
    .js(['resources/js/components/kiswa-benefits-home.js'], jsComponentsOutput)
    .js(['resources/js/components/contact-us.js'], jsComponentsOutput)
    .js(['resources/js/components/partners-section.js'], jsComponentsOutput)


    .postCss('resources/css/app.css', cssOutput, [])
    .postCss('resources/css/main.css', cssOutput, [])
    .postCss('resources/css/dashboard.css', cssOutput, [])
    .postCss('resources/css/dashboard.rtl.css', cssOutput, [])
    .postCss('resources/css/components/faq.css', cssComponentsOutput, [])
    .postCss('resources/css/components/faq_ar.css', cssComponentsOutput, [])
    .postCss('resources/css/components/our_app.css', cssComponentsOutput, [])
    .postCss('resources/css/components/news.css', cssComponentsOutput, [])
    .postCss('resources/css/components/news-ar.css', cssComponentsOutput, [])
    .postCss('resources/css/components/gallery.css', cssComponentsOutput, [])
    .postCss('resources/css/components/events.css', cssComponentsOutput, [])
    .postCss('resources/css/components/slider-section-in-home-page.css', cssComponentsOutput, [])
    .postCss('resources/css/components/slider-section-in-home-page-ar.css', cssComponentsOutput, [])
    .postCss('resources/css/components/how-we-work.css', cssComponentsOutput, [])
    .postCss('resources/css/components/how-we-work-ar.css', cssComponentsOutput, [])
    .postCss('resources/css/components/kiswa-benefits-home.css', cssComponentsOutput, [])
    .postCss('resources/css/components/kiswa-benefits-home-ar.css', cssComponentsOutput, [])
    .postCss('resources/css/components/offers-section.css', cssComponentsOutput, [])
    .postCss('resources/css/components/our-partners-home.css', cssComponentsOutput, [])
    .postCss('resources/css/components/news-details.css', cssComponentsOutput, [])
    .postCss('resources/css/components/events-details.css', cssComponentsOutput, [])
    .postCss('resources/css/components/our-partners-page.css', cssComponentsOutput, [])
    .postCss('resources/css/components/pagination-style.css', cssComponentsOutput, [])
    .postCss('resources/css/components/pagination-style-ar.css', cssComponentsOutput, [])
    .postCss('resources/css/components/offers-page.css', cssComponentsOutput, [])
    .postCss('resources/css/components/card-home.css', cssComponentsOutput, [])
    .postCss('resources/css/components/cards-component.css', cssComponentsOutput, [])
    .postCss('resources/css/components/what-do-we-receive-component.css', cssComponentsOutput, [])
    .postCss('resources/css/components/video-banner.css', cssComponentsOutput, [])
    .postCss('resources/css/components/image-content.css', cssComponentsOutput, [])
    .postCss('resources/css/components/contact-us.css', cssComponentsOutput, [])
    .postCss('resources/css/components/create-order.css', cssComponentsOutput, [])
    .postCss('resources/css/components/create-order-component.css', cssComponentsOutput, [])
