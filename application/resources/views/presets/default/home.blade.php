@php
    $homeOneContent = getContent('homeone.content',true);
    $homeTwoContent = getContent('hometwo.content',true);
    $homeThreeContent   = getContent('homethree.content',true);
    $general = gs();
    $page = App\Models\Page::where('slug', 'about')->first();

@endphp
@extends($activeTemplate.'.layouts.frontend')
@section('content')

{{-- Home Section One Start --}}

@if($general->homesection == 1)
<section class="banner-section bg-img">
    <div class="container position-relative">
        <div class="row justify-content-center mb-3">
            <div class="col-lg-12 col-md-12">
                <div class="banner-left__content text-center">
                    <h2>{{__(@$homeOneContent->data_values->heading)}}</h2>
                    {{-- <p>
                        {{__(@$homeOneContent->data_values->subheading)}}
                    </p> --}}
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                    <div class="row">
                        <div class="col-lg-9 col-md-12 mb-2">
                            <div class="form-group input-group input-search">
                                <input type="text" class="form--control" id="search-field" name="city" placeholder="@lang('Enter your location')">
                                <div class="fas fa-map-marker-alte" data-target="city"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 mb-2 d-none d-lg-block btn-city-search">
                            <button class="btn btn--base w-100 h-100">
                                @lang('Look For')
                            </button>
                        </div>
                    </div>
            </div>
        </div>
        @include($activeTemplate.'components.activities')
        <div class="row justify-content-center mt-5">
            <div class="col-lg-12 col-md-12 mb-2 d-block d-md-block d-lg-none">
                <button class="btn btn--base w-100 h-100 py-3 btn-city-search">
                    @lang('Look For')
                </button>
            </div>
        </div>
    </div>
</section>
@endif
{{-- Home Section One End --}}


{{-- Home Section Three Start --}}
@if($general->homesection == 2)
<section class="banner-section banner-three bg-img">
    <div class="container position-relative">
        <img  class="banner-3-left-top animate-x-axis" class="banner-shape-" src="{{getImage(getFilePath('homethree').'/'.@$homeThreeContent->data_values->left_top_image)}}" alt="@lang('Shape')">
        <img class="banner-3-right-top animate-y-axis" src="{{getImage(getFilePath('homethree').'/'.@$homeThreeContent->data_values->right_top_image)}}" alt="@lang('Shape')">
        <img class="banner-3-left-bottom animate-y-axis" src="{{getImage(getFilePath('homethree').'/'.@$homeThreeContent->data_values->left_bottom_image)}}" alt="@lang('Shape')">
        <img class="banner-3-right-bottom animate-x-axis" src="{{getImage(getFilePath('homethree').'/'.@$homeThreeContent->data_values->right_bottom_image)}}" alt="@lang('Shape')">
        <div class="banner-effect"></div>
        <div class="row gy-4 justify-content-center">
            <div class="col-lg-7 col-xl-6 col-md-12">
                <div class="banner-left__content text-center">
                    <h2>{{__(@$homeThreeContent->data_values->heading)}}</h2>
                    <p>
                        {{__(@$homeThreeContent->data_values->subheading)}}
                    </p>

                    <div class="button-wrap">
                        <a href="{{route('product')}}" class="btn btn--base two me-3 mb-3">
                            @lang('Get Started Now')
                        </a>
                        <a href="{{route('pages',$page->slug)}}" class="btn btn--base me-3 mb-3">
                            @lang('About Us')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
{{-- Home Section Three End --}}

@if(optional($sections)->secs)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection

@push('script-lib')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places" async defer></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $(document).ready(function () {
                $('[name=city]').keypress(function(event) {
                    if (event.which == 13) { // 13 is the Enter key code
                        var city = $('[name=city]').val();
                        window.location.href = "{{ route('product') }}" + "/" + city;
                    }
                });
                $('.btn-city-search').click(function() {
                    var city = $('[name=city]').val();
                    window.location.href = "{{ route('product') }}" + "/" + city;
                });

                google.maps.event.addDomListener(window, 'load', initializeSearchField);

                function initializeSearchField() {
                    const input = document.getElementById('search-field');
                    if (input instanceof HTMLInputElement) {
                        var options = {
                            types: ['(cities)'],
                            componentRestrictions: {country: "es"}
                        };
                        var autocomplete = new google.maps.places.Autocomplete(input, options);
                        autocomplete.addListener('place_changed', function () {
                            var place = autocomplete.getPlace();
                            var location = place.name.toLowerCase();

                            $("#search-field").val(location);
                        });
                    }
                }
            });
        })(jQuery);
    </script>
@endpush
