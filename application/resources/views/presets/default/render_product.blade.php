

<div class="row gy-4 justify-content-center">
    <div class="col-lg-12 mb-2 filter-items">
        <div class="search-boarder border-radious-5 mb-2">
            {{-- @include('presets.default.render_product_search') --}}
        </div>
    </div>
</div>

<div class="row gy-4 justify-content-center filtered-product-map">
    <div class="col-lg-12 p-0">
        <div id="map"></div>
    </div>
</div>
<div class="row gy-4 justify-content-center filtered-product-list">
    @forelse($products as $product)
    @php
        $productUrl = getProductUrl($product);
    @endphp

    <div class="col-lg-12">
        <div class="product">
            <div class="product__thumb">
                <a href="{{ $productUrl }}">
                  <div class="product-details-slider product-slider-active">
                        @php
                            $image = $product->productImages->first();     // ← null si no hay
                            $src   = $image
                                    ? getImage(getFilePath('product').'/'.$image->path.'/'.$image->image)
                                    : asset('assets/images/general/default.png');
                        @endphp

                        <div class="product-single-slider">
                            <img src="{{ $src }}" alt="@lang('Gym Product')">
                        </div>
                    </div>

                    </div>
                </a>
            </div>

            <div class="product__top">
                <div class="site-title">
                    <a href="{{ $productUrl}}">{{__(@$product->title)}}</a>
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
                    <div class="product__description">
                        {{ $product->formatted_address }}, <a data-product_id="{{$product->id}}" class="btn--a--main btn-view-map">@lang('View On Maps')</a>
                    </div>
                </div>
                @php
                    $averageRating = 0.0;

                    if ($product->user) {
                        $totalReviews = $product->user->review_count + $product->google_review_count;
                        if ($totalReviews > 0) {
                            $averageRating = (
                                ($product->user->avg_review * $product->user->review_count) +
                                ($product->google_rating * $product->google_review_count)
                            ) / $totalReviews;
                        }
                    } else {
                        $totalReviews = $product->google_review_count;
                        if ($totalReviews > 0) {
                            $averageRating = $product->google_rating;
                        }
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

                <a href="{{ $productUrl}}">
                    <button class="product-btn">@lang('Details')</button>
                </a>
            </div>
        </div>
    </div>
    @empty
    @endforelse
</div>
<div class="liquid-loader d-none">
    <svg class="gegga">
        <defs>
            <filter id="gegga">
            <feGaussianBlur in="SourceGraphic" stdDeviation="7" result="blur" />
            <feColorMatrix
              in="blur"
              mode="matrix"
              values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 20 -10"
              result="inreGegga"
            />
            <feComposite in="SourceGraphic" in2="inreGegga" operator="atop" />
            </filter>
        </defs>
    </svg>
    <svg class="snurra" width="200" height="200" viewBox="0 0 200 200">
        <defs>
            <linearGradient id="linjärGradient">
                <stop class="stopp1" offset="0" />
                <stop class="stopp2" offset="1" />
            </linearGradient>
            <linearGradient
              y2="160"
              x2="160"
              y1="40"
              x1="40"
              gradientUnits="userSpaceOnUse"
              id="gradient"
              xlink:href="#linjärGradient"
            />
        </defs>
        <path
          class="halvan"
          d="m 164,100 c 0,-35.346224 -28.65378,-64 -64,-64 -35.346224,0 -64,28.653776 -64,64 0,35.34622 28.653776,64 64,64 35.34622,0 64,-26.21502 64,-64 0,-37.784981 -26.92058,-64 -64,-64 -37.079421,0 -65.267479,26.922736 -64,64 1.267479,37.07726 26.703171,65.05317 64,64 37.29683,-1.05317 64,-64 64,-64"
        />
        <circle class="strecken" cx="100" cy="100" r="64" />
    </svg>
    <svg class="skugga" width="200" height="200" viewBox="0 0 200 200">
        <path
          class="halvan"
          d="m 164,100 c 0,-35.346224 -28.65378,-64 -64,-64 -35.346224,0 -64,28.653776 -64,64 0,35.34622 28.653776,64 64,64 35.34622,0 64,-26.21502 64,-64 0,-37.784981 -26.92058,-64 -64,-64 -37.079421,0 -65.267479,26.922736 -64,64 1.267479,37.07726 26.703171,65.05317 64,64 37.29683,-1.05317 64,-64 64,-64"
        />
        <circle class="strecken" cx="100" cy="100" r="64" />
    </svg>
</div>
