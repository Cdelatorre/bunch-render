@php
    $content        = getContent('winner.content',true);

    $winners = App\Models\Winner::with(['getUser','getProduct','getRequestUser'])->latest()->get();
@endphp

<!-- ====================winner Start Here ==================== -->
<section class="winner-area py-60">
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
        <div class="row gy-4 winner-slider justify-content-center">

            @forelse($winners as $winner)
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="winner">
                    <div class="winner__thumb">
                        <img src="{{ getImage(getFilePath('userProfile').'/'.@$winner->getUser->image) }}" alt="@lang('Winner Image')">
                        <div class="icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                     </div>
                     <div class="winner__content">
                        <h4 class="site-title">{{@$winner->getUser->fullname}}</h4>
                        <div class="winner__body-text">
                            <span class="small">@lang('Product Name')</span>
                            <span class="big">{{__(@$winner->getProduct->title)}}</span>
                        </div>
                        <div class="winner__bottom">
                            <div class="item">
                                <p class="title">@lang('Product Price')</p>
                                <p class="amount">{{$general->cur_sym}}{{showAmount(@$winner->getProduct->price,2)}}</p>
                            </div>
                            <div class="item">
                                <p class="title">@lang('Request Amount')</p>
                                <p class="amount">{{$general->cur_sym}}{{showAmount(@$winner->getRequestUser->price,2)}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty

            @endforelse
        </div>
    </div>
</section>
<!-- ==================== winner End Here ==================== -->
