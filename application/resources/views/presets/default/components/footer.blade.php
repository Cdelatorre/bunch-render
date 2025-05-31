@php
$policyPages = getContent('policy_pages.element');
$socials = getContent('social_icon.element', false);
$contactContent = getContent('contact_us.content', true);
$subscribeContent = getContent('subscribe.content', true);
$importantLink = getContent('footer_important_links.element', false, null, true);
$companyLink = getContent('footer_company_links.element', false, null, true);
@endphp

<!-- ==================== Footer Start Here ==================== -->
<footer class="footer-area">
    <span class="banner-effect-1"></span>
    <div class="pt-120">
        <div class="container">
            <div class="row gy-5">
                <div class="col-xl- col-md-3 col-sm-6 col-6 footer-item-wrapper">
                    <div class="footer-item">
                        <h5 class="footer-item__title">{{ __($general->site_name) }}</h5>
                        {{-- <div class="title-border">
                            <span class="long"></span>
                            <span class="short"></span>
                        </div> --}}
                        <ul class="footer-menu">
                            @foreach($companyLink as $item)
                            <li class="footer-menu__item"><a href="{{$item->data_values->url}}" class="footer-menu__link">{{ __(@$item->data_values->title) }}</a> </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl- col-md-3 col-sm-6 col-6 footer-item-wrapper d-flex justify-content-end justify-content-md-start">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Collaborators')</h5>
                        {{-- <div class="title-border">
                            <span class="long"></span>
                            <span class="short"></span>
                        </div> --}}
                        <ul class="footer-menu text-end text-md-start">
                            @foreach($importantLink as $item)
                            <li class="footer-menu__item"><a href="{{$item->data_values->url}}" class="footer-menu__link">{{ __(@$item->data_values->title)}}</a> </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 col-12 mb-5 d-flex justify-content-end order-first order-md-last d-md-flex">
                    <div class="footer-item">
                        <div class="footer-item__logo">
                            <a href="{{route('home')}}" class="footer-logo-normal"> <img src="{{ getImage('assets/images/general/logo.png') }}" alt="@lang('Normal Logo')"></a>
                            <a href="{{route('home')}}" class="footer-logo-dark hidden"> <img src="{{ getImage('assets/images/general/logo_white.png') }}" alt="@lang('Dark Logo')"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gy-5 mt-5">
                <div class="col-md-3 col-sm-12 col-12 mb-5 mt-2 d-flex  order-1 order-md-0">
                    <div class="footer-item w-100">
                        <ul class="footer-contact-menu d-flex flex-row flex-md-column justify-content-between">
                            @foreach ($policyPages as $link)
                            <li class="footer-menu__item"><a class="footer-menu__link footer-menu__terms" target="__blank" href="{{ route('policy.pages',[slug($link->data_values->title),$link->id]) }}">{{ __(@$link->data_values->title) }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 offset-md-1 col-sm-8 offset-sm-2  col-12 mb-5 mt-2 d-flex flex-wrap align-content-end justify-content-center order-last order-md-0">
                    <div class="footer-item">
                        <p class="footer-item__legal">© 2025 bunchofclubs. Todos los derechos reservados. </br> No somos un gimnasio. Somos todos.</p>
                    </div>
                </div>
                <div class="col-md-3 offset-md-1 col-sm-12 col-12 mb-5 mt-2">
                    <div class="row gy-2">
                        <div class="col-lg-12 col-md-12 ">
                            <div class="d-flex justify-content-between justify-content-md-end align-items-center flex-wrap">
                                <ul class="footer-contact-menu mb-2 mb-md-0">
                                    <li class="footer-contact-menu__item">
                                        <div class="footer-contact-menu__item-content">
                                            <p class="mb-0">
                                                <a href="mailto:{{__(@$contactContent->data_values->email)}}">
                                                    {{__(@$contactContent->data_values->email)}}
                                                </a>
                                            </p>
                                        </div>
                                    </li>
                                </ul>

                                <div class="login-social-wrap d-block d-md-none">
                                    <ul class="social-list mb-0 d-flex">
                                        @foreach($socials as $item)
                                        <li class="social-list__item d-inline-block me-2">
                                            <a href="{{$item->data_values->url}}" class="social-list__link d-inline">
                                                @php echo $item->data_values->social_icon; @endphp
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 d-none d-md-block">
                            <div class="footer-row d-flex justify-content-end align-items-center">
                                <div class="login-social-wrap">
                                    <ul class="social-list mt-1">
                                        @foreach($socials as $item)
                                        <li class="social-list__item d-inline-block me-2">
                                            <a href="{{$item->data_values->url}}" class="social-list__link d-inline">
                                                @php echo $item->data_values->social_icon; @endphp
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="bottom-footer-text text-end">
                                    @php echo $contactContent->data_values->website_footer; @endphp
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="footer-border-bottom"></div>
        </div>
    </div>
    <!-- Footer Top End-->
    </div>

</footer>
<!-- ==================== Footer End Here ==================== -->