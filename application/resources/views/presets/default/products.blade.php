@extends($activeTemplate.'layouts.frontend')
@section('content')

<div class="products-sidebar-overlay"></div>
<div class="products-filter-wrapper product-details-area">
    <div class="top-close d-flex align-items-center justify-content-between">
        <div class="header-wrapper-siedebar">
            <div class="logo-wrapper" id="filter-modal-header">
                @lang('Activity')
            </div>
        </div>
        <i class="las la-times close-filter-hide-show"></i>
    </div>
    <div class="products-filter-body">

    </div>
    <button class="products-filter-footer"></button>
</div>

<section class="product-details-area py-60">
    <div class="container">
        <div class="row gy-5 justify-content-center mb-5">
            <div class="col-12 activity-filter">
                <div class="mobile-category">
                    <div class="action-category-wrapper">
                        <button data-id="reset" class="action-category-item btn-activity">
                            <div class="action-category-item__text">
                                <p>@lang('All')</p>
                            </div>
                        </button>
                        <div class="action-category-divide-item"></div>
                        @forelse($categories as $category)
                        <button data-id="{{ $category->id }}" id="btn_categories_{{$category->id}}" class="action-category-item btn-activity">
                            <div class="action-category-item__icon">
                                @php echo $category->icon; @endphp
                            </div>
                            <div class="action-category-item__text">
                                <p>{{__(@$category->name)}}</p>
                            </div>
                        </button>
                        <input class="form-check-input filtered_category d-none" name="categories_{{$category->id}}" type="checkbox" value="{{$category->id}}" id="categories_{{$category->id}}">
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-3 products-filter">
                <div class="blog-sidebar-wrapper product-sidebar">
                    <div class="blog-sidebar">

                        <div class="side-bar-item">
                            <h5 class="blog-sidebar__title"> @lang('Filters By:') </h5>
                            <div class="blog-sidebar__filter-wrap mb-2">
                                <div class="col-sm-12">
                                    <label class="form--label">@lang('Location')</label>
                                    <div class="form-group input-group">
                                        <input type="text" class="form--control" id="search" name="search" value="{{ $location }}" placeholder="@lang('Location')">
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2 filter-buttons">
                                    <button data-id="activity-filter" data-title="{{ __('Activities') }}" class="btn btn--base products-filter-show-hide">@lang('Activities')</button>
                                    <button data-id="products-filter" data-title="{{ __('Filters') }}" class="btn btn--base products-filter-show-hide">@lang('Filters')</button>
                                    <button data-id="products-map" data-title="{{ __('Map') }}" class="btn btn--base products-filter-show-hide">@lang('Map')</button>
                                </div>
                            </div>
                        </div>

                        <div class="side-bar-item">
                            <h5 class="blog-sidebar__title"> @lang('Sort By') </h5>
                            <div class="blog-sidebar__filter-wrap">
                                <div class="form-check rounded mb-1">
                                    <input class="form-check-input" type="radio" name="sorted_by_date" id="sorted_by_date" value="date">
                                    <div class="form-check-label">
                                        <label for="sorted_by_date">@lang('Date')</label>
                                    </div>
                                </div>
                                <div class="form-check rounded mb-1">
                                    <input class="form-check-input" type="radio" name="sorted_by_price" id="sorted_by_price" value="price">
                                    <div class="form-check-label">
                                        <label for="sorted_by_price">@lang('Price')</label>
                                    </div>
                                </div>
                                <div class="form-check rounded mb-1">
                                    <input class="form-check-input" type="radio" name="sorted_by_name" id="sorted_by_name" value="name">
                                    <div class="form-check-label">
                                        <label for="sorted_by_name">@lang('Name')</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="side-bar-item">
                            <h5 class="blog-sidebar__title"> @lang('Price By') </h5>
                            <h5 class="blog-sidebar__sub-title">@lang('Price')</h5>
                            <div class="advance_search_input">
                                <div class="range-slider">
                                    <div id="price-range" data-min="0" data-max="{{$productMaxPrice}}" data-unit="$"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <input type="hidden" name="min" id="min" value="{{ request()->query('min', 0) }}">
                            <input type="hidden" name="max" id="max" value="{{ request()->query('max', $productMaxPrice) }}">
                        </div>

                        @foreach ($rootServices as $services)
                        <div class="side-bar-item">
                            <h5 class="blog-sidebar__title"> {{ $services->name }} </h5>
                            <div class="blog-sidebar__category-wrap">
                                @forelse($services->children as $service)
                                <div class="item">
                                    <div class="form-check rounded mb-1">
                                        <input class="form-check-input filtered_service" name="services_{{$service->id}}" type="checkbox" value="{{$service->id}}" id="services_{{$service->id}}">
                                        <div class="form-check-label">
                                            <label for="services_{{$service->id}}">{{__($service->name)}}</label>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- ============================= Blog Details Sidebar End ======================== -->
            </div>
            <div class="col-lg-9 filtered-product position-relative"></div>
        </div>
    </div>
