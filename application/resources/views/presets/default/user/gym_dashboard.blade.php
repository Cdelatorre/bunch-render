@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row product-details-area gap-2">
        <div class="col-xl-12 col-lg-12">
            <div class="apex-container-wrap">
                <div class="row gy-4 py-60">
                    <div class="col-lg-6 mt-0">
                        <ul class="nav nav-pills gym-range-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active gym-stats-tab" id="week-tab-stats" data-type="week" data-bs-toggle="tab" data-bs-target="#tab-week-stats" type="button" role="tab" aria-controls="tab-week-stats" aria-selected="true">@lang('Week')</button>
                            </li>
                            <li class="nav-item divider" role="presentation"></li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link gym-stats-tab" id="month-tab-stats" data-bs-toggle="tab" data-type="month" data-bs-target="#tab-month-stats" type="button" role="tab" aria-controls="tab-month-stats" aria-selected="false">@lang('Month')</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link gym-stats-tab" id="year-tab-stats" data-bs-toggle="tab" data-type="year" data-bs-target="#tab-year-stats" type="button" role="tab" aria-controls="tab-year-stats" aria-selected="false">@lang('Year')</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link gym-stats-tab" id="all-tab-stats" data-bs-toggle="tab" data-type="all" data-bs-target="#tab-all-stats" type="button" role="tab" aria-controls="tab-all-stats" aria-selected="false">@lang('All')</button>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 mt-2">
                        <h4 class="site-title mt-1">@lang('Stats')</h4>
                    </div>
                    <div class="col-lg-6 mt-2">
                        <div class="apexcharts-wrap mb-3">
                            <div id="stats-chart"></div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-2">
                        <div class="row gy-4 justify-content-center dashboard-item-wrap">
                            <div class="col-6">
                                <div class="action-category-item" data-highlight="@lang('Views')">
                                    <div class="action-category-item__icon">
                                        <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62"
                                            height="56" viewBox="0 0 62 56" fill="none">
                                            <path
                                                d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                            </path>
                                        </svg>
                                        <i class="las la-eye"></i>
                                    </div>
                                    <div class="action-category-item__text">
                                        <h4 class="site-title" id="totalStatsViews">{{ @$stats['total']['views'] }}</h4>
                                        <p>@lang('Views')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="action-category-item" data-highlight="@lang('Reviews')">
                                    <div class="action-category-item__icon">
                                        <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                            viewBox="0 0 62 56" fill="none">
                                            <path
                                                d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                            </path>
                                        </svg>
                                        <i class="las la-star"></i>
                                    </div>
                                    <div class="action-category-item__text">
                                        <h4 class="site-title" id="totalStatsReviews">{{ @$stats['total']['reviews'] }}</h4>
                                        <p>@lang('Reviews')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="action-category-item" data-highlight="@lang('Requests')">
                                    <div class="action-category-item__icon">
                                        <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                            viewBox="0 0 62 56" fill="none">
                                            <path
                                                d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                            </path>
                                        </svg>
                                        <i class="las la-universal-access"></i>
                                    </div>
                                    <div class="action-category-item__text">
                                        <h4 class="site-title" id="totalStatsRequests">{{ @$stats['total']['requests'] }}</h4>
                                        <p>@lang('Requests')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="action-category-item" data-highlight="@lang('Favorites')">
                                    <div class="action-category-item__icon">
                                        <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                            viewBox="0 0 62 56" fill="none">
                                            <path
                                                d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                            </path>
                                        </svg>
                                        <i class="las la-heart"></i>
                                    </div>
                                    <div class="action-category-item__text">
                                        <h4 class="site-title" id="totalStatsFavorites">{{ @$stats['total']['favorites'] }}</h4>
                                        <p>@lang('Favorites')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <h4 class="site-title">@lang('Visits to your center')</h4>
                    </div>
                    <div class="col-12 mt-2">
                        <ul class="nav nav-pills gym-range-tabs" id="myVisitsTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active gym-visits-tab" id="week-tab-visits" data-bs-toggle="tab" data-type="week" data-bs-target="#tab-week-visits" type="button" role="tab" aria-controls="tab-week-visits" aria-selected="true">@lang('Week')</button>
                            </li>
                            <li class="nav-item divider" role="presentation"></li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link gym-visits-tab" id="month-tab-visits" data-bs-toggle="tab" data-type="month" data-bs-target="#tab-month-visits" type="button" role="tab" aria-controls="tab-month-visits" aria-selected="false">@lang('Month')</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link gym-visits-tab" id="year-tab-visits" data-bs-toggle="tab" data-type="year" data-bs-target="#tab-year-visits" type="button" role="tab" aria-controls="tab-year-visits" aria-selected="false">@lang('Year')</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link gym-visits-tab" id="all-tab-visits" data-bs-toggle="tab" data-type="all" data-bs-target="#tab-all-visits" type="button" role="tab" aria-controls="tab-all-visits" aria-selected="false">@lang('All')</button>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 mt-2">
                        <div class="apexcharts-wrap mb-3">
                            <div id="visits-chart"></div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-2">
                        <div class="alert alert-dismissible fade show alert_pink w-75 mb-4" role="alert">
                            <i class="far fa-calendar-check"></i>
                            <p><strong>@lang('Upcoming visits')</strong></p>
                            <p>
                                @if ($visits['series']['visits'][0] > 0)
                                    {{ __('You have :count visit scheduled for today.', ['count' => $visits['series']['visits'][0]]) }}
                                @else
                                    @lang('You have not scheduled visits for today.')
                                @endif
                            </p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="visits-list">
                            <div class="mb-3">
                                <h4 class="site-title">@lang('Upcoming visits')</h4>
                            </div>
                            @foreach ($upcomingVisits as $visit)
                            <div class="row justify-content-between mb-2">
                                <div class="col-4">
                                    <p>{{ $visit->user->lastname }} {{ $visit->user->firstname }}</p>
                                </div>
                                <div class="col-4 d-flex justify-content-end">
                                    @php echo @$visit->statusBadge; @endphp
                                </div>
                            </div>
                            @endforeach
                            <div class="row justify-content-center">
                                <div class="col-3">
                                    <a href="{{route('user.request.history')}}" class="btn btn--base border-none mt-1 btn--sm w-100">@lang('See All')</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <h4 class="site-title">@lang('Trends')</h4>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="row trends-section">
                            <div class="col-lg-8 mb-2">
                                <div class="card border border-secondary py-4 px-3 rounded-3">
                                    <span class="most-activity">{{ @$mostSearchedActivity->name }}</span>
                                    <h5 class="card-title text-black mt-3">@lang('is the most searched for in your area this month')🚀</h5>
                                    <div class="mt-2 most-activity-image" style="background-image: url({{ getImage(getFilePath('activity').'/'.@$mostSearchedActivity->banner) }});" alt="image"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-2">
                                <div class="card bg--dark--base border border-secondary py-4 px-3 rounded-3 h-100">
                                    <select class="form-select mb-3 trends-range-select">
                                        <option value="week" selected>@lang('Week')</option>
                                        <option value="month">@lang('Month')</option>
                                        <option value="year">@lang('Year')</option>
                                        <option value="all">@lang('All')</option>
                                    </select>
                                    <div class="trend-activities">
                                        @foreach ($trends as $trend)
                                        <div class="row justify-content-between mb-3 trend-activity">
                                            <div class="col-9 d-flex align-items-center">
                                                <p class="trend-title">{{ $trend['title'] }}</p>
                                            </div>
                                            <div class="col-3 d-flex justify-content-end">
                                                <span class="trend-count">{{ $trend['count'] }}</span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <h4 class="site-title">@lang('Reviews')</h4>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="card bg--dark--base border border-secondary p-5 rounded-3 review-section align-items-center">
                            <div class="global">
                                <span class="global-value">0.00</span>
                                <div class="rating-icons">
                                    <span class="one"><i class="las la-star"></i><i class="las la-star"></i><i class="las la-star"></i><i class="las la-star"></i><i class="las la-star"></i></span>
                                    <span class="two"><i class="las la-star"></i><i class="las la-star"></i><i class="las la-star"></i><i class="las la-star"></i><i class="las la-star"></i></span>
                                </div>
                                <span class="total-reviews">0 @lang('Reviews')</span>
                            </div>
                            <div class="review-chart d-none">
                                <div class="rate-box">
                                    <div class="rate-text">
                                        <span class="value">5</span>
                                        <span class="count">(0)</span>
                                        <i class="las la-star"></i>
                                    </div>
                                    <div class="progress--bar"><span class="progress" style="width: 100%"></span></div>
                                </div>
                                <div class="rate-box">
                                    <div class="rate-text">
                                        <span class="value">4</span>
                                        <span class="count">(0)</span>
                                        <i class="las la-star"></i>
                                    </div>
                                    <div class="progress--bar"><span class="progress" style="width: 80%"></span></div>
                                </div>
                                <div class="rate-box">
                                    <div class="rate-text">
                                        <span class="value">3</span>
                                        <span class="count">(0)</span>
                                        <i class="las la-star"></i>
                                    </div>
                                    <div class="progress--bar"><span class="progress" style="width: 60%"></span></div>
                                </div>
                                <div class="rate-box">
                                    <div class="rate-text">
                                        <span class="value">2</span>
                                        <span class="count">(0)</span>
                                        <i class="las la-star"></i>
                                    </div>
                                    <div class="progress--bar"><span class="progress" style="width: 40%"></span></div>
                                </div>
                                <div class="rate-box">
                                    <div class="rate-text">
                                        <span class="value">1</span>
                                        <span class="count">(0)</span>
                                        <i class="las la-star"></i>
                                    </div>
                                    <div class="progress--bar"><span class="progress" style="width: 20%"></span></div>
                                </div>
                            </div>
                            <a href="{{route('user.reviews.history')}}" class="btn btn--base border-none mt-4 btn--sm">@lang('See Reviews')</a>
                            @if ($googleReviews['url'])
                            <a target="__blank" href="{{ $googleReviews['url'] }}" class="btn btn--base border-none mt-4 btn--sm">@lang('See Google Reviews')</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')

