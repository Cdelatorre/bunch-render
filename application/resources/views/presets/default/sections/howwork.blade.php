@php
    $content        = getContent('howwork.content',true);
    $elements        = getContent('howwork.element',false, 3);
@endphp

<!-- ==================== How work Start Here ==================== -->
<section class="how-work-area py-60">
    <img src="{{ activeTemplate(true) . 'images/how-work-bg.png' }}" alt="how-work-bg.png" class="how-work-bg">
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
        <div class="row gy-4">
            @forelse($elements as $item)
            <div class="col-lg-4 col-md-6">
                <div class="how-work">
                    <div class="how-work__top">{{@$item->data_values->count}}</div>
                    <div class="how-work__content">
                        <h4 class="site-title">{{__(@$item->data_values->heading)}}</h4>
                        <p>{{__(@$item->data_values->subheading)}}</p>
                    </div>
                    <div class="how-work__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="143" height="27" viewBox="0 0 143 27" fill="none">
                            <path d="M1 15.165C1 15.165 64.7559 -15.165 130.677 15.165" stroke-opacity="0.53" stroke-width="1.5" stroke-dasharray="4 7"/>
                            <path d="M124.176 25.5129L141.414 20.1646L135.535 3.6748" stroke-opacity="0.53" stroke-width="1.5"/>
                        </svg>
                    </div>
                </div>
            </div>
            @empty

            @endforelse

        </div>
    </div>
</section>
<!-- ==================== How work  End Here ==================== -->