</section>

<!-- ==================== Product End Here ==================== -->

@endsection
@push('style')
    <style>
    .filtered-product-map {
        display: none;
    }

    @media screen and (max-width: 991px) {
        .container {
            width: 100%;
            max-width: 100%;
        }

        #search {
            border: 2px solid hsl(var(--base));
        }

        .header-main-area {
            z-index: 150;
        }

        .breadcumb, .filter-items {
            display: none;
        }

        .product-details-area {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        .products-filter {
            margin-top: 75px;
            z-index: 100;
            min-height: 135px;
        }

        .filtered-product {
            z-index: 50;
            margin-top: -125px;
            padding: 0;
        }

        .filtered-product .filtered-product-map {
            padding: 0;
            margin: 0;
        }

        .filtered-product .filtered-product-list {
            padding: 10px;
            margin: 150px 0 20px;
            display: flex;
            gap: 10px;
        }

        .filtered-product .col-lg-12 {
            padding: 0;
            margin: 0;
        }

        #map {
            height: calc(100vh - 76px) !important;
            border-radius: 0 !important;
            border: none !important;
            margin-top: 15px;
        }
    }
    </style>
@endpush
@push('script-lib')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places" async defer></script>
    <script src="{{ asset('assets/common/js/markerclusterer/markerclusterer.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";

        $(document).ready(function () {
            let filterId = '';
            let viewType = 'list';
            let timeout = null;

            let map = null;
            let markers = [];
            let infoWindowActions = [];

            async function initMap(products = []) {
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 2,
                    disableDefaultUI: true,
                    zoomControl: false,
                    mapTypeControl: false,
                    scaleControl: false,
                    streetViewControl: false,
                    rotateControl: false,
                    fullscreenControl: false
                });

                if (markers.length > 0) {
                    markers.forEach(marker => marker.setMap(null));
                }

                // Array of products with their details
                var _markers = [];
                var _markers_bounds = new google.maps.LatLngBounds();
                var infowindow = new google.maps.InfoWindow({
                    headerDisabled: true,
                    maxWidth: '358',
                    minWidth: '358'
                });

                // Loop through the products and add markers
                products.forEach(function(product) {
                    var _marker = new google.maps.Marker({
                        position: {lat: parseFloat(product.latitude), lng: parseFloat(product.longitude)},
                        map: map,
                        label: product.title,
                        clickable: true
                    });

                    _markers.push(_marker);
                    _markers_bounds.extend({ lat: Number(product.latitude), lng: Number(product.longitude) });

                    infoWindowActions[product.id] = function () {
                        google.maps.event.trigger(_marker, 'click');
                    };

                    // Add click event to open infowindow
                    google.maps.event.addListener(_marker, 'click', function() {
                        infowindow.setContent(`${product.content}`);
                        infowindow.open(map, _marker);
                    });
                });

                // Add click event to close infowindow when clicking on the map
                google.maps.event.addListener(map, 'click', function() {
                    infowindow.close();
                });

                markers = _markers;

                // Add a marker clusterer to manage the markers
                // var markerCluster = new MarkerClusterer(map, _markers, {
                //     imagePath: '{{ asset("assets/common/js/markerclusterer") }}/m',
                // });

                var center = _markers_bounds.getCenter();
                map.fitBounds(_markers_bounds);
                map.setCenter(center);
            }

            $(document).on('click', '.btn-view-map', async function () {
                viewType = 'map';

                var categories = getSelectedCategories();
                var services = getSelectedServices();
                var sortBy = getSelectedSortBy();
                var min = $('input[name="min"]').val();
                var max = $('input[name="max"]').val();
                var search = $("#search").val();

                await fetchData(min, max, categories, services, sortBy, search);
                $('.filtered-product-list').hide();
                $('.filtered-product-map').show();

                $('[data-id=products-map]').text('@lang("Lists")');
                const productId = $(this).data('product_id');
                infoWindowActions[productId]();
                $('.footer-area').hide();
            });

            $(document).on('click', '.products-filter-show-hide', function () {
                const elem = $(this).data('id');

                if (elem === 'products-map') {
                    if (viewType === 'list') {
                        viewType = 'map';
                        $(this).text('@lang("Lists")');
                        $('.filtered-product-map').show();
                        $('.filtered-product-list').hide();
                        $('.footer-area').hide();
                    } else {
                        viewType = 'list';
                        $(this).text('@lang("Map")');
                        $('.filtered-product-map').hide();
                        $('.filtered-product-list').show();
                        $('.footer-area').show();
                    }
                    handleFilterChange();
                    return;
                }

                if (elem === 'products-filter') {
                    document.documentElement.classList.toggle('scrollDisabled', true);
                }

                const title = $(this).data('title');
                $('#filter-modal-header').html(title);

                const $elementToClone = $(`.${elem}`).children();
                const $cloneContainer = $('.products-filter-body');
                $cloneContainer.empty();
                $cloneContainer.append($elementToClone);

                filterId = elem;

                $('.products-filter-wrapper').addClass('show');
                $(".products-sidebar-overlay").addClass('show');
            });

            $(document).on('click', '.products-sidebar-overlay, .close-filter-hide-show, .products-filter-footer', function () {
                if($(document).width() < 991) {
                    const elem = filterId;

                    const $elementToClone = $('.products-filter-body').children();
                    const $cloneContainer = $(`.${elem}`);
                    $cloneContainer.empty();
                    $cloneContainer.append($elementToClone);

                    $('.products-filter-wrapper').removeClass('show');
                    $(".products-sidebar-overlay").removeClass('show');

                    document.documentElement.classList.toggle('scrollDisabled', false);
                }
            });

            // Initialize slider
            $("#price-range").each(function () {
                var dataMin = $(this).attr('data-min');
                var dataMax = $(this).attr('data-max');
                var dataUnit = $(this).attr('data-unit');
                var minPrice = $("input[name='min']").val();
                var maxPrice = $("input[name='max']").val();

                $(this).append("<input type='text' class='first-slider-value' disabled/><input type='text' class='second-slider-value' disabled/>");

                $(this).slider({
                    range: true,
                    min: Number(dataMin),
                    max: Number(dataMax),
                    values: [Number(minPrice), Number(maxPrice)],
                    slide: function (event, ui) {
                        $(this).children(".first-slider-value").val(dataUnit + ui.values[0].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                        $(this).children(".second-slider-value").val(dataUnit + ui.values[1].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));

                        $("input[name='min']").val(ui.values[0]);
                        $("input[name='max']").val(ui.values[1]);
                    },
                    change: function () {
                        handleFilterChange();
                    }
                });

                $(this).children(".first-slider-value").val(dataUnit + minPrice.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                $(this).children(".second-slider-value").val(dataUnit + maxPrice.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
            });

            // Initialize filters and search
            initializeFilters();
            google.maps.event.addDomListener(window, 'load', initializeSearchField);

            function initializeSearchField() {
                const input = document.getElementById('search');
                if (input instanceof HTMLInputElement) {
                    var options = {
                        types: ['(cities)'],
                        componentRestrictions: {country: "es"}
                    };
                    var autocomplete = new google.maps.places.Autocomplete(input, options);
                    autocomplete.addListener('place_changed', function () {
                        var place = autocomplete.getPlace();
                        if (place.name) {
                            var location = place.name.toLowerCase();
                            $("#search").val(location);
                            var locationGymString = ("{{__('Gyms in :location', ['location' => 'GymName']) }}").replace('GymName', place.name);
                            $('.pageTitle').html(locationGymString);

                            var title = ("{{ $general->siteName('GymTranslate') }}").replace('GymTranslate', locationGymString);
                            document.title = title;
                        } else {
                            $("#search").val('');
                        }
                        handleFilterChange();
                    });
                }
            }

            function loader(status = true) {
                if (status) {
                    $('.filtered-product-map').addClass('blurred');
                    $('.filtered-product-list').addClass('blurred');
                    $('.liquid-loader').removeClass('d-none');
                } else {
                    setTimeout(() => {
                        $('.filtered-product-map').removeClass('blurred');
                        $('.filtered-product-list').removeClass('blurred');
                        $('.liquid-loader').addClass('d-none');
                    }, 250);
                }
            }

            function handleFilterChange() {
                loader(true);

                if (timeout) {
                    clearTimeout(timeout);
                }

                timeout = setTimeout(() => {
                    var categories = getSelectedCategories();
                    var services = getSelectedServices();
                    var sortBy = getSelectedSortBy();
                    var min = $('input[name="min"]').val();
                    var max = $('input[name="max"]').val();
                    var search = $("#search").val();

                    saveState(min, max, categories, services, sortBy, search);
                    fetchData(min, max, categories, services, sortBy, search);

                    timeout = null;
                }, 350);
            }

            $("input[type='checkbox'][name^='services_']").on('click', handleFilterChange);
            $('input[type="radio"][name^="sorted_by_"]').on('change', function () {
                $('input[type="radio"][name^="sorted_by_"]').not(this).prop('checked', false);
                handleFilterChange();
            });

            $("#search").on('input', function() {
                const searchValue = $(this).val();
                if (searchValue === '') {
                    handleFilterChange();
                    $('.pageTitle').html('{{ __("Browse Gyms")}}');
                    var title = ("{{ $general->siteName('GymTranslate') }}").replace('GymTranslate', '{{ __("Browse Gyms")}}');
                    document.title = title;
                }
            });

            $(document).on('click', '.btn-activity', function () {
                const activityId = $(this).data('id');
                const isReset = activityId === 'reset';
                const $checkbox = $(`input[type="checkbox"][name^="categories_${activityId}"]`);

                if (isReset) {
                    $(".btn-activity").removeClass('selected');
                    $('input[type="checkbox"][name^="categories_"]').prop('checked', false);
                    handleFilterChange();
                    return;
                }

                $(this).toggleClass('selected');
                $checkbox.prop('checked', $(this).hasClass('selected'));
                handleFilterChange();
            });

            $(document).on('click', '.btn-remove-filter', function () {
                const actionId = $(this).data('id');
                const actionType = $(this).data('type');

                if (actionType === 'categories' ) {
                    $(`#btn_${actionId}`).removeClass('selected');
                }

                const $checkbox = $(`input[type="checkbox"][name="${actionId}"]`);
                $checkbox.prop('checked', false);
                handleFilterChange();
            });

            function getSelectedCategories() {
                var categories = [];
                $('input[type="checkbox"][name^="categories_"]:checked').each(function () {
                    categories.push(parseInt($(this).val()));
                });
                return categories;
            }

            function getSelectedServices() {
                var services = [];
                $('input[type="checkbox"][name^="services_"]:checked').each(function () {
                    services.push(parseInt($(this).val()));
                });
                return services;
            }

            function getSelectedSortBy() {
                return $('input[type="radio"][name^="sorted_by_"]:checked').val();
            }

            async function fetchData(min, max, categories, services, sortBy, search) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                try {
                    const response = await $.ajax({
                        type: "get",
                        url: "{{ route('fetch.product') }}",
                        data: {
                            "categories": categories,
                            "services": services,
                            "sortBy": sortBy,
                            "min": min,
                            "max": max,
                            "search": search
                        },
                        dataType: "json"
                    });

                    if (response.html) {
                        if (viewType === 'list') {
                            $('.filtered-product').html(response.html);
                        } else {
                            await initMap(response.products);
                        }

                        $('.search-boarder').html(response.search);
                        $('.products-filter-footer').html(`<p>@lang('Showing Results'): ${response.count}</p>`);
                        loader(false);
                    }

                    if (response.error) {
                        notify('error', response.error);
                    }

                    return response;
                } catch (error) {
                    console.error('Error fetching data:', error);
                    loader(false);
                }
            }

            function saveState(min, max, categories, services, sortBy, search) {
                var dataMin = $("#price-range").data('min');
                var dataMax = $("#price-range").data('max');

                const url = new URL(window.location.href);
                const params = { min, max, categories, services, sortBy };

                let location = $("#search").val();
                const basePath = "{{route('product')}}";

                if (location) {
                    location = location.replace(/ /g, '--').toLowerCase();
                    url.href = `${basePath}/${encodeURIComponent(location)}`;
                } else {
                    url.href = basePath;
                }

                Object.entries(params).forEach(([key, value]) => {
                    if ((key === 'min' && value == dataMin) || (key === 'max' && value == dataMax) || !value || (Array.isArray(value) && !value.length)) {
                        url.searchParams.delete(key);
                    } else {
                        url.searchParams.set(key, Array.isArray(value) ? value.join(',') : value);
                    }

                    if (key === 'sortBy' && value === 'date') {
                        url.searchParams.delete(key);
                    }
                });

                window.history.pushState({}, '', decodeURIComponent(url));
            }

            function parseUrlParam(param) {
                return param ? param.split(',').map(Number) : [];
            }

            function initializeFilters() {
                const urlParams = new URLSearchParams(window.location.search);

                const categories = parseUrlParam(urlParams.get('categories'));
                const search = urlParams.get('search') || $("#search").val();
                const sortBy = urlParams.get('sortBy') || $('input[type="radio"][name^="sorted_by_"]:checked').val() || 'date';
                const min = urlParams.get('min') || $('input[name="min"]').val();
                const max = urlParams.get('max') || $('input[name="max"]').val();
                const services = parseUrlParam(urlParams.get('services'));

                categories.forEach(category => {
                    $(`#btn_categories_${category}`).addClass('selected');
                    $(`input[type="checkbox"][name^="categories_"][value="${category}"]`).prop('checked', true);
                });
                $(`input[type="radio"][name^="sorted_by_"][value="${sortBy}"]`).prop('checked', true);
                $('input[name="min"]').val(min);
                $('input[name="max"]').val(max);
                $("#search").val(search);
                services.forEach(service => {
                    $(`input[type="checkbox"][name^="services_"][value="${service}"]`).prop('checked', true);
                });

                fetchData(min, max, categories, services, sortBy, search);
            }
        });
    </script>
@endpush
