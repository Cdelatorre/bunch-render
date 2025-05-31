@php
    $products = App\Models\Product::with(['getWishlist','productImages'])->where('status', 1)->where('started_at', '<', now())->where('expired_at', '>', now())->latest()->limit(6)->get();
    $content        = getContent('liveauction.content',true);
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
                    <h2 class="section-heading__title">{{@$content->data_values->heading}}</h2>
                    <p class="section-heading__desc">{{@$content->data_values->subheading}}</p>
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
                            <p class="price-title">@lang('TIME LEFT')</p>
                            <div class="price">
                                <span class="icon"><i class="far fa-clock"></i></span>
                                <p>
                                    @if($product->expired_at > now())
                                        <span id="liveauction_{{ $product->id }}" class="countdown" data-date="{{ showDateTime(@$product->expired_at, 'm/d/Y H:i:s') }}"></span>
                                    @else
                                        <span>@lang('Closed')</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="product__bottom">
                        @auth()
                            <button data-bs-toggle="modal" data-product-id="{{$product->id}}" data-product-title="{{$product->title}}" data-product-price="{{showAmount($product->price, 2)}}" data-bs-target="#bidGymLiveProduct" class="product-btn bidGymLiveProduct">@lang('Request Now')</button>
                        @else
                            <button data-bs-toggle="modal" data-bs-target="#login-upcomming-bid" class="product-btn login-upcomming-bid">@lang('Request Now')</button>
                        @endauth


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



<div class="modal fade" id="bidGymLiveProduct" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog custom--modal">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabelLiveGymRequest">@lang('Would you like to participate in the') "<span class="live_auction_product_title"></span>" @lang('bidding competition')?</h1>
                <button type="button" class="btn--close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{route('user.bid')}}" method="post">
                @csrf
                <div class="modal-body">
                        <input type="hidden"  id="live_auction_product" name="product_id">
                        <div class="form-group">
                            <label class="form--label">@lang('Request Amount')</label>
                            <input type="number"  class="form--control" name="price" step="1" value="{{old('price')}}"  required>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn--sm btn btn--base outline" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--sm btn--base">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Gym Modal  -->

<!-- ==================== Product End Here ==================== -->



@push('script')
    <script>
        (function($) {
            "use strict";
                $('.bidGymLiveProduct').on('click', function() {
                    var modal = $('#bidGymLiveProduct');
                    var productTitle = $(this).data('product-title');
                    var productId = $(this).data('product-id');

                    var productPrice = $(this).data('product-price');

                    modal.find('.live_auction_product_title').text(productTitle);
                    modal.find('input[name="product_id"]').val(productId);
                    modal.find('input[name="price"]').attr('placeholder', productPrice);

                    modal.modal('show');
                });
        })(jQuery);
    </script>
@endpush
