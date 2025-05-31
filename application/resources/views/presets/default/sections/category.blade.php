@php
    $categories = App\Models\Category::where('status', 1)->inRandomOrder()->limit(10)->get();
    $content = getContent('category.content',true);
@endphp
<!--========================== Category Section Start ==========================-->
<div class="category-area pb-120">
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
        <div class="row">
            <div class="action-category-wrapper">
                @forelse($categories as $category)
                <div class="action-category-item">
                    <div class="action-category-item__icon">
                        <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56" viewBox="0 0 62 56" fill="none">
                            <path d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z"/>
                            </svg>
                        @php echo $category->icon; @endphp
                    </div>
                    <div class="action-category-item__text">
                        <h4 class="site-title"><a href="{{ route('product', ['categories' => $category->id] )}}">{{__(@$category->name)}}</a></h4>
                    </div>
                </div>
                @empty

                @endforelse

            </div>
        </div>
    </div>
</div>
<!--========================== Category Section End ==========================-->
