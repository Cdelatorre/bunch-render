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
        <link rel="stylesheet" href="{{ assetTemplate() }}/css/animate.min.css">
        <link rel="stylesheet" href="{{ assetTemplate() }}/css/slick.css">
        <link rel="stylesheet" href="{{ assetTemplate() }}/css/odometer.css">
        <link rel="stylesheet" href="{{ assetTemplate() }}/css/custom.css">
<!-- etc. -->

        <link rel="stylesheet" href="{{ assetTemplate() }}/css/emojionearea.min.css">
        <link rel="stylesheet" href="{{ assetTemplate() }}/css/animate.min.css">
        <link rel="stylesheet" href="{{ assetTemplate() }}/css/slick.css">
        <!-- Odometer -->
        <link rel="stylesheet" href="{{ assetTemplate() }}/css/custom-animation.css">
        <link rel="stylesheet" href="{{ assetTemplate() }}/css/odometer.css">
        <link rel="stylesheet" href="{{ assetTemplate() }}/css/main.css?v=9.2">




        <style>
        .header-wrapper .logo-wrapper {
            padding-block: 24px;
        }
        .header.fixed-header {
            border: none;
        }
        @media screen and (max-width: 991px) {
            .header-wrapper .logo-wrapper {
                padding-block: 12px;
            }
        }
        </style>
    </head>
