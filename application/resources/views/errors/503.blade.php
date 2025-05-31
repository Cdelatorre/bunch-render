<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title>{{ $general->siteName(__('503')) }}</title>
        <link rel="shortcut icon" href="{{ getImage(getFilePath('logoIcon') .'/favicon.png') }}" type="image/x-icon">

        {{--<!-- Apple Stuff -->--}}
        <link rel="apple-touch-icon" href="{{ getImage(getFilePath('logoIcon') .'/logo.png') }}">

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


        <link rel="stylesheet" href="{ assetTemplate() }}/css/main.css?v=9.2">
         <link rel="stylesheet" href="{ assetTemplate() }}/css/color.php?color={{ $general->base_color }}&secondColor={{ $general->secondary_color }}">
        <link rel="stylesheet" href="{{ assetTemplate() }}/css/custom.css">
    </head>
<body>

    <!--==================== Preloader Start ====================-->
    <div id="loading">
        <div id="loading-center">
            <div id="loading-center-absolute">
                <div class="loader"> </div>
            </div>
        </div>
    </div>
    <!--==================== Preloader End ====================-->

    <!--==================== Overlay Start ====================-->
    <div class="body-overlay"></div>
    <!--==================== Overlay End ====================-->

    <!--==================== Sidebar Overlay End ====================-->
    <div class="sidebar-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->

    <!-- ==================== Scroll to Top End Here ==================== -->
    <a class="scroll-top"><i class="fas fa-angle-double-up"></i></a>
    <!-- ==================== Scroll to Top End Here ==================== -->


    @include($activeTemplate.'components.header')

    @php
        $content = getContent('breadcumb.content', true);
    @endphp

    <section class="breadcumb">
        <img src="{{getImage(getFilePath('breadcumb').'/'. @$content->data_values->shape_image)}}" alt="shape" class="breadcumb-bg dark">
        <img src="{{getImage(getFilePath('breadcumb').'/'. @$content->data_values->shape_image_light)}}" alt="shape light" class="breadcumb-bg light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcumb__wrapper">
                        <h2 class="breadcumb__title">@lang('Service Unavailable')  </h2>
                        <ul class="breadcumb__list">
                            <li class="breadcumb__item"><a href="{{route('home')}}" class="breadcumb__link"> <i class="las la-home"></i> @lang('Home')</a> </li>
                            <li class="breadcumb__item"><i class="fas fa-chevron-right"></i> <i class="fas fa-chevron-right"></i></li>
                            <li class="breadcumb__item"> <span class="breadcumb__item-text">@lang('Service Unavailable')  </span> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="account py-80">
        <div class="account-inner">
            <div class="container">
                <div class="row gy-4 justify-content-center">
                    <div class="col-lg-6">
                        <div class="error-wrap text-center">
                            <div class="error__text">
                                <span>5</span>
                                <span>0</span>
                                <span>3</span>
                            </div>
                            <h2 class="error-wrap__title mb-3">@lang('Service Unavailable')</h2>
                            <p class="error-wrap__desc">@lang('Do not worry through, there always a way to go back home.')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include($activeTemplate.'components.footer')




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('assets/common/js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('assets/common/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset($activeTemplateTrue.'js/bootstrap.min.js')}}"></script>
    <!-- Slick js -->
    <script src="{{asset($activeTemplateTrue.'js/slick.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/emojionearea.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/jquery.appear.min.js')}}"></script>
    <!-- Magnific Popup js -->
    <script src="{{asset($activeTemplateTrue.'js/jquery.magnific-popup.min.js')}}"></script>
    <!-- Odometer js -->
    <script src="{{asset($activeTemplateTrue.'js/odometer.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/rangeSlider.js')}}"></script>
    <!-- Viewport js -->
    <script src="{{asset($activeTemplateTrue.'js/viewport.jquery.js')}}"></script>

    <!-- main js -->
    <script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script>

<script>
    (function ($) {
        "use strict";
        $(".langSel").on("change", function() {
            window.location.href = "{{route('home')}}/change/"+$(this).val() ;
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

</body>
</html>
