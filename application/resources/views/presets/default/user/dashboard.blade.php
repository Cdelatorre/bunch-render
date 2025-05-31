@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row product-details-area gap-2">
        <div class="col-xl-12 col-lg-12">
            <div class="row gy-4 justify-content-center dashboard-item-wrap">
                <div class="col-6 col-lg-3 col-md-4 col-sm-6">
                    <div class="action-category-item">
                        <div class="action-category-item__icon">
                            <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                viewBox="0 0 62 56" fill="none">
                                <path
                                    d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                </path>
                            </svg>
                            <i class="las la-ticket-alt"></i>
                        </div>
                        <div class="action-category-item__text">
                            <h4 class="site-title">{{ @$viewedHistory }}</h4>
                            <p>@lang('Seen gyms')</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-4 col-sm-6">
                    <div class="action-category-item">
                        <div class="action-category-item__icon">
                            <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                viewBox="0 0 62 56" fill="none">
                                <path
                                    d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                </path>
                            </svg>
                            <i class="las la-gavel"></i>
                        </div>
                        <div class="action-category-item__text">
                            <h4 class="site-title">{{ @$visits }}</h4>
                            <p>@lang('Visits')</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-4 col-sm-6">
                    <div class="action-category-item">
                        <div class="action-category-item__icon">
                            <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                viewBox="0 0 62 56" fill="none">
                                <path
                                    d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                </path>
                            </svg>
                            @if ($mostSearchedActivity)
                            <i class="las">{!! $mostSearchedActivity->icon !!}</i>
                            @else
                            <i class="las la-snowboarding"></i>
                            @endif
                        </div>
                        <div class="action-category-item__text">
                            @if ($mostSearchedActivity)
                            <h4 class="site-title">{{ @$mostSearchedActivity->name }}</h4>
                            @else
                            <h4 class="site-title">--/--</h4>
                            @endif
                            <p>@lang('Most sought after activity')</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-4 col-sm-6">
                    <div class="action-category-item">
                        <div class="action-category-item__icon">
                            <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                viewBox="0 0 62 56" fill="none">
                                <path
                                    d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                </path>
                            </svg>
                            <i class="las la-trophy"></i>

                        </div>
                        <div class="action-category-item__text">
                            <h4 class="site-title">{{ @count($reviews) }}</h4>
                            <p>@lang('Reviews')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-12 mt-4">
            <div class="alert alert-dismissible fade show alert_pink" role="alert">
                <i class="far fa-calendar-check"></i>
                <p><strong>@lang('Upcoming visits')</strong></p>
                <p>
                    @if ($todayVisits > 0)
                        {{ __('You have :count visit scheduled for today.', ['count' => $todayVisits]) }}
                    @else
                        @lang('You have not scheduled visits for today.')
                    @endif
                </p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <div class="col-8 p-0 m-0"></div>
        <div class="col-xl-12 col-lg-12 mt-4">
            <h5 class="dashboard-section-title">@lang('Visit History')</h5>
            <p class="site-title">{{ @$visits }}</p>
        </div>
        <div class="col-xl-12 col-lg-12">
            <div class="calendar-wrapper">
                <header>
                    <p class="current-date"></p>
                    <div class="icons">
                        <span id="prev">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                            <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"/>
                            </svg>
                        </span>

                        <span id="next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                            <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                            </svg>
                        </span>
                    </div>
                </header>

                <div class="calendar">
                    <ul class="weeks">
                        <li>@lang('SUN')</li>
                        <li>@lang('MON')</li>
                        <li>@lang('TUE')</li>
                        <li>@lang('WED')</li>
                        <li>@lang('THU')</li>
                        <li>@lang('FRI')</li>
                        <li>@lang('SAT')</li>
                    </ul>
                    <ul class="days"></ul>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 mt-4">
            <h5 class="dashboard-section-title">@lang('Your Favorites')</h5>
        </div>
        @forelse($wishlists as $item)
            @php
                $product = $item->getProduct;
            @endphp
            @if ($product)
            @php
                $productUrl = getProductUrl($product);
            @endphp
            <div class="col-lg-12">
                <div class="product">
                    <div class="product__thumb">
                        <a href="{{ $productUrl  }}">
                            <div class="product-details-slider product-slider-active">
                                @php
                                    $image = ($product->productImages)[0];
                                @endphp
                                {{-- @forelse($product->productImages as $image) --}}
                                <div class="product-single-slider">
                                    <img src="{{ getImage(getFilePath('product') . '/'.@$image->path .'/'.@$image->image)}}" alt="@lang('Gym Product')">
                                </div>
                                {{-- @empty --}}

                                {{-- @endforelse --}}
                            </div>
                        </a>
                    </div>
                    <div class="product__top">
                        <div class="site-title">
                            <a href="{{ $productUrl }}">{{__(@$product->title)}}</a>
                            @auth()
                                @if($product->getWishlist)
                                    @if($product->getWishlist->user_id == auth()->user()->id && $product->id == $product->getWishlist->product_id)
                                        <a href="javascript:void(0)" data-product_id="{{$product->id}}" class="love-icon  wishlist-btn"><i class="fas fa-heart"></i></a>
                                    @else
                                        <a href="javascript:void(0)" data-product_id="{{$product->id}}" class="love-icon  wishlist-btn"><i class="far fa-heart"></i></a>
                                    @endif

                                @else
                                    <a href="javascript:void(0)" data-product_id="{{$product->id}}" class="love-icon  wishlist-btn"><i class="far fa-heart"></i></a>
                                @endif
                            @else
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#login-upcomming-bid" class="login-upcomming-bid love-icon"><i class="far fa-heart"></i></a>
                            @endauth
                            <div class="product__description">
                                {{ $product->formatted_address }}
                            </div>
                        </div>
                        @php
                            $averageRating = 0.0;
                            if ($product->user) {
                                $averageRating = $product->user->avg_review;
                            }
                        @endphp

                        <span class="product__rating">{{ number_format($averageRating, 1) }}</span>
                    </div>
                    <div class="product__body">
                        @forelse($product->getCategories as $category)
                        <div class="product__activity-item">
                            {{ __(@$category->category->name) }}
                        </div>
                        @empty
                        @endforelse
                    </div>
                    <div class="product__bottom">
                        <span class="product__price">@lang('From') {{$general->cur_sym}}{{showAmount($product->price,0)}} / @lang('Month')</span>

                        <a href="{{ $productUrl }}">
                            <button class="product-btn">@lang('Details')</button>
                        </a>
                    </div>
                </div>
            </div>
            @endif
            @empty
        @endforelse
        <div class="col-xl-12 col-lg-12 mt-4">
            <h5 class="dashboard-section-title">@lang('Your Reviews')</h5>
        </div>
        <div class="col-xl-12 col-lg-12">
            <div class="dashboard-section review-wrap pb-0">
                @forelse($reviews as $review)
                    <div class="review-wrap">
                        <div class="review-wrap__top">
                            <div class="review-wrap__thumb">
                                <img src="{{ getImage(getFilePath('userProfile').'/'.@$review->review->image) }}" alt="@lang('Review')">
                            </div>
                            <div class="review-wrap__content">
                            <h4>{{@$review->review->fullname}}</h4>
                            <h5>{{@$review->message}}</h5>
                            <p>{{showDate(@$review->created_at)}}</p>
                            <div class="rating-list">
                                    <div class="rating-list__item">
                                        @for ($i = 1; $i <= ceil($review->rating); $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                        @if (ceil($review->rating) < 5)
                                            @for ($i = $review->rating; $i < 5; $i++)
                                                <i class="far fa-star"></i>
                                            @endfor
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>

@endsection

@push('script')

<script>
    (function () {
        const daysTag = document.querySelector(".days");
        const currentDate = document.querySelector(".current-date");
        const prevNextIcon = document.querySelectorAll(".icons span");
        let currYear = new Date().getUTCFullYear();
        let currMonth = new Date().getUTCMonth();

        const months = ["@lang('January')", "@lang('February')", "@lang('March')", "@lang('April')", "@lang('May')", "@lang('June')", "@lang('July')", "@lang('August')", "@lang('September')", "@lang('October')", "@lang('November')", "@lang('December')"];

        $(document).on('click', function (e) {
            if (!$(e.target).closest('[data-bs-toggle=popover]').length) {
                $('[data-bs-toggle=popover]').popover('hide');
            }
        });

        const renderCalendar = () => {
            const date = new Date(currYear, currMonth, 1);
            let firstDayofMonth = date.getDay();
            let lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate();
            let lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay();
            let lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate();

            let month = date.getMonth();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "get",
                url: "{{ route('user.fetch.visits') }}",
                data: {
                    "month": month + 1
                },
                dataType: "json",
                success: function (response) {
                    let liTag = "";

                    for (let i = firstDayofMonth; i > 0; i--) {
                        liTag += `<li class="inactive"></li>`;
                    }

                    const visitDays = Object.keys(response.visits);

                    for (let i = 1; i <= lastDateofMonth; i++) {
                        let isToday = i === new Date().getDate() && currMonth === new Date().getMonth() && currYear === new Date().getFullYear() ? "active" : "";
                        let visit = visitDays.find(v => v === i.toString());

                        if (visit) {
                            let visits = response.visits[visit];
                            let links = visits.map(v => `<a href='${v.link}' target='__blank'>${v.title} •></a>`).join('');

                            liTag += `<li class="visit-active ${isToday}" data-bs-offset="0,20" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-content="${links}">
                                        <span>${i}</span>
                                        <i>${visits.length}</i>
                                    </li>`;
                        } else {
                            liTag += `<li class="${isToday}"><span>${i}</span></li>`;
                        }
                    }

                    for (let i = lastDayofMonth; i < 6; i++) {
                        liTag += `<li class="inactive"></li>`
                    }

                    currentDate.innerText = `${months[currMonth]} ${currYear}`;
                    daysTag.innerHTML = liTag;

                    $('[data-bs-toggle=popover]').each(function (i, item) {
                        return new bootstrap.Popover($(item), {
                            html: true,
                            template: '<div class="popover popover-dark" role="tooltip"><div class="popover-arrow"></div><div class="popover-body"></div></div>'
                        });
                    }).on('show.bs.popover', function () {
                        $('[data-bs-toggle=popover]').not(this).popover('hide');
                    });

                    if (response.error) {
                        notify('error', response.error);
                    }
                }
            });
        };

        renderCalendar();

        prevNextIcon.forEach(icon => {
            icon.addEventListener("click", () => {
                currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

                if (currMonth < 0 || currMonth > 11) {
                    currYear = icon.id === "prev" ? currYear - 1 : currYear + 1;
                    currMonth = currMonth < 0 ? 11 : 0;
                }

                renderCalendar();
            });
        });
    }) ();

</script>


@endpush