<body>

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

    <div class="header-main-area">
        <div class="header" id="header">
            <div class="container position-relative">
                <div class="row">
                    <div class="header-wrapper">
                        <div class="logo-wrapper">
                            <a href="{{route('home')}}" class="normal-logo"> <img src="{{ getImage('assets/images/general/logo.png') }}" alt="@lang('Normal Logo')"></a>
                        </div>

                        <div class="menu-wrapper">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container position-relative ">
        <div class="row justify-content-center align-items-center onboarding-section">
            <div class="col-md-8 text-center">
                <form id="onboarding-form" action="{{ route('submitOnBoarding') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="onboarding-step" id="step-1">
                        <span class="onboarding-count-steps">1 / {{ $countSteps }}</span>
                        <h1 class="title">@lang("Let's go!")</h1>
                        <p class="description">@lang('Tell us about your center to easily create your profile.')</p>
                        <p class="description">@lang('It will take you less than 2 minutes.')</p>
                        <img class="onboarding-gym" src="{{ assetTemplate() }}/images/gym.png" alt="Gym">
                        <button type="button" class="btn btn--base next-btn start-btn" data-target="#step-2" data-form="start">@lang('Get started')</button>
                    </div>

                    <div class="onboarding-step" id="step-2" style="display:none;">
                        <span class="onboarding-count-steps">2 / {{ $countSteps }}</span>
                        <h2 class="title">@lang("Center name")</h2>
                        <p class="description">@lang('Tell them who you are')</p>
                        <div class="onboarding-form-wrapper">
                            <input class="form--control custom-form-field" type="text" name="title" value="" placeholder="@lang('Write the name of your center here')" required>
                        </div>
                        <button type="button" class="btn btn--default prev-btn" data-target="#step-1">@lang('Back')</button>
                        <button type="button" class="btn btn--base next-btn" data-target="#step-3" data-form="title">@lang('Next')</button>
                    </div>

                    <div class="onboarding-step" id="step-3" style="display:none;">
                        <span class="onboarding-count-steps">3 / {{ $countSteps }}</span>
                        <h2 class="title">@lang('Where is your center located?')</h2>
                        <p class="description">@lang('Shows where to find you')</p>
                        <div class="onboarding-form-wrapper">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <input type="text" name="autocomplete" class="form--control custom-form-field" id="autocomplete" placeholder="@lang('Find Your Location')">
                                </div>
                                <div class="col-6 mb-3">
                                    <input class="form--control custom-form-field" type="text" name="address[street_name]" value="" placeholder="@lang('Street Name')" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <input class="form--control custom-form-field" type="text" name="address[street_number]" value="" placeholder="@lang('Street Number')">
                                </div>
                                <div class="col-6 mb-3">
                                    <input class="form--control custom-form-field" type="text" name="address[zip_code]" value="" placeholder="@lang('Zip Code')" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <input class="form--control custom-form-field" type="text" name="address[locality]" value="" placeholder="@lang('Locality')" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <input class="form--control custom-form-field" type="text" name="address[province]" value="" placeholder="@lang('Province')" required>
                                </div>
                                <input class="d-none" type="text" name="latitude">
                                <input class="d-none" type="text" name="longitude">
                                <input class="d-none" type="text" name="formatted_address">
                                <input class="d-none" type="text" name="place_id">
                                <input class="d-none" type="text" name="google_rating">
                                <input class="d-none" type="text" name="google_review_count">
                            </div>
                        </div>
                        <button type="button" class="btn btn--default prev-btn" data-target="#step-2">@lang('Back')</button>
                        <button type="button" class="btn btn--base next-btn" data-target="#step-4" data-form="address">@lang('Next')</button>
                    </div>

                    <div class="onboarding-step" id="step-4" style="display:none;">
                        <span class="onboarding-count-steps">4 / {{ $countSteps }}</span>
                        <h2 class="title">@lang('Add a description')</h2>
                        <p class="description">@lang('Introduce your space')</p>
                        <div class="onboarding-form-wrapper">
                            <textarea class="form--control trumEdit wyg" name="description" placeholder="@lang('Introduce your space')"></textarea>
                        </div>
                        <button type="button" class="btn btn--default prev-btn" data-target="#step-3">@lang('Back')</button>
                        <button type="button" class="btn btn--base next-btn" data-target="#step-5" data-form="description">@lang('Next')</button>
                    </div>

                    <div class="onboarding-step" id="step-5" style="display:none;">
                        <span class="onboarding-count-steps">5 / {{ $countSteps }}</span>
                        <h2 class="title">@lang('Show off the best of your gym')</h2>
                        <p class="description">@lang('Upload up to 10 images to highlight your facilities and services.')</p>
                        <p class="description">@lang('Make clients imagine working out with you!')</p>

                        <div class="onboarding-form-wrapper">
                            <div class="col-md-12">
                                <div class="photo_upload">
                                    <div class="drag_area" id="dragArea">
                                        <div class="drag_drop_content">
                                            <span title="@lang('Click to add Image')" class="icon_wrap" role="button" id="selectFiles"><i class="las la-file-image"></i></span>
                                        </div>
                                        <input name="images[]" type="file" class="file" multiple id="fileInput" accept=".jpg, .png, .jpeg" />
                                    </div>
                                    <div class="container_area" id="containerArea"></div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn--default prev-btn" data-target="#step-4">@lang('Back')</button>
                        <button type="button" class="btn btn--base next-btn" data-target="#step-6" data-form="images">@lang('Next')</button>
                    </div>

                    <div class="onboarding-step" id="step-6" style="display:none;">
                        <span class="onboarding-count-steps">6 / {{ $countSteps }}</span>
                        <h2 class="title">@lang('What activities do you offer?')</h2>
                        <p class="description">@lang('Select all the activities available at your center.')</p>
                        <p class="description">@lang('From yoga to zumba, everything counts!')</p>
                        <div class="onboarding-form-wrapper">
                            <div class="action-category-wrapper">
                                @forelse($categories as $category)
                                    <button type="button" data-id="{{ $category->id }}" id="btn_categories_{{$category->id}}" class="action-category-item btn-activity">
                                        <div class="action-category-item__icon">
                                            @php echo $category->icon; @endphp
                                        </div>
                                        <div class="action-category-item__text">
                                            <p>{{__(@$category->name)}}</p>
                                        </div>
                                        <input class="form-check-input filtered_category d-none" name="categories[]" type="checkbox" value="{{$category->id}}" id="categories_{{$category->id}}">
                                    </button>
                                    @empty
                                @endforelse
                            </div>
                        </div>
                        <button type="button" class="btn btn--default prev-btn" data-target="#step-5">@lang('Back')</button>
                        <button type="button" class="btn btn--base next-btn" data-target="#step-7 " data-form="categories">@lang('Next')</button>
                    </div>
                    @foreach ($rootServices as $services)
                    <div class="onboarding-step" id="step-{{ 7 + $loop->index }}" style="display:none;">
                        <span class="onboarding-count-steps">{{ 7 + $loop->index }} / {{ $countSteps }}</span>
                        <h2 class="title">@lang('Your facility, in detail.')</h2>
                        <p class="description">@lang('List all available facilities.')</p>
                        <p class="description">@lang('Let users discover what makes your gym unique.')</p>
                        <div class="onboarding-form-wrapper">
                            <p class="description">{{ $services->name }}</p>
                            <div class="action-services-wrapper">
                                @foreach ($services->children as $service)
                                <button type="button" data-id="{{ $service->id }}" id="btn_services_{{$service->id}}" class="action-service-item btn-service">
                                    <div class="action-service-item__text">
                                        <p>{{__(@$service->name)}}</p>
                                    </div>
                                </button>
                                <input class="form-check-input filtered_category d-none" name="services[]" type="checkbox" value="{{$service->id}}" id="services_{{$service->id}}">
                                @endforeach
                            </div>
                         </div>
                        <button type="button" class="btn btn--default prev-btn" data-target="#step-{{ 6 + $loop->index }}">@lang('Back')</button>
                        <button type="button" class="btn btn--base next-btn" data-target="#step-{{ 8 + $loop->index }}" {{ $loop->index === (count($rootServices) - 1) ?"data-form=services" : "" }}>@lang('Next')</button>
                    </div>
                    @endforeach
                    @php $lastServiceId = 6 + count($rootServices) + 1; @endphp
                    <div class="onboarding-step" id="step-{{ $lastServiceId++ }}" style="display:none;">
                        <span class="onboarding-count-steps">{{ $lastServiceId - 1 }} / {{ $countSteps }}</span>
                        <h2 class="title">@lang('Define your rates')</h2>
                        <p class="description">@lang('Indicate the price of your memberships, vouchers or individual classes.')</p>
                        <p class="description">@lang('Be clear and transparent!')</p>
                        <div class="onboarding-form-wrapper">
                            <div class="row">
                                <div class="col-4 mb-3">
                                    <input class="form--control custom-form-field" type="text" name="rates[0][title]" value="" placeholder="@lang('Title')">
                                </div>
                                <div class="col-5 mb-3">
                                    <input class="form--control custom-form-field" type="text" name="rates[0][description]" value="" placeholder="@lang('Description')">
                                </div>
                                <div class="col-3 mb-3">
                                    <input class="form--control custom-form-field" type="number" name="rates[0][price]" value="" placeholder="@lang('Ex'). 5.50">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 mb-3">
                                    <input class="form--control custom-form-field" type="text" name="rates[1][title]" value="" placeholder="@lang('Title')">
                                </div>
                                <div class="col-5 mb-3">
                                    <input class="form--control custom-form-field" type="text" name="rates[1][description]" value="" placeholder="@lang('Description')">
                                </div>
                                <div class="col-3 mb-3">
                                    <input class="form--control custom-form-field" type="number" name="rates[1][price]" value="" placeholder="@lang('Ex'). 5.50">
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-4 mb-3">
                                    <input class="form--control custom-form-field" type="text" name="rates[2][title]" value="" placeholder="@lang('Title')">
                                </div>
                                <div class="col-5 mb-3">
                                    <input class="form--control custom-form-field" type="text" name="rates[2][description]" value="" placeholder="@lang('Description')">
                                </div>
                                <div class="col-3 mb-3">
                                    <input class="form--control custom-form-field" type="number" name="rates[2][price]" value="" placeholder="@lang('Ex'). 5.50">
                                </div>
                            </div>
                        </div>
                        <p class="description">*@lang('You can add more rates and offers later in your profile')</p>
                        <button type="button" class="btn btn--default prev-btn" data-target="#step-{{ $lastServiceId - 2 }}">@lang('Back')</button>
                        <button type="button" class="btn btn--base next-btn" data-target="#step-{{ $lastServiceId }}" data-form="rates">@lang('Next')</button>
                    </div>
                    <div class="onboarding-step" id="step-{{ $lastServiceId++ }}" style="display:none;">
                        <span class="onboarding-count-steps">{{ $lastServiceId - 1 }} / {{ $countSteps }}</span>
                        <h2 class="title">@lang('Organize your schedules')</h2>
                        <p class="description">@lang('Indicate your opening hours and the time slots for your main activities.')</p>
                        <p class="description">@lang('Make planning easier for your clients!')</p>
                        <div class="onboarding-form-wrapper">
                            <div class="schedules-input-section">
                                <div class="row extraSchedules">
                                    @php
                                        $schedules = [[
                                            "name" => "Monday - Friday",
                                            "start_time" => "09:00",
                                            "end_time" => "17:00",
                                            "status" => "opened",
                                        ],[
                                            "name" => "Saturday",
                                            "start_time" => "09:00",
                                            "end_time" => "17:00",
                                            "status" => "opened",
                                        ],[
                                            "name" => "Sunday",
                                            "start_time" => "09:00",
                                            "end_time" => "17:00",
                                            "status" => "opened",
                                        ]];
                                    @endphp
                                    @forelse($schedules as $schedule)
                                    <div class="data-extra-schedules mb-3">
                                        <div class="row">
                                            <div class="col-12 col-md-3 mb-2">
                                                <div class="form-group">
                                                    <input class="form-control custom-form-field" name="schedules[{{$loop->index}}][name]" type="text" required readonly border-none placeholder="@lang('Name')"  value="{{$schedule['name']}}">
                                                </div>
                                            </div>
                                            <div class="col-4 col-md-3 mb-1">
                                                <div class="form-group">
                                                    <select name="schedules[{{$loop->index}}][start_time]" value="{{$schedule['start_time']}}" class="form--control form-dark-select" required>
                                                        @for ($i = 0; $i < 24 * 2; $i++)
                                                            @php
                                                                $time = \Carbon\Carbon::createFromTime(0, 0, 0)->addMinutes($i * 30);
                                                            @endphp
                                                            <option value="{{ $time->format('H:i') }}" {{ $schedule['start_time'] == $time->format('H:i') ? 'selected' : '' }}>{{ $time->format('h:i A') }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4 col-md-3 mb-1">
                                                <div class="form-group">
                                                    <select name="schedules[{{$loop->index}}][end_time]" value="{{$schedule['end_time']}}" class="form--control form-dark-select" required>
                                                        @for ($i = 0; $i < 24 * 2; $i++)
                                                            @php
                                                                $time = \Carbon\Carbon::createFromTime(0, 0, 0)->addMinutes($i * 30);
                                                            @endphp
                                                            <option value="{{ $time->format('H:i') }}" {{ $schedule['end_time'] == $time->format('H:i') ? 'selected' : '' }}>{{ $time->format('h:i A') }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4 col-md-3 mb-1">
                                                <div class="form-group">
                                                    <select name="schedules[{{$loop->index}}][status]" value="{{$schedule['status']}}" class="form--control form-dark-select" required>
                                                        <option value="opened" {{ $schedule['status'] == 'opened' ? 'selected' : '' }}>@lang('Opened')</option>
                                                        <option value="closed" {{ $schedule['status'] == 'closed' ? 'selected' : '' }}>@lang('Closed')</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn--default prev-btn" data-target="#step-{{ $lastServiceId - 2 }}">@lang('Back')</button>
                        <button type="button" class="btn btn--base next-btn" data-target="#step-{{ $lastServiceId }}" data-form="schedules">@lang('Next')</button>
                    </div>
                    <div class="onboarding-step" id="step-{{ $lastServiceId++ }}" style="display:none;">
                        <span class="onboarding-count-steps">{{ $lastServiceId - 1 }} / {{ $countSteps }}</span>
                        <h2 class="title">@lang('Choose how to connect with your customers')</h2>
                        <p class="description">@lang('Select the main action they can take from your profile: request a free visit, view your website or contact you directly')</p>
                        <div class="onboarding-form-wrapper">
                            <div class="row cta-section">
                                <div class="mb-2">
                                    <input type="radio" id="free-visit" name="call_to_action" value="0" checked="checked">
                                    <label for="free-visit">@lang('Request a free visit')</label>
                                </div>
                                <div class="mb-2">
                                    <input type="radio" id="see-the-website" name="call_to_action" value="1">
                                    <label for="see-the-website">@lang('See the website')</label>
                                </div>
                                <div class="mb-2">
                                    <input type="radio" id="see-instagram" name="call_to_action" value="2">
                                    <label for="see-instagram">@lang('See the instagram')</label>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn--default prev-btn" data-target="#step-{{ $lastServiceId - 2 }}">@lang('Back')</button>
                        <button type="button" class="btn btn--base next-btn" data-target="#step-{{ $lastServiceId }}" data-form="callToAction">@lang('Next')</button>
                    </div>
                    @guest()
                    <div class="onboarding-step" id="step-{{ $lastServiceId++ }}" style="display:none;">
                        <span class="onboarding-count-steps">{{ $lastServiceId - 1 }} / {{ $countSteps }}</span>
                        <h2 class="title">@lang('Register as center owner')</h2>
                        <p class="description">@lang('Owner fills out the registration form (username, email, password).')</p>
                        <div class="onboarding-form-wrapper">
                            <div class="row gy-3">
                                <div class="col-sm-12">
                                     <div class="form-group position-relative">
                                        <input type="text" class="form--control custom-form-field checkUser" name="username" value="" required placeholder="@lang('Username')">
                                        <small class="text-danger usernameExist"></small>
                                        <div class="password-show-hide far fa-user "></div>
                                     </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group position-relative">
                                        <input type="email" class="form--control custom-form-field checkUser" name="email" value="{{ request()->query('email') }}" required placeholder="@lang('Email')" readonly>
                                        <div class="password-show-hide fas fa-envelope"></div>
                                     </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group position-relative">
                                        <input id="password" type="password" class="form--control custom-form-field" name="password" placeholder="@lang('Password')" required>
                                        <div class="password-show-hide fas fa-eye-slash toggle-password-change" data-target="password"> </div>
                                        @if($general->secure_password)
                                            <div class="input-popup">
                                                <p class="error lower">@lang('1 small letter minimum')</p>
                                                <p class="error capital">@lang('1 capital letter minimum')</p>
                                                <p class="error number">@lang('1 number minimum')</p>
                                                <p class="error special">@lang('1 special character minimum')</p>
                                                <p class="error minimum">@lang('6 character password')</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group position-relative">
                                        <input id="password_confirmation" type="password" class="form--control custom-form-field" name="password_confirmation"  placeholder="@lang('Confirm Password')" required>
                                        <div class="password-show-hide fas fa-eye-slash toggle-password-change" data-target="password_confirmation"> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn--default prev-btn" data-target="#step-{{ $lastServiceId - 2 }}">@lang('Back')</button>
                        <button type="button" class="btn btn--base next-btn" data-target="#step-{{ $lastServiceId }}" data-form="register">@lang('Next')</button>
                    </div>
                    @endguest()
                    <div class="onboarding-step" id="step-{{ $lastServiceId++ }}" style="display:none;">
                        <span class="onboarding-count-steps">{{ $lastServiceId - 1 }} / {{ $countSteps }}</span>
                        <h2 class="title">@lang('All set to go!')</h2>
                        <p class="description">@lang('Your gym is now part of Fitters.')</p>
                        <p class="description">@lang('Activate your profile and start receiving clients today.')</p>
                        <button type="submit" class="btn btn--base finish-btn" id="finish-btn" data-form="finish">@lang('Finish')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('assets/common/js/jquery-3.7.1.min.js')}}"></script>
    {{-- <script src="{{asset('assets/comm/on/js/bootstrap.min.bundle.js')}}"></script> --}}



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

    <script src="{{ asset('assets/common/js/ckeditor.js') }}"></script>

    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places" ></script>
    <script src="{{ asset('assets/common/js/find_location.js') }}"></script>

    @include('includes.notify')
    @include('includes.plugins')

    <!-- main js -->
    <script src="{{ assetTemplate() }}/js/main.js"></script>

