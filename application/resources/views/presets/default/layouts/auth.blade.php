<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title> {{ $general->siteName(__($pageTitle)) }}</title>
        @include('includes.seo')
        <!-- Bootstrap CSS -->
        <link href="{{ asset('assets/common/css/bootstrap.min.css') }}" rel="stylesheet">

        <link href="{{ asset('assets/common/css/all.min.css') }}" rel="stylesheet">

        <link rel="stylesheet" href="{{asset('assets/common/css/line-awesome.min.css')}}">

        <!-- Magnific Popup -->
        <link rel="stylesheet" href="{{ assetTemplate() }}/css/magnific-popup.css">
        <!-- Custom Animation -->
        <!-- Slick -->
        <link rel="stylesheet" href="{{ assetTemplate() }}/css/emojionearea.min.css">
        <link rel="stylesheet" href="{{ assetTemplate() }}/css/animate.min.css">
        <link rel="stylesheet" href="{{ assetTemplate() }}/css/slick.css">
        <!-- Odometer -->
        <link rel="stylesheet" href="{{ assetTemplate() }}/css/custom-animation.css">
        <link rel="stylesheet" href="{{ assetTemplate() }}/css/odometer.css">


        @stack('style')

        @stack('style-lib')


        <link rel="stylesheet" href="{{ assetTemplate() }}/css/main.css?v=9.2">
         <link rel="stylesheet" href="{{ assetTemplate() }}/css/color.php?color={{ $general->base_color }}&secondColor={{ $general->secondary_color }}">
        <link rel="stylesheet" href="{{ assetTemplate() }}/css/custom.css">

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_ANALYTICS_KEY') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{ env('GOOGLE_ANALYTICS_KEY') }}');
        </script>
    </head>
<body class="auth-section bg-img">

    <!--==================== Preloader Start ====================-->
    <div id="loading">
        <div id="loading-center">
            <div id="loading-center-absolute">
                <div class="loader">
                    <img class="" src="{{asset('assets/images/general/logo.png')}}" alt="@lang('Logo')">
                </div>
            </div>
        </div>
    </div>
    <!--==================== Preloader End ====================-->

    <!-- ==================== Scroll to Top End Here ==================== -->
    <a class="scroll-top"><i class="fas fa-angle-double-up"></i></a>
    <!-- ==================== Scroll to Top End Here ==================== -->

    @stack('fbComment')
    <div class="py-60">
        <div class="container">
            <div class="row">
                <div class="auth-section_logo">
                    <div class="auth-item__logo">
                        <a href="{{route('home')}}" class="auth-logo_normal"> <img src="{{ getImage('assets/images/general/logo.png') }}" alt="@lang('Normal Logo')"></a>
                    </div>
                </div>
            </div>
        </div>
        @yield('content')
    </div>

    @php
        $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
    @endphp
    @if(($cookie->data_values->status == 1) && !\Cookie::get('gdpr_cookie'))
        <!-- cookies dark version start -->
        <div class="d-flex justify-content-center">
            <div class="cookies-card hide text-center">
                <p class="cookies-card__content">@lang($cookie->data_values->short_desc) <a class="text--base"
                        href="{{ route('cookie.policy') }}" target="_blank">@lang('learn more')</a> <a href="javascript:void(0)"
                        class="btn btn--base btn--sm border-none policy ms-4">@lang('Accept')</a></p>
            </div>
        </div>
    <!-- cookies dark version end -->
    @endif


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('assets/common/js/jquery-3.7.1.min.js')}}"></script>

    <script src="{{ assetTemplate() }}/js/moment.min.js"></script>
    <script src="{{ assetTemplate() }}/js/popper.min.js"></script>

    <script src="{{ assetTemplate() }}/js/bootstrap.min.js"></script>
    <!-- Slick js -->
    <script src="{{ assetTemplate() }}/js/slick.min.js"></script>
    <script src="{{ assetTemplate() }}/js/emojionearea.js"></script>
    <script src="{{ assetTemplate() }}/js/jquery.appear.min.js"></script>
    <!-- Magnific Popup js -->
    <script src="{{ assetTemplate() }}/js/jquery.magnific-popup.min.js"></script>
    <!-- Odometer js -->
    <script src="{{ assetTemplate() }}/js/odometer.min.js"></script>
    <script src="{{ assetTemplate() }}/js/rangeSlider.js"></script>
    <!-- Viewport js -->
    <script src="{{ assetTemplate() }}/js/viewport.jquery.js"></script>


    @stack('script-lib')

    @stack('script')

    @include('includes.plugins')

    @include('includes.notify')
    <!-- main js -->
    <script src="{{ assetTemplate() }}/js/main.js"></script>

    <script>
        (function ($){
            "use strict";
            $('.login-upcomming-bid').on('click', function() {
                var modal = $('#login-upcomming-bid');
                modal.modal('show');
            });

            $('.wishlist-btn').on('click', function(event) {
                event.preventDefault();
                var product_id = $(this).data('product_id');
                var $button = $(this);
                var $icon = $button.find("i");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '{{route('user.wishlist')}}',
                    data: {

                        product_id: product_id,

                    },
                    success: function (response) {

                        if(response.statusCode == 1) // Removed
                        {
                            $icon.removeClass("fas fa-heart").addClass("far fa-heart");
                            $('.wishlist-count').text(response.wishlistCount);

                            Toast.fire({
                                icon: 'success',
                                title: response.status,
                                iconColor: '#F67280',
                                iconHtml: '<i class="far fa-heart"></i>',
                                animation: false,
                                customClass: {
                                    popup: 'wishlist-toast',
                                    closeButton: 'wishlist-toast-close',
                                },
                                theme: 'dark',
                                padding: '16px',
                                showCloseButton: true,
                            });
                        } else if (response.statusCode == 2) // Added
                        {
                            $icon.removeClass("far fa-heart").addClass("fas fa-heart");
                            $('.wishlist-count').text(response.wishlistCount);

                            Toast.fire({
                                icon: 'success',
                                title: response.status,
                                iconColor: '#F67280',
                                iconHtml: '<i class="fas fa-heart"></i>',
                                animation: false,
                                customClass: {
                                    popup: 'wishlist-toast',
                                    closeButton: 'wishlist-toast-close',
                                },
                                theme: 'dark',
                                padding: '16px',
                                showCloseButton: true,
                            });
                        }


                    },
                    error: function (error) {

                        Toast.fire({
                                icon: 'error',
                                title: response.status
                            });
                    }
                });

            });

        })(jQuery);
    </script>

