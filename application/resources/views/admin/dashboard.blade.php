@extends('admin.layouts.app')

@section('panel')
@if(@json_decode($general->system_info)->message)
<div class="row">
    @foreach(json_decode($general->system_info)->message as $msg)
    <div class="col-md-12">
        <div class="alert border border--primary" role="alert">
            <div class="alert__icon bg--primary"><i class="far fa-bell"></i></div>
            <p class="alert__message">@php echo $msg; @endphp</p>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
    @endforeach
</div>
@endif
<div class="row gy-4">
    <div class="col-xl-12">
        <div class="row gy-4">
            <div class="col-sm-12">
                <div class="card p-3 rounded-3">
                    <div class="row g-0">
                        <div class="col-sm-4 col-6 col-xl-6 col-xxl-4">
                            <div class="dashboard-widget">
                                <div class="dashboard-widget__icon">
                                    <i class="dashboard-card-icon las la-users"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <a title="@lang('View all')" class="dashboard-widget-link"
                                        href="{{route('admin.users.all')}}"></a>
                                    <h5>{{$widget['total_users']}}</h5>
                                    <span>@lang('Total Users')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6 col-xl-6 col-xxl-4 ">
                            <div class="dashboard-widget">
                                <div class="dashboard-widget__icon">
                                    <i class="dashboard-card-icon las la-user-check"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <a title="@lang('View all')" class="dashboard-widget-link"
                                        href="{{route('admin.users.active')}}"></a>
                                    <h5>{{$widget['verified_users']}}</h5>
                                    <span>@lang('Active Users')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6 col-xl-6 col-xxl-4">
                            <div class="dashboard-widget">
                                <div class="dashboard-widget__icon">
                                    <i class="dashboard-card-icon las la-envelope"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <a title="@lang('View all')" class="dashboard-widget-link"
                                        href="{{route('admin.users.email.unverified')}}"></a>
                                    <h5>{{$widget['email_unverified_users']}}</h5>
                                    <span>@lang('Email Unverified')</span>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-4 col-6 col-xl-6 col-xxl-4">
                            <div class="dashboard-widget">
                                <div class="dashboard-widget__icon">
                                    <i class="dashboard-card-icon las la-credit-card"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <a title="@lang('View all')" class="dashboard-widget-link"
                                        href="{{route('admin.product.index')}}"></a>
                                    <h5>{{$widget['total_gyms']}}</h5>
                                    <span>@lang('Total Gyms')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6 col-xl-6 col-xxl-4">
                            <div class="dashboard-widget">
                                <div class="dashboard-widget__icon">
                                    <i class="dashboard-card-icon las la-spinner"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <a title="@lang('View all')" class="dashboard-widget-link"
                                        href="#"></a>
                                    <h5>{{$widget['top_activity']}}</h5>
                                    <span>@lang('Most Searched Activity')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6 col-xl-6 col-xxl-4">
                            <div class="dashboard-widget">
                                <div class="dashboard-widget__icon">
                                    <i class="dashboard-card-icon las la-wallet"></i>
                                </div>
                                <div class="dashboard-widget__content">
                                    <a title="@lang('View all')" class="dashboard-widget-link"
                                        href="#">
                                    </a>
                                    <h5>{{$widget['top_prices']}}</h5>
                                    <span>@lang('Most Searched Price')</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <div class="row justify-content-between align-items-center">
                    <div class="col-sm-6">
                        <h5 class="card-title" id="logins-card-title">@lang('Logins') (@lang('Last week'))</h5>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-select mb-3 logins-range-select">
                            <option value="week" selected>@lang('Week')</option>
                            <option value="month">@lang('Month')</option>
                            <option value="year">@lang('Year')</option>
                            <option value="all">@lang('All')</option>
                        </select>
                    </div>
                </div>
                <div id="login-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                <div class="card rounded-3">
                    <div class="card-body">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-sm-6">
                                <h5 class="card-title" id="activity-card-title">@lang('Most Searched Activities') (@lang('Last week'))</h5>
                            </div>
                            <div class="col-sm-3">
                                <input class="form-control mb-3" placeholder="@lang("Enter City")" type="text" id="search_activities_by_city">
                            </div>
                            <div class="col-sm-3">
                                <select class="form-select mb-3 activity-range-select">
                                    <option value="week" selected>@lang('Week')</option>
                                    <option value="month">@lang('Month')</option>
                                    <option value="year">@lang('Year')</option>
                                    <option value="all">@lang('All')</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="sticky-header" scope="col">#</th>
                                        <th class="sticky-header" scope="col">@lang('Activity')</th>
                                        <th class="sticky-header" scope="col">@lang('Location')</th>
                                        <th class="sticky-header" scope="col">@lang('Count')</th>
                                    </tr>
                                </thead>
                                <tbody id="activity-table-body">
                                    @foreach ($mostSearchedActivities as $activity)
                                    <tr>
                                        <td scope="row">{{ $loop->index + 1 }}</td>
                                        <td>{{ $activity['title'] }}</td>
                                        <td>{{ $activity['location'] }}</td>
                                        <td>{{ $activity['count'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card rounded-3">
                    <div class="card-body">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-sm-6">
                                <h5 class="card-title" id="service-card-title">@lang('Most Searched Services') (@lang('Last week'))</h5>
                            </div>
                            <div class="col-sm-3">
                                <input class="form-control mb-3" placeholder="@lang("Enter City")" type="text" id="search_services_by_city">
                            </div>
                            <div class="col-sm-3">
                                <select class="form-select mb-3 service-range-select">
                                    <option value="week" selected>@lang('Week')</option>
                                    <option value="month">@lang('Month')</option>
                                    <option value="year">@lang('Year')</option>
                                    <option value="all">@lang('All')</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="sticky-header" scope="col">#</th>
                                        <th class="sticky-header" scope="col">@lang('Service')</th>
                                        <th class="sticky-header" scope="col">@lang('Location')</th>
                                        <th class="sticky-header" scope="col">@lang('Count')</th>
                                    </tr>
                                </thead>
                                <tbody id="service-table-body">
                                    @foreach ($mostSearchedServices as $service)
                                    <tr>
                                        <td scope="row">{{ $loop->index + 1 }}</td>
                                        <td>{{ $service['title'] }}</td>
                                        <td>{{ $service['location'] }}</td>
                                        <td>{{ $service['count'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card rounded-3">
                    <div class="card-body">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-sm-6">
                                <h5 class="card-title" id="price-card-title">@lang('Most Searched Prices') (@lang('Last week'))</h5>
                            </div>
                            <div class="col-sm-3">
                                <input class="form-control mb-3" placeholder="@lang("Enter City")" type="text" id="search_prices_by_city">
                            </div>
                            <div class="col-sm-3">
                                <select class="form-select mb-3 price-range-select">
                                    <option value="week" selected>@lang('Week')</option>
                                    <option value="month">@lang('Month')</option>
                                    <option value="year">@lang('Year')</option>
                                    <option value="all">@lang('All')</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Count</th>
                                    </tr>
                                </thead>
                                <tbody id="price-table-body">
                                    @foreach ($mostSearchedPrices as $price)
                                    <tr>
                                        <td scope="row">{{ $loop->index + 1 }}</td>
                                        <td>{{ $price['title'] }}</td>
                                        <td>{{ $price['location'] }}</td>
                                        <td>{{ $price['count'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
    // [ login-chart ] start
    (function () {
        "use strict";
        $(document).ready(function() {
            let timeout = null;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var options = {
                series: [{
                    name: "User Count",
                    data: @json($userLogins['values'])
                }],
                chart: {
                    height: '310px',
                        type: 'area',
                            zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                colors: ['#00adad'],
                    labels: @json($userLogins['labels']),
                xaxis: {
                    type: 'date',
                        },
                yaxis: {
                    opposite: true
                },
                legend: {
                    horizontalAlign: 'left'
                }
            };

            var chart = new ApexCharts(document.querySelector("#login-chart"), options);
            chart.render();

            // Select the input element and attach a change event handler
            $('#search_activities_by_city').on('input', function() {
                if (timeout) {
                    clearTimeout(timeout);
                }

                timeout = setTimeout(() => {
                    getUserActivities($(this).val(), $('.activity-range-select').val());
                    timeout = null;
                }, 350);
            });

            // Select the input element and attach a change event handler
            $('#search_prices_by_city').on('input', function() {
                if (timeout) {
                    clearTimeout(timeout);
                }

                timeout = setTimeout(() => {
                    getUserPrices($(this).val(), $('.price-range-select').val());
                    timeout = null;
                }, 350);
            });

            // Select the input element and attach a change event handler
            $('#search_services_by_city').on('input', function() {
                if (timeout) {
                    clearTimeout(timeout);
                }

                timeout = setTimeout(() => {
                    getUserServices($(this).val(), $('.service-range-select').val());
                    timeout = null;
                }, 350);
            });

            function getUserLogins(type) {
                $.ajax({
                    type: "get",
                    url: "{{ route('admin.fetch.userLogins') }}",
                    data: {
                        type: type,
                    },
                    success: function (response) {
                        if ('error' in response) {
                            return;
                        }

                        chart.updateOptions({
                            series: [{
                                name: "User Count",
                                data: response.series.logins
                            }],
                            labels: response.labels,
                            xaxis: {
                                type: type === 'all' ? 'category' : 'datetime',
                            },
                        });

                        if (type === 'all') {
                            $('#logins-card-title').html("@lang('Logins')");
                        } else {
                            $('#logins-card-title').html("@lang('Logins') (@lang('Last')" + ' ' + type + ')');
                        }
                    }
                });
            }

            function getUserActivities(location, type) {
                $.ajax({
                    type: "get",
                    url: "{{ route('admin.fetch.userActivities') }}",
                    data: {
                        location: location,
                        type: type,
                    },
                    success: function (response) {
                        if ('error' in response) {
                            return;
                        }

                        var content = '';
                        for (let i = 0; i < response.length; i++) {
                            content += `<tr>
                                <td scope="row">${i + 1}</td>
                                <td>${response[i].title}</td>
                                <td>${response[i].location}</td>
                                <td>${response[i].count}</td>
                            </tr>`;
                        }
                        $('#activity-table-body').html(content);

                        if (type === 'all') {
                            $('#activity-card-title').html("@lang('Most Searched Activities')");
                        } else {
                            $('#activity-card-title').html("@lang('Most Searched Activities') (@lang('Last')" + ' ' + type + ')');
                        }
                    }
                });
            }

            function getUserServices(location, type) {
                $.ajax({
                    type: "get",
                    url: "{{ route('admin.fetch.userServices') }}",
                    data: {
                        location: location,
                        type: type,
                    },
                    success: function (response) {
                        if ('error' in response) {
                            return;
                        }

                        var content = '';
                        for (let i = 0; i < response.length; i++) {
                            content += `<tr>
                                <td scope="row">${i + 1}</td>
                                <td>${response[i].title}</td>
                                <td>${response[i].location}</td>
                                <td>${response[i].count}</td>
                            </tr>`;
                        }
                        $('#service-table-body').html(content);

                        if (type === 'all') {
                            $('#service-card-title').html("@lang('Most Searched Services')");
                        } else {
                            $('#service-card-title').html("@lang('Most Searched Services') (@lang('Last')" + ' ' + type + ')');
                        }
                    }
                });
            }

            function getUserPrices(location, type) {
                $.ajax({
                    type: "get",
                    url: "{{ route('admin.fetch.userPrices') }}",
                    data: {
                        location: location,
                        type: type,
                    },
                    success: function (response) {
                        if ('error' in response) {
                            return;
                        }

                        var content = '';
                        for (let i = 0; i < response.length; i++) {
                            content += `<tr>
                                <td scope="row">${i + 1}</td>
                                <td>${response[i].title}</td>
                                <td>${response[i].location}</td>
                                <td>${response[i].count}</td>
                            </tr>`;
                        }
                        $('#price-table-body').html(content);

                        if (type === 'all') {
                            $('#price-card-title').html("@lang('Most Searched Prices')");
                        } else {
                            $('#price-card-title').html("@lang('Most Searched Prices') (@lang('Last')" + ' ' + type + ')');
                        }
                    }
                });
            }

            $('.logins-range-select').on('change', function () {
                const type = $(this).val();
                getUserLogins(type);
            });

            $('.activity-range-select').on('change', function () {
                const type = $(this).val();
                const location = $('#search_activities_by_city').val();
                getUserActivities(location, type);
            });

            $('.service-range-select').on('change', function () {
                const type = $(this).val();
                const location = $('#search_services_by_city').val();
                getUserServices(location, type);
            });

            $('.price-range-select').on('change', function () {
                const type = $(this).val();
                const location = $('#search_prices_by_city').val();
                getUserPrices(location, type);
            });
        });
    }) ();
</script>
@endpush