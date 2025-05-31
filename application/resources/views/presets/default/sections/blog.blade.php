@php
    $content = getContent('blog.content', true);
    if (request()->route()->uri == '/')
    {
        $elements = getContent('blog.element', false, 2);
    }
    else {
        $elements = getContent('blog.element', false, 12);
    }
@endphp

<!-- ==================== Blog Start Here ==================== -->
<section id="blog" class="blog py-60">
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
                    <h2 class="section-heading__title">{{ __(@$content->data_values->heading) }}</h2>
                    <p class="section-heading__desc">{{ __(@$content->data_values->subheading) }}</p>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            @forelse($elements as $item)
            <div class="col-lg-6 col-md-6">
                <div class="blog-item">
                    <div class="blog-item__thumb">
                        <a href="{{ route('blog.details', [slug($item->data_values->title),$item->id])}}" class="blog-item__thumb-link">
                            <img src="{{getImage(getFilePath('blog').'/'. @$item->data_values->blog_image)}}" alt="@lang('blog-image')">
                        </a>
                    </div>
                    <div class="blog-item__content">
                        <h4 class="site-title"><a href="{{ route('blog.details', [slug($item->data_values->title),$item->id])}}">{{__(@$item->data_values->title)}}</a></h4>
                        <p class="desc wyg">{{ __(strLimit(strip_tags(@$item->data_values->description,80), 80)) }}</p>

                        <div class="blog-item__bottom">
                            <div class="item">
                                <div class="icon"><i class="far fa-calendar-times"></i></div>
                                <div class="text">{{ $item->created_at->format('M') }} {{ $item->created_at->format('d') }}, {{ $item->created_at->format('Y') }}</div>
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
<!-- ==================== Blog End Here ==================== -->
