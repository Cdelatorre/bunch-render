@php
    $content        = getContent('testimonial.content',true);
    $elements        = getContent('testimonial.element',false, 7);
@endphp


<!-- ==================== Love Users Start Here ==================== -->
<section class="love-users-area py-60">
    <img class="love-user-bg-area" src="{{ activeTemplate(true).'/images/love-user-bg.png'}}" alt="">
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
        <div class="row gy-4 justify-content-center testimonial-slider">
            @forelse($elements as $item)
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="love-user">
                    <div class="love-user__thumb">
                        <img src="{{getImage(getFilePath('testimonial').'/'. @$item->data_values->image)}}" alt="">
                        <div class="icon">
                            <i class="fas fa-quote-right"></i>
                        </div>
                     </div>
                    <div class="love-user__content">
                        <h4 class="site-title">{{@$item->data_values->name}}</h4>
                        <span class="degination">{{__(@$item->data_values->designation)}}</span>
                        <div class="love-user__content">
                            @php echo $item->data_values->review; @endphp
                        </div>
                    </div>
                </div>
            </div>
            @empty

            @endforelse

        </div>
    </div>
</section>
<!-- ==================== Love Users End Here ==================== -->