<script>
    $(document).ready(function() {
        "use strict";

        @if($general->secure_password)
            $('input[name=password]').on('input',function(){
                secure_password($(this));
            });

            $('[name=password]').focus(function () {
                $(this).closest('.form-group').addClass('hover-input-popup');
            });

            $('[name=password]').focusout(function () {
                $(this).closest('.form-group').removeClass('hover-input-popup');
            });
        @endif

        $(".trumEdit").each(function () {
            ClassicEditor
            .create(this)
            .then(editor => {
                window.editor = editor;
            });
        });

        $('form').on('submit', function () {
            if ($(this).valid()) {
                $(':submit', this).attr('disabled', 'disabled');
            }
        });

        var inputElements = $('[type=text],[type=password],select,textarea');
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


        let headings = $('.table th');
        let rows = $('.table tbody tr');
        let columns
        let dataLabel;

        $.each(rows, function (index, element) {
            columns = element.children;
            if (columns.length == headings.length) {
                $.each(columns, function (i, td) {
                    dataLabel = headings[i].innerText;
                    $(td).attr('data-label', dataLabel)
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        var images = [];
        function selectFiles() {
            $("#fileInput").click();
        }

        function onFileSelect(event) {
            const files = event.target.files;
            if (files.length === 0) return;
            for (let i = 0; i < files.length; i++) {
                if (files[i].type.split('/')[0] !== 'image') continue;
                if (!images.some((e) => e.name == files[i].name)) {
                    images.push({
                        name: files[i].name,
                        url: URL.createObjectURL(files[i])
                    });
                }
            }
            updateImages();
        }

        function deleteImage(index) {
            images.splice(index, 1);
            updateImages();
        }

        function updateImages() {
            $("#containerArea .image.uploaded").remove();
            images.forEach(function (image, index) {
                var deleteButton = $(`<span class="delete deleteImage" data-index="${index}"><i class="las la-times"></i></span>`);
                var imageDiv = $('<div class="image uploaded"></div>').append(deleteButton).append($('<img src="' + image.url + '" alt="..."/>'));
                $("#containerArea").append(imageDiv);
            });
        }

        $(document).on('click', '.deleteImage', function () {
            const index = $(this).data('index');
            deleteImage(index);
        });

        $("#selectFiles").click(selectFiles);
        $("#fileInput").change(onFileSelect);


        $(document).on('click', '.btn-activity', function () {
            const activityId = $(this).data('id');

            const $checkbox = $(`input[type="checkbox"][id^="categories_${activityId}"]`);
            $(this).toggleClass('selected');
            $checkbox.prop('checked', $(this).hasClass('selected'));
        });

        $(document).on('click', '.btn-service', function () {
            const serviceId = $(this).data('id');

            const $checkbox = $(`input[type="checkbox"][id^="services_${serviceId}"]`);
            $(this).toggleClass('selected');
            $checkbox.prop('checked', $(this).hasClass('selected'));
        });

        function validateForm(form) {
            var validate = {
                status: true,
                message: ''
            };

            switch (form) {
                case 'title':
                    if ($('input[name="title"]').val().trim() === '') {
                        validate.status = false;
                        validate.message = "@lang('Title is required')";
                        $('input[name="title"]').focus();
                    }
                    break;
                case 'address':
                    if ($('input[name="address[street_name]"]').val().trim() === '') {
                        validate.status = false;
                        validate.message = "@lang('Street Name is required')";
                        $('input[name="address[street_name]"]').focus();
                    } else if ($('input[name="address[street_number]"]').val().trim() === '') {
                        validate.status = false;
                        validate.message = "@lang('Street Number is required')";
                        $('input[name="address[street_number]"]').focus();
                    } else if ($('input[name="address[zip_code]"]').val().trim() === '') {
                        validate.status = false;
                        validate.message = "@lang('Zip Code is required')";
                        $('input[name="address[zip_code]"]').focus();
                    } else if ($('input[name="address[locality]"]').val().trim() === '') {
                        validate.status = false;
                        validate.message = "@lang('Locality is required')";
                        $('input[name="address[locality]"]').focus();
                    } else if ($('input[name="address[province]"]').val().trim() === '') {
                        validate.status = false;
                        validate.message = "@lang('Province is required')";
                        $('input[name="address[province]"]').focus();
                    }
                    break;
                case 'description':
                    if (editor.getData() === '') {
                        validate.status = false;
                        validate.message = "@lang('Description is required')";
                    }
                    break;
                case 'images':
                    if (images.length === 0) {
                        validate.status = false;
                        validate.message = "@lang('Images are required')";
                    }
                    break;
                case 'categories':
                    if ($('input[name="categories[]"]:checked').length === 0) {
                        validate.status = false;
                        validate.message = "@lang('Activities are required')";
                    }
                    break;
                // case 'services':
                    // if ($('input[name="services[]"]:checked').length === 0) {
                    //     validate.status = false;
                    //     validate.message = "@lang('Services are required')";
                    // }
                    // break;
                case 'schedules':
                    for (let i = 0; i < 3; i++) {
                        if ($(`input[name="schedules[${i}][name]"]`).val().trim() === '') {
                            validate.status = false;
                            validate.message = "@lang('Name is required')";
                            $(`input[name="schedules[${i}][name]"]`).focus();
                            break;
                        } else if ($(`input[name="schedules[${i}][start_time]"]`).val() === '') {
                            validate.status = false;
                            validate.message = "@lang('Start Time is required')";
                            $(`input[name="schedules[${i}][start_time]"]`).focus();
                            break;
                        } else if ($(`input[name="schedules[${i}][end_time]"]`).val() === '') {
                            validate.status = false;
                            validate.message = "@lang('End Time is required')";
                            $(`input[name="schedules[${i}][end_time]"]`).focus();
                            break;
                        }
                    }
                    break;
                case 'register':
                    if ($('input[name="username"]').val().trim() === '') {
                        validate.status = false;
                        validate.message = "@lang('Username is required')";
                        $('input[name="username"]').focus();
                    } else if ($('input[name="email"]').val().trim() === '') {
                        validate.status = false;
                        validate.message = "@lang('Email is required')";
                        $('input[name="email"]').focus();
                    } else if ($('input[name="password"]').val().trim() === '') {
                        validate.status = false;
                        validate.message = "@lang('Password is required')";
                        $('input[name="password"]').focus();
                    } else if ($('input[name="password_confirmation"]').val().trim() === '') {
                        validate.status = false;
                        validate.message = "@lang('Confirm Password is required')";
                        $('input[name="password_confirmation"]').focus();
                    }
                    break;
                default:
                    break;
            }

            return validate;
        }

        $('.next-btn').click(function() {
            var form = $(this).data('form');
            const validate = validateForm(form);

            if (validate.status) {
                var currentStep = $(this).closest('.onboarding-step');
                var target = $(this).data('target');
                currentStep.animate({ opacity: 0 }, 200, function() {
                    currentStep.css('display', 'none');
                    $(target).css('opacity', 0).css('display', 'block').animate({ opacity: 1 }, 200);
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: validate.message
                });
            }
        });

        $('.prev-btn').click(function() {
            var currentStep = $(this).closest('.onboarding-step');
            var target = $(this).data('target');
            currentStep.animate({ opacity: 0 }, 200, function() {
                currentStep.css('display', 'none');
                $(target).css('opacity', 0).css('display', 'block').animate({ opacity: 1 }, 200);
            });
        });

        $('#finish-btn').click(function() {
            Toast.fire({
                icon: 'success',
                title: '@lang("Onboarding complete!")'
            });
        });
    });
</script>
</body>
</html>
