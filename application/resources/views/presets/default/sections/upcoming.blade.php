@php
    $products = App\Models\Product::with(['getWishlist', 'productImages'])->where('status', 1)->where('started_at', '>', now())->where('expired_at', '>', now())->limit(3)->get();
    $content        = getContent('upcoming.content',true);
    $productUrl = getProductUrl($product);
@endphp


<!-- ==================== Product Start Here ==================== -->
<section class="products-area pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-heading  text-center">
                    <div class="section-heading__border">
                        <span class="one"></span>
                        <span class="two"></span>
                        <span class="three"></span>
                    </div>
                    <h2 class="section-heading__title">{{__(@$content->data_values->heading)}}</h2>
                    <p class="section-heading__desc">{{__(@$content->data_values->subheading)}}</p>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            @forelse($products as $product)
            <div class="col-lg-4 col-md-6">
                <div class="product">
                    <div class="product__thumb">
                        <a href="{{ $productUrl }}">
                            <div class="product-details-slider product-slider-active">
                                @forelse($product->productImages as $image)
                                <div class="product-single-slider">
                                    <img src="{{ getImage(getFilePath('product') . '/'.@$image->path .'/'.@$image->image)}}" alt="@lang('Gym Product')">
                                </div>
                                @empty

                                @endforelse
                            </div>
                        </a>
                    </div>
                    <div class="product__top">
                        <div class="site-title">
                            <a href="{{ $productUrl }}">{{__(@$product->title)}}</a>
                        </div>
                        <span class="product__price">{{$general->cur_sym}} {{showAmount($product->price,0)}}</span>
                    </div>
                    <div class="product__body">
                        <div class="price-item">
                            <p class="price-title">@lang('HIGHEST BID')</p>
                            <div class="price">
                                <span class="icon"><i class="fas fa-caret-up"></i></span><p>
                                    {{$general->cur_sym}}{{showAmount(highestRequestCount($product->id), 0)}}
                                </p>
                            </div>
                        </div>
                        <div class="price-item">
                            <p class="price-title">@lang('TOTAL BIDS')</p>
                            <div class="price">
                                <span class="icon"><i class="far fa-user"></i></span><p>{{totalRequestCount($product->id)}}</p>
                            </div>
                        </div>
                        <div class="price-item">
                            <p class="price-title">@lang('START TIME')</p>
                            <div class="price">
                                <span class="icon"><i class="far fa-clock"></i></span>
                                <p>
                                    <span id="countdown_{{ $product->id }}" class="countdown" data-date="{{ showDateTime(@$product->started_at, 'm/d/Y H:i:s') }}"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="product__bottom">
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#bidGym" class="product-btn bidGym">@lang('Request Now')</a>

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
                    </div>
                </div>
            </div>
            @empty

            @endforelse
        </div>
    </div>
</section>

<!-- Gym Modal -->
<div class="modal fade" id="bidGym" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog custom--modal">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabelUpcommingRequest">@lang('Warning')!</h1>
                <button type="button" class="btn--close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <p>@lang('When the auction is started, you can bid')</p>
            </div>
            <div class="modal-footer">
                <button class="btn--sm btn btn--base outline" data-bs-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>
<!-- Gym Modal  -->



<!-- ==================== Product End Here ==================== -->


@push('script')
    <script>
        (function($) {
            "use strict";

                $('.bidGym').on('click', function() {
                    var modal = $('#bidGym');
                    modal.modal('show');
                });

        })(jQuery);
    </script>
@endpush

