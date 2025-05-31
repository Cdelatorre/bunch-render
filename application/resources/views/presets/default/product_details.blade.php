@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="product-detials py-60">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 mt-2">
                    <div class="product-details">
                        <div class="product-box">
                            <div class="product-box__right product__body">
                                <div class="product-box__title">
                                    <div class="product-box__top">
                                        <h3 class="site-title mb-1">{{__(@$product->title)}} </h3>
                                    </div>
                                    <div class="product-box__content">
                                        <p>{{__($product->formatted_address)}}</p>
                                    </div>
                                </div>

                                <div class="product-rating first-section">
                                    @auth()
                                        @if($product->getWishlist)
                                            @if($product->getWishlist->user_id == auth()->user()->id && $product->id == $product->getWishlist->product_id)
                                                <a href="javascript:void(0)" data-product_id="{{$product->id}}" class="love-icon wishlist-btn"><i class="fas fa-heart"></i></a>
                                            @else
                                                <a href="javascript:void(0)" data-product_id="{{$product->id}}" class="love-icon wishlist-btn"><i class="far fa-heart"></i></a>
                                            @endif

                                        @else
                                            <a href="javascript:void(0)" data-product_id="{{$product->id}}" class="love-icon wishlist-btn"><i class="far fa-heart"></i></a>
                                        @endif
                                    @else
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#login-upcomming-bid" class="login-upcomming-bid love-icon"><i class="far fa-heart"></i></a>
                                    @endauth
                                    <h4>@lang('From') {{$general->cur_sym}}{{showAmount($product->price,0)}} / @lang('Month')</h4>
                                    <span class="product__rating">{{ number_format($averageRating, 1) }}</span>
                                </div>
                            </div>
                            <div class="product-box__thumb">
                                <div class="product-details-slider product-details-active">
                                    @forelse($product->productImages as $image)
                                    <div class="product-single-slider">
                                        <img src="{{ getImage(getFilePath('product') . '/'.@$image->path .'/'.@$image->image)}}" alt="@lang('Gym Product')">
                                    </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="product-details_tab-wrapper first-section">
                            <div class="product-details-content-header">
                                @lang('Description')
                            </div>
                            <div class="product-details-content-body">
                                <div class="mb-3 wyg">
                                    @php echo trans($product->description) @endphp
                                </div>
                            </div>
                            <div class="product-details-content-header">
                                @lang('Activities')
                            </div>
                            <div class="product-details-content-body">
                                <div class="product__body mb-4">
                                    @forelse($product->getCategories as $category)
                                    <div class="product__activity-item">
                                        {{ __(@$category->category->name) }}
                                    </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mt-2">
                    <!-- ==================== product Sidebar Start =============== -->
                    <div class="blog-sidebar-wrapper product-sidebar mb-3">
                        <div class="blog-sidebar">
                            <div class="side-bar-item">
                                <div class="product__body">
                                    <div class="second-section product-rating">
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
                                        <h4>@lang('From') {{$general->cur_sym}}{{showAmount($product->price,0)}} / @lang('Month')</h4>
                                        <span class="product__rating">{{ number_format($averageRating, 1) }}</span>
                                    </div>
                                    <div class="google-map-wrap">
                                        <iframe src="https://maps.google.com/maps?q={{ $product->latitude }},{{ $product->longitude }}&hl=en&z=12&output=embed" width="100%" height="175px" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                    </div>
                                    <div class="product-box__bottom contact-information w-100">
                                        <ul>
                                            @if($product->formatted_address)
                                            <li><i class="fas fa-star"></i><span>{{ $product->formatted_address }}</span></li>
                                            @endif
                                            @if($product->phone)
                                            <li><i class="las la-phone"></i><span><a target="__blank" href="tel:{{ $product->phone }}">{{ $product->phone }}</a></span></span></li>
                                            @endif
                                            @if($product->email)
                                            <li><i class="far fa-envelope"></i><span><a target="__blank" href="mailto:{{ $product->email }}">{{ $product->email }}</a></span></li>
                                            @endif
                                            @if($product->social_link)
                                            <li><i class="fab fa-instagram"></i><span><a target="__blank" href="{{ $product->social_link }}">{{ $product->social_link }}</a></span></li>
                                            @endif
                                            @if($product->website)
                                            <li><i class="fas fa-desktop"></i><span><a target="__blank" href="{{ $product->website }}">{{ $product->website }}</a></span></li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="product-box__bottom w-100">
                                        @auth()
                                            @if($product->started_at < now())
                                                @if($product->call_to_action === 0)
                                                    <a title="@lang('Login')" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#reservation" class="btn btn--base  border-none mb-2 confirmation w-100">@lang('Request a free visit')</a>
                                                @elseif($product->call_to_action === 1)
                                                    <a target="__blank" href="{{ $product->website }}" class="btn btn--base  border-none mb-2 w-100">@lang('See the website')</a>
                                                @else
                                                    <a target="__blank" href="{{ $product->social_link }}" class="btn btn--base  border-none mb-2 w-100">@lang('See the instagram')</a>
                                                @endif
                                            @else
                                                <p class="text-danger">@lang('Gym is not available at this time.')</p>
                                            @endif
                                        @else
                                            @if($product->call_to_action === 0)
                                                <a title="@lang('Login')" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#confirmation" class="btn btn--base border-none mb-2 confirmation w-100">@lang('Request a free visit')</a>
                                            @elseif($product->call_to_action === 1)
                                                <a target="__blank" href="{{ $product->website }}" class="btn btn--base  border-none mb-2 w-100">@lang('See the website')</a>
                                            @else
                                                <a target="__blank" href="{{ $product->social_link }}" class="btn btn--base  border-none mb-2 w-100">@lang('See the instagram')</a>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ==================== product Sidebar End =============== -->

                </div>

                <div class="col-lg-8 mt-2">
                    <div class="product-details">
                        <div class="product-details_tab-wrapper">
                            {{-- <div class="product-details-content-header">
                                @lang('Specification')
                            </div>
                            <div class="product-details-content-body">
                                <div class="mb-4 wyg">
                                    <div class="specification mb-4">
                                        @if($product->specification != null)
                                            @forelse(json_decode($product->specification) as $item)
                                                <div class="specification__item">
                                                    <p>{{@$item->name}}</p>
                                                    <p>{{@$item->value}}</p>
                                                </div>
                                            @empty

                                            @endforelse
                                        @endif
                                    </div>
                                </div>
                            </div> --}}
                            <div class="product-details-content-header">
                                @lang('Schedules')
                            </div>
                            <div class="product-details-content-body">
                                <div class="mb-4 wyg">
                                    <div class="schedule mb-4">
                                        @if($product->schedules != null)
                                            @forelse(json_decode($product->schedules) as $item)
                                                <div class="schedule__item">
                                                    <p>{{@$item->name}}</p>
                                                    <p>{{@$item->start_time}} - {{@$item->end_time}}</p>
                                                </div>
                                            @empty

                                            @endforelse
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="product-details-content-header">
                                @lang('Rates')
                            </div>
                            <div class="product-details-content-body">
                                <div class="mb-4 wyg">
                                    <div class="rates mb-4">
                                        @if($product->rates != null)
                                            @forelse(json_decode($product->rates) as $item)
                                                <div class="rates__item">
                                                    <p>
                                                        <span>{{@$item->title}}</span>
                                                        <span>{{@$item->description}}</span>
                                                    </p>
                                                    <p>{{$general->cur_sym}}{{ showAmount($item->price, 2) }}</p>
                                                </div>
                                            @empty

                                            @endforelse
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="product-details-content-header">
                                @lang('Services')
                            </div>
                            <div class="product-details-content-body">
                                <div class="product-details-content-services">
                                    @php
                                        $groupServices = [];
                                        foreach ($product->getServices as $service) {
                                            $parentName = getServiceNameById($service->service->parent);
                                            $groupServices[$parentName][] = $service->service->name;
                                        }
                                    @endphp
                                    <div class="accordion custom--accordion" id="gservices">
                                        @forelse($groupServices as $parentName => $services)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne{{ $loop->index }}">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $loop->index }}" aria-expanded="true" aria-controls="collapseOne{{ $loop->index }}">
                                                    {{ __($parentName) }}
                                                </button>
                                            </h2>
                                            <div id="collapseOne{{ $loop->index }}" class="accordion-collapse collapse show" aria-labelledby="headingOne{{$loop->index}}" >
                                                <div class="accordion-body">
                                                    <ul>
                                                    @foreach($services as $service)
                                                        <li><i class="fas fa-check"></i><span>{{ __($service) }}</span></li>
                                                    @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        @empty

                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            <div class="product-details-content-header">
                                @lang('Reviews')
                            </div>
                            <div class="product-details-content-body">
                                <div class="rounded-3 review-section d-flex justify-content-center flex-column align-items-center mb-3">
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
                                </div>
                                <div class="review-wrap pb-0">
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

                                    @if(count($googleReviews['reviews']) > 0)
                                    <div class="product-details-content-header mb-5">
                                        <a href="{{ $googleReviews['url'] }}" class="text--base" target="__blank">@lang('Google Reviews') ( {{ $googleReviews['rating'] }} )</a>
                                    </div>

                                    @foreach($googleReviews['reviews'] as $g_review)
                                        <div class="review-wrap">
                                            <div class="review-wrap__top">
                                                <div class="review-wrap__thumb">
                                                    <img src="{{ $g_review['profile_photo_url'] }}" alt="@lang('Review')">
                                                </div>
                                                <div class="review-wrap__content">
                                                    <h4>{{@$g_review['author_name']}}</h4>
                                                    <h5>{{@$g_review['text']}}</h5>
                                                    <p>{{showDateTime((int) $g_review['time'], 'M d Y')}}</p>
                                                    <div class="rating-list">
                                                        <div class="rating-list__item">
                                                            @for ($i = 1; $i <= ceil($g_review['rating']); $i++)
                                                                <i class="fas fa-star"></i>
                                                            @endfor
                                                            @if (ceil($g_review['rating']) < 5)
                                                                @for ($i = $g_review['rating']; $i < 5; $i++)
                                                                    <i class="far fa-star"></i>
                                                                @endfor
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                        <div class="review-wrap">
                                            <div class="review-wrap__top">
                                                <div class="review-wrap__thumb"></div>
                                                <div class="review-wrap__content">
                                                    <a href="{{ $googleReviews['url'] }}" class="text--base" target="__blank">@lang('See more') ( {{ $googleReviews['user_ratings_total'] }} )</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Comments Form Start -->
                                    @auth()
                                        <div class="contact-form pt-4">
                                            <form action="{{ route('user.review') }}" method="POST">
                                                @csrf
                                                <div class="account-form__content mb-4">
                                                    <h3 class="account-form__title mb-2"> @lang('Review Here') </h3>
                                                    <p class="account-form__desc mb-2">@lang('Email not published. Required fields marked.') <span class="text-danger">*</span></p>
                                                    <div class="review-wrap d-flex align-items-center mb-2">
                                                        <p class="stock me-2">@lang('Give Rating'):<span class="text-danger"> *</span></p>
                                                        <ul class="rating-list review-rating justify-content-center d-flex">
                                                            <li class="rating-list__item"><i class="far fa-star" data-rating="1"></i></li>
                                                            <li class="rating-list__item"><i class="far fa-star" data-rating="2"></i></li>
                                                            <li class="rating-list__item"><i class="far fa-star" data-rating="3"></i></li>
                                                            <li class="rating-list__item"><i class="far fa-star" data-rating="4"></i></li>
                                                            <li class="rating-list__item"><i class="far fa-star" data-rating="5"></i></li>
                                                        </ul>

                                                        <input type="hidden" id="rating" name="rating" value="0">
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    </div>

                                                    <div class="row gy-md-4 gy-3">
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form--control" value="{{ auth()->user()->firstname && auth()->user()->lastname ? auth()->user()->firstname . ' ' . auth()->user()->lastname : auth()->user()->username }}" readonly>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="email" class="form--control" value="{{ auth()->user()->email }}" readonly>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <textarea class="form--control" placeholder="@lang('Write Your Feedback')" id="messages" name="message" required></textarea>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <button class="btn btn--base w-100">+ @lang('Add a review') <span class="button__icon"><i class="fas fa-paper-plane"></i></span></button>
                                                        </div>
                                                    </div>

                                                </div>

                                            </form>
                                        </div>
                                    @else
                                        <div>
                                            <a title="@lang('Login')" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#confirmation" class="btn btn--base border-none mb-2 confirmation">@lang('Login To Review')</a>
                                        </div>
                                    @endauth
                                    <!-- Comment Form End -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 m-0 p-0"></div>
            </div>
        </div>
    </section>

    @auth()
    <!-- Reservation Modal -->
    <div class="modal fade" id="reservation" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog custom--modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabelLogin">@lang('Choose a date and time')!</h1>
                    <button type="button" class="btn--close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <form action="{{route('user.bid')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="row gap-3">
                            <div class="col-12">
                                <div class="input-group">
                                    <label class="input-group-text bg--base" for="visitDate"><i class="far fa-calendar-check text-white"></i></label>
                                    <input type="text" name="visit_date" placeholder="@lang('Select Date')" id="visitDate" data-position="bottom left" class="form-control border-radius-5" value="{{ now()->addDays(1)->format('Y-m-d') }}" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-group">
                                    <label class="input-group-text bg--base" for="visitTime"><i class="fas fa-clock text-white"></i></label>
                                    <select name="visit_time" id="visitTime" class="form-control border-radius-5" required>
                                        @for ($i = 0; $i < 24 * 2; $i++)
                                            @php
                                                $time = \Carbon\Carbon::createFromTime(0, 0, 0)->addMinutes($i * 30);
                                            @endphp
                                            <option value="{{ $time->format('H:i') }}">{{ $time->format('h:i A') }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-wrapper">
                                    <input type="number" class="d-none" name="price" value="0" />
                                    <button class="product-btn w-100">@lang('Request a free visit')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Reservation Modal  -->
    @else
    <!-- Login Modal -->
    <div class="modal fade" id="confirmation" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog custom--modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabelLogin">@lang('Login To Your Account')!</h1>
                    <button type="button" class="btn--close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                </div>

                <form method="POST" action="{{ route('user.modal.login') }}" class="verify-gcaptcha">
                    @csrf
                    <input type="hidden" name="another" value="1">
                    <div class="modal-body">
                        <input type="text" name="username" class="form--control mb-3"  placeholder="@lang('Email or Username')" value="{{old('username')}}" required>

                        <div class="form-group input-group">
                            <input type="password" class="form--control" id="password" name="password" required="" placeholder="@lang('Password')">
                            <div class="password-show-hide fas fa-eye-slash toggle-password-change" data-target="password"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <x-captcha></x-captcha>
                    <button type="reset" class="btn--sm btn btn--base outline" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" id="recaptcha" class="btn btn--sm btn--base border-none">@lang('Login')</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Login Modal  -->
    @endauth

@endsection

@push('style-lib')
<link rel="stylesheet" href="{{asset('assets/admin/css/datepicker.min.css')}}">
@endpush


@push('script-lib')
<script src="{{ asset('assets/admin/js/datepicker.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/datepicker.en.js') }}"></script>
@endpush

@push('script')

    <script>
        (function($) {
            "use strict";

            $('.confirmation').on('click', function() {
                var modal = $('#confirmation');
                modal.modal('show');
            });

            $('.review-rating i').on('click', function() {
                var rating = parseInt($(this).data('rating'));
                $('#rating').val(rating);
                updateStars(rating);
            });

            $('#rating').on('input', function() {
                var rating = $(this).val();
                updateStars(rating);
            });

            function updateStars(rating) {
                var stars = $('.review-rating i');
                stars.removeClass('fas').addClass('far');
                stars.each(function(index) {
                    if (index < rating) {
                        $(this).removeClass('far').addClass('fas');
                    }
                });
            }

            var initialRating = parseInt($('#rating').val());
            if (initialRating > 0) {
                updateStars(initialRating);
            }


            var start = new Date(),
                prevDay,
                startHours = 0;

            start.setHours(0);
            start.setMinutes(0);

            if ([6, 0].indexOf(start.getDay()) != -1) {
                start.setHours(10);
                startHours = 10
            }

            $('#visitDate').datepicker({
                timepicker: false,
                language: 'en',
                dateFormat: 'yyyy-mm-dd',
                minHours: startHours,
                maxHours: 23,
                minDate: new Date(),
                todayBtn: true,
                onSelect: function (fd, d, picker) {
                    if (!d) return;

                    var day = d.getDay();

                    if (prevDay != undefined && prevDay == day) return;
                    prevDay = day;

                    if (day == 6 || day == 0) {
                        picker.update({
                            minHours: 0,
                            maxHours: 23
                        })
                    } else {
                        picker.update({
                            minHours: 0,
                            maxHours: 23
                        })
                    }
                }
            });

            $("[name=schedule]").on('change', function(e){
                var schedule = e.target.value;

                if(schedule != 1){
                    $("[name=started_at]").attr('disabled', true);
                    $('.started_at').css('display', 'none');
                    // $("[name=started_at]").val('');
                }else{
                    $("[name=started_at]").attr('disabled', false);
                    $('.started_at').css('display', 'block');
                }
            }).change();
        })(jQuery);

        // {{-- Reviews --}}
        (function ($) {
            "use strict";

            let rateBox = Array.from(document.querySelectorAll(".rate-box"));
            let globalValue = document.querySelector(".global-value");
            let two = document.querySelector(".two");
            let totalReviews = document.querySelector(".total-reviews");
            let reviews = @json($ratings);
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
        }) (jQuery);
    </script>
@endpush