<script>
    (function ($) {
        "use strict";
        $(".langSel").on("change", function() {
            window.location.href = "{{route('home')}}/change/"+$(this).val() ;
        });

        $('[data-bs-toggle="popover"]').each(function (popoverTriggerEl) {
            popoverTriggerEl = $(popoverTriggerEl);
            return new bootstrap.Popover(popoverTriggerEl)
        });

        var inputElements = $('input,select');
        $.each(inputElements, function (index, element) {
            element = $(element);
            element.closest('.form-group').find('label').attr('for',element.attr('name'));
            element.attr('id',element.attr('name'))
        });

        $('.policy').on('click',function(){
            $.get('{{route('cookie.accept')}}', function(response){
                $('.cookies-card').addClass('d-none');
            });
        });

        setTimeout(function(){
            $('.cookies-card').removeClass('hide')
        },2000);

        var inputElements = $('[type=text],select,textarea');
        $.each(inputElements, function (index, element) {
            element = $(element);
            element.closest('.form-group').find('label').attr('for',element.attr('name'));
            element.attr('id',element.attr('name'))
        });

        $.each($('input, select, textarea'), function (i, element) {

            if (element.hasAttribute('required')) {
                $(element).closest('.form-group').find('label').addClass('required');
            }

        });

    })(jQuery);
</script>


<script>
    $(document).ready(function() {
        "use strict";
        var countdownElements = $('.countdown');

        countdownElements.each(function() {
            var targetDate = $(this).data('date');
            initializeCountdown($(this), targetDate);
        });

        function initializeCountdown(element, targetDate) {
            var targetTime = new Date(targetDate).getTime();

            if (isNaN(targetTime)) {
                console.error('Invalid date format:', targetDate);
                return;
            }

            function updateRemainingTime() {
                var now = new Date().getTime();
                var remainingTime = targetTime - now;

                var absRemainingTime = Math.abs(remainingTime);

                var days = Math.floor(absRemainingTime / (24 * 60 * 60 * 1000));
                var hours = Math.floor((absRemainingTime % (24 * 60 * 60 * 1000)) / (60 * 60 * 1000));
                var minutes = Math.floor((absRemainingTime % (60 * 60 * 1000)) / (60 * 1000));
                var seconds = Math.floor((absRemainingTime % (60 * 1000)) / 1000);

                element.text(days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's');
            }

            updateRemainingTime();
            setInterval(updateRemainingTime, 1000);
        }
    });

</script>

</body>
</html>
