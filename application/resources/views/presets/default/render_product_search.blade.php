<p>@lang('Showing Results'): {{@$products->count()}}</p>
<div class="product__body mt-2 mb-0">
    @forelse(request()->query('categories', []) as $categoryId)
    <div class="product__activity-item">
        {{ __(@getCategoryNameById($categoryId)) }}
        <button data-id="categories_{{$categoryId}}" data-type="categories" class="btn-remove-filter">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @empty
    @endforelse

    @forelse(request()->query('services', []) as $serviceId)
    <div class="product__activity-item">
        {{ __(@getServiceNameById($serviceId)) }}
        <button data-id="services_{{$serviceId}}" data-type="services" class="btn-remove-filter">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @empty
    @endforelse
</div>