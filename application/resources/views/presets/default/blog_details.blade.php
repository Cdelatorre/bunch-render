@extends($activeTemplate.'layouts.frontend')
@section('content')
<!-- ==================== Blog Start Here ==================== -->
<section class="blog-detials py-60">
    <div class="container">
        <div class="row gy-5 justify-content-center">
            <div class="col-lg-8">
                <div class="blog-details">

                    <div class="blog-item">
                        <div class="blog-item__thumb">
                            <img src="{{getImage(getFilePath('blog').'/'. @$blog->data_values->blog_image)}}" alt="@lang('Blog Image')">
                        </div>
                    </div>
                   <div class="blog-details__content">
                        <h3 class="blog-details__title mb-4">{{__(@$blog->data_values->title)}}</h3>
                        <div class="mb-3 blog_details_calender">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ $blog->created_at->format('M') }} {{ $blog->created_at->format('d') }}, {{ $blog->created_at->format('Y') }}</span>
                        </div>

                        <div class="blog-details__desc wyg">
                            @php echo $blog->data_values->description @endphp
                        </div>

                        <div class="blog-details__share mt-4 d-flex align-items-center flex-wrap mb-4">
                            <h5 class="social-share__title mb-0 me-sm-3 me-1 d-inline-block">@lang('Share This')</h5>
                            <ul class="social-list blog-details">
                                <li class="social-list__item"><a target="_blank" href="https://www.facebook.com/share.php?u={{ Request::url() }}&title={{slug($blog->data_values->title)}}" class="social-list__link"><i class="lab la-facebook-f"></i></a> </li>
                                <li class="social-list__item"><a target="_blank" href="https://twitter.com/intent/tweet?status={{slug($blog->data_values->title)}}+{{ Request::url() }}" class="social-list__link"> <i class="lab la-twitter"></i></a></li>

                                <li class="social-list__item"><a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url() }}&title={{slug($blog->data_values->title)}}&source=propertee" class="social-list__link"> <i class="lab la-linkedin-in"></i></a></li>
                                <li class="social-list__item"><a target="_blank" href="https://www.reddit.com/submit?url={{ Request::url() }}&title={{slug(@$blog->data_values->title)}}" class="social-list__link"> <i class="lab la-reddit"></i></a></li>
                                <li class="social-list__item"><a target="_blank" href="https://www.pinterest.com/pin/create/button/?url={{ Request::url() }}&description={{slug(@$blog->data_values->title)}}" class="social-list__link"> <i class="lab la-pinterest"></i></a></li>
                            </ul>
                        </div>

                   </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- ==================== Blog Details Sidebar Start =============== -->
                <div class="blog-sidebar-wrapper product-sidebar">
                    <div class="blog-sidebar">
                        <div class="side-bar-item">
                            <h5 class="blog-sidebar__title"> @lang('Search') </h5>
                            <form action="#" autocomplete="off">
                                <div class="search-box w-100">
                                    <input type="text" name="searchTerm" id="searchTerm" class="form--control" placeholder="@lang('Search blog')..."   autocomplete="off">
                                    <button type="submit" class="search-box__button"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>

                        <div class="search-result-box2">
                            <div class="search-wrap2" id="search-results"></div>
                        </div>

                        <div class="side-bar-item">
                            <h5 class="blog-sidebar__title">@lang('Latest Blog')</h5>
                            @forelse($newBlogs as $blog)
                            <div class="latest-blog">
                                <div class="latest-blog__thumb">
                                    <a href="{{ route('blog.details', [slug($blog->data_values->title),$blog->id])}}"> <img src="{{getImage(getFilePath('blog').'/'. @$blog->data_values->blog_image)}}" alt="@lang('blog image')"></a>
                                </div>
                                <div class="latest-blog__content">
                                    <h6 class="latest-blog__title"><a href="{{ route('blog.details', [slug($blog->data_values->title),$blog->id])}}">
                                        @if(strlen(__(@$blog->data_values->title)) >50)
                                        {{substr( __(@$blog->data_values->title), 0,50).'...' }}
                                    @else
                                        {{__(@$blog->data_values->title)}}
                                    @endif
                                    </a></h6>
                                    <span class="latest-blog__date">{{ $blog->created_at->format('M') }} {{ $blog->created_at->format('d') }}, {{ $blog->created_at->format('Y') }}</span>
                                </div>
                            </div>
                            @empty

                            @endforelse
                        </div>
                    </div>
                </div>
                <!-- ==================== Blog Details Sidebar End =============== -->
            </div>
        </div>
    </div>
</section>
<!-- ==================== Blog End Here ==================== -->
@endsection
@push('fbComment')
	@php echo loadExtension('fb-comment') @endphp
@endpush

@push('script')

    <script>


        $(document).ready(function() {
            "use strict";
        let searchTimeout;

        $('#searchTerm').on('keyup', function() {
            clearTimeout(searchTimeout);
            $('.search-result-box2').addClass('show');

            var searchTerm = $(this).val();
            if (searchTerm.length >= 1) {

                $('#search-results').html('<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>');

                searchTimeout = setTimeout(function() {
                    $.ajax({
                        url: "{{ route('blog.search') }}",
                        type: "GET",
                        data: {
                            searchTerm: searchTerm
                        },
                        success: function(response) {
                            var results = '';
                            var websiteUrl = "{{ url('/') }}/";
                            const slugify = str => str
                                .toLowerCase()
                                .trim()
                                .replace(/[^\w\s-]/g, '')
                                .replace(/[\s_-]+/g, '-')
                                .replace(/^-+|-+$/g, '');

                            if (response.blogs.length > 0) {
                                $.each(response.blogs, function(index, value) {

                                    let slug = slugify(value.data_values.title);
                                    var date = new Date(value.created_at);
                                    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                                    var month = monthNames[date.getMonth()];
                                    var day = date.getDate();
                                    var year = date.getFullYear();
                                    var formattedDate = month + ' ' + day + ', ' + year;

                                    results += '<div class="new">';
                                    results += '<a href="' + websiteUrl + 'blog/' + slug + '/' + value.id + '">';
                                    results += '<p class="title">' + value.data_values.title + '</p>';
                                    results += '<ul class="text-list inline">';
                                    results += '<li class="text-list__item"><span class="text-list__item-icon"><i class="fas fa-calendar-alt"></i> </span>' + formattedDate + '</li>';
                                    results += '</ul>';
                                    results += '</a>';
                                    results += '</div>';
                                });
                            } else {
                                results += '<div class="new">';
                                results += '<p>' + "@lang('No blog found')" + '</p>';
                                results += '</div>';
                            }

                            $('#search-results').html(results);

                        }
                    });
                }, 2000);
            } else {
                $('.search-result-box2').removeClass('show');
                $('#search-results').empty();
            }
        });
    });


</script>
@endpush
