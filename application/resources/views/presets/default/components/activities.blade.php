@php
    $categories = App\Models\Category::where('status', 1)->limit(10)->get();
@endphp
<!-- ==================== Categories Here ==================== -->
<div class="action-category-wrapper">
    <a class="action-category-item">
        <div class="action-category-item__text">
            <p>@lang('All')</p>
        </div>
    </a>
    <div class="action-category-divide-item"></div>
    @forelse($categories as $category)
    <a href="{{ route('product', ['categories' => $category->id] )}}" class="action-category-item">
        <div class="action-category-item__icon">
            @php echo $category->icon; @endphp
        </div>
        <div class="action-category-item__text">
            <p>{{__(@$category->name)}}</p>
        </div>
    </a>
    @empty
    @endforelse
</div>
<!-- ==================== Categories Here ==================== -->
