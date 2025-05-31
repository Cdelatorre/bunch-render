@php
    $productUrl = getProductUrl($product);
@endphp

<div class="product-mobile">
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

        <div class="product__rating">{{ number_format($averageRating, 1) }}</div>
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
