@extends($activeTemplate.'layouts.frontend')
@section('content')

<!-- ==================== Blog Start Here ==================== -->
<section class="blog py-60">
    <div class="container">
        <div class="row gy-4 justify-content-center">

            @forelse($blogs as $item)
            <div class="col-lg-6 col-md-6">
                <div class="blog-item">
                    <div class="blog-item__thumb">
                        <a href="{{ route('blog.details', [slug($item->data_values->title),$item->id])}}" class="blog-item__thumb-link">
                            <img src="{{getImage(getFilePath('blog').'/'. 'thumb_'.@$item->data_values->blog_image)}}" alt="@lang('Blog Image')">
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
                <p>@lang('No blog post available now.')</p>
            @endforelse

        </div>

        <!-- pagination -->
        <div class="row {{ $blogs->hasPages() ? 'pt-5' : '' }}">
            <div class="col-lg-12 justify-content-end d-flex">
                @if ($blogs->hasPages())
                <div class="Page navigation example">
                    @php echo paginateLinks($blogs) @endphp
                </div>
                @endif
            </div>
        </div>
    <!-- / pagination -->

    </div>
</section>
<!-- ==================== Blog End Here ==================== -->

@endsection