<script src="{{asset('assets/admin/js/apexcharts.min.js')}}"></script>

<script>
    // {{-- Charts --}}
    (function () {
        "use strict";
        // [ stats-chart ] start
        var statsOptions = {
            series: [{
                name: '@lang("Views")',
                type: 'bar',
                data: @json($stats['series']['views']),
            }, {
                name: '@lang("Reviews")',
                type: 'area',
                data: @json($stats['series']['reviews']),
            }, {
                name: '@lang("Requests")',
                type: 'line',
                data: @json($stats['series']['requests']),
            }, {
                name: '@lang("Favorites")',
                type: 'bar',
                data: @json($stats['series']['favorites']),
            }],
            colors: ['#fd4d6c', '#fd4d6c', '#fd4d6c', '#fd4d6c'],
            chart: {
                id: 'stats',
                height: 300,
                type: 'line',
                stacked: false,
                background: '#151517',
                animations: {
                    enabled: true,
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 350
                    },
                    dynamicAnimation: {
                        enabled: true,
                        speed: 350
                    }
                },
                toolbar: {
                    show: true,
                    tools: {
                        reset: false,
                        download: true,
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                    },
                },
            },
            theme: {
                mode: 'dark',
            },
            stroke: {
                width: [0, 2, 5],
                curve: 'smooth'
            },
            plotOptions: {
                bar: {
                    columnWidth: '50%'
                }
            },
            fill: {
                opacity: [0.75, 0.25, 1, 0.5],
                gradient: {
                    inverseColors: false,
                    shade: 'light',
                    type: "vertical",
                    opacityFrom: 0.85,
                    opacityTo: 0.55,
                    stops: [0, 100, 100, 100]
                }
            },
            labels: @json($stats['labels']),
            markers: {
                size: 0
            },
            xaxis: {
                type: 'datetime',
                labels: {
                    show: true,
                    datetimeUTC: true,
                    datetimeFormatter: {
                        year: 'yyyy',
                        month: "MMM yyyy",
                        day: 'dd MMM',
                        hour: 'HH:mm',
                        minute: 'HH:mm:ss',
                        second: 'HH:mm:ss',
                    },
                },
            },
            yaxis: {
                type: 'category',
                title: {
                    text: 'Week',
                },
                floating: false,
                decimalsInFloat: undefined,
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function (y) {
                        if (typeof y !== "undefined") {
                            return y.toFixed(0);
                        }
                        return y;

                    }
                }
            },
            legend: {
                labels: {
                    useSeriesColors: true
                },
                markers: {
                    customHTML: [
                        function () {
                            return ''
                        },
                        function () {
                            return ''
                        }
                    ]
                }
            }
        };

        var statsChart = new ApexCharts(
            document.querySelector("#stats-chart"),
            statsOptions
        );
        statsChart.render();

        // [ visits-chart ] start
        var visitsOptions = {
            series: [{
                name: '@lang("Visits")',
                type: 'area',
                data: @json($visits['series']['visits'])
            }],
            colors: ['#fd4d6c'],
            chart: {
                height: 300,
                type: 'line',
                id: 'visits',
                stacked: false,
                background: '#151517',
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        reset: false,
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                    },
                },
            },
            theme: {
                mode: 'dark',
            },
            stroke: {
                width: [0, 2, 5],
                curve: 'smooth'
            },
            plotOptions: {
                bar: {
                    columnWidth: '50%'
                }
            },
            fill: {
                opacity: [0.5],
                gradient: {
                    inverseColors: false,
                    shade: 'light',
                    type: "vertical",
                    opacityFrom: 0.85,
                    opacityTo: 0.55,
                    stops: [0, 100, 100, 100]
                }
            },
            labels: @json($visits['labels']),
            markers: {
                size: 0
            },
            xaxis: {
                type: 'datetime'
            },
            yaxis: {
                type: 'category',
                title: {
                    text: 'Week',
                },
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function (y) {
                        if (typeof y !== "undefined") {
                        return y.toFixed(0);
                        }
                        return y;

                    }
                }
            },
            legend: {
                labels: {
                    useSeriesColors: true
                },
                markers: {
                    customHTML: [
                        function () {
                            return ''
                        },
                        function () {
                            return ''
                        }
                    ]
                }
            }
        };

        var visitsChart = new ApexCharts(
            document.querySelector("#visits-chart"),
            visitsOptions
        );
        visitsChart.render();

        const allHighlightLists = ['@lang("Views")','@lang("Reviews")','@lang("Requests")','@lang("Favorites")'];

        $(document).on('mouseover', '.action-category-item', function () {
            const highlight = $(this).data('highlight');
            allHighlightLists.forEach(item => {
                if (item !== highlight) {
                    statsChart.hideSeries(item);
                }
            });
        });

        $(document).on('mouseout', '.action-category-item', function () {
            allHighlightLists.forEach(item => {
                statsChart.showSeries(item);
            });
        });

        $(document).on('click', '.gym-stats-tab', function () {
            const type = $(this).data('type');
            const label = $(this).text().trim();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "get",
                url: "{{ route('user.fetch.stats') }}",
                data: {
                    type: type,
                    product_id: '{{ $product->id }}'
                },
                success: function (response) {
                    if ('error' in response) {
                        return;
                    }

                    statsChart.updateOptions({
                        series: [{
                            name: '@lang("Views")',
                            type: 'bar',
                            data: response.series.views
                        }, {
                            name: '@lang("Reviews")',
                            type: 'area',
                            data: response.series.reviews
                        }, {
                            name: '@lang("Requests")',
                            type: 'line',
                            data: response.series.requests
                        }, {
                            name: '@lang("Favorites")',
                            type: 'bar',
                            data: response.series.favorites
                        }],
                        labels: response.labels,
                        xaxis: {
                            type: type === 'all' ? 'category' : 'datetime',
                        },
                        yaxis: {
                            title: {
                                text: label,
                            }
                        },
                    });

                    $('#totalStatsViews').text(response.total.views);
                    $('#totalStatsReviews').text(response.total.reviews);
                    $('#totalStatsRequests').text(response.total.requests);
                    $('#totalStatsFavorites').text(response.total.favorites);
                }
            });
        });

        $(document).on('click', '.gym-visits-tab', function () {
            const type = $(this).data('type');
            const label = $(this).text().trim();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "get",
                url: "{{ route('user.fetch.gym.visits') }}",
                data: {
                    type: type,
                    product_id: '{{ $product->id }}'
                },
                success: function (response) {
                    if ('error' in response) {
                        return;
                    }

                    visitsChart.updateOptions({
                        series: [{
                            name: '@lang("Visits")',
                            type: 'area',
                            data: response.series.visits
                        }],
                        labels: response.labels,
                        xaxis: {
                            type: type === 'all' ? 'category' : 'datetime',
                        },
                        yaxis: {
                            title: {
                                text: label,
                            }
                        },
                    });
                }
            });
        });

        $('.trends-range-select').on('change', function () {
            const type = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "get",
                url: "{{ route('user.fetch.trends') }}",
                data: {
                    type: type,
                },
                success: function (response) {
                    if ('error' in response) {
                        return;
                    }

                    var content = '';
                    for (let i = 0; i < response.length; i++) {
                        content += `
                        <div class="row justify-content-between mb-3 trend-activity">
                            <div class="col-9 d-flex align-items-center">
                                <p class="trend-title">${response[i].title}</p>
                            </div>
                            <div class="col-3 d-flex justify-content-end">
                                <span class="trend-count">${response[i].count}</span>
                            </div>
                        </div>
                        `;
                    }
                    $('.trend-activities').html(content);
                }
            });
        });
    }) ();

    // {{-- Reviews --}}
    (function () {
        "use strict";

        let rateBox = Array.from(document.querySelectorAll(".rate-box"));
        let globalValue = document.querySelector(".global-value");
        let two = document.querySelector(".two");
        let totalReviews = document.querySelector(".total-reviews");
        let reviews = @json($reviews);
        let googleReviews =  @json($googleReviews);

        updateValues();

        function updateValues() {
            rateBox.forEach((box) => {
                let valueBox = rateBox[rateBox.indexOf(box)].querySelector(".value");
                let countBox = rateBox[rateBox.indexOf(box)].querySelector(".count");
                let progress = rateBox[rateBox.indexOf(box)].querySelector(".progress");
                countBox.innerHTML = `(${nFormat(reviews[valueBox.innerHTML] || 0)})`;
            });

            totalReviews.innerHTML = `${getTotal(reviews) + Number(googleReviews.user_ratings_total)} @lang('Reviews')`;
            finalRating();
        }

        function getTotal(reviews) {
            return Object.values(reviews).length > 0 ? Object.values(reviews).reduce((a, b) => a + b) : 0;
        }

        document.querySelectorAll(".value").forEach((element) => {
            element.addEventListener("click", () => {
                let target = element.innerHTML;
                reviews[target] += 1;
                updateValues();
            });
        });

        function finalRating() {
            let final = Object.values(reviews).length > 0 ? Object.entries(reviews)
                .map((val) => val[0] * val[1])
                .reduce((a, b) => a + b) : 0;

            let fReviewsCount = Number(getTotal(reviews));
            let gReviewsCount = Number(googleReviews.user_ratings_total);
            let ratingValue = nFormat(parseFloat(final / fReviewsCount).toFixed(1));
            let totalReviews = fReviewsCount + gReviewsCount;

            let averageRatingValue = parseFloat(ratingValue) * fReviewsCount + parseFloat(googleReviews.rating) * gReviewsCount;
            averageRatingValue = averageRatingValue / (fReviewsCount + gReviewsCount);

            globalValue.innerHTML = averageRatingValue.toFixed(1);
            two.style.background = `linear-gradient(to right, #F3B842 ${
                (averageRatingValue / 5) * 100
            }%, transparent 0%)`;
        }

        function nFormat(number) {
            if (number >= 1000 && number < 1000000) {
                return `${number.toString().slice(0, -3)}k`;
            } else if (number >= 1000000 && number < 1000000000) {
                return `${number.toString().slice(0, -6)}m`;
            } else if (number >= 1000000000) {
                return `${number.toString().slice(0, -9)}md`;
            } else if (number === "NaN") {
                return `0.0`;
            } else {
                return number;
            }
        }
    }) ();
</script>


@endpush
