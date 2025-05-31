@php
    $content = getContent('breadcumb.content', true);
@endphp
<!-- ==================== Breadcumb Start Here ==================== -->
<section class="breadcumb">
    <img src="{{getImage(getFilePath('breadcumb').'/'. @$content->data_values->shape_image)}}" alt="shape" class="breadcumb-bg dark">
    <img src="{{getImage(getFilePath('breadcumb').'/'. @$content->data_values->shape_image_light)}}" alt="shape light" class="breadcumb-bg light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 px-1">
                <div class="breadcumb__wrapper">
                    <ul class="breadcumb__list">
                        <li class="breadcumb__item"><a href="{{route('home')}}" class="breadcumb__link"> <i class="las la-home"></i> @lang('Home')</a> </li>
                    @if(Route::is('product.details'))
                        <li class="breadcumb__item"><i class="fas fa-chevron-right"></i></li>
                        <li class="breadcumb__item"><a href="{{route('product')}}" class="breadcumb__link"> @lang('Browse Gyms')</a> </li>
                        @php
                            $address = json_decode($product['address'], true);
                            $city = strtolower($address['locality']);
                        @endphp
                        @if ($city)
                        <li class="breadcumb__item"><i class="fas fa-chevron-right"></i></li>
                        <li class="breadcumb__item"><a href="{{route('product.location', ['location' => $city])}}" class="breadcumb__link">{{__($city)}}</a> </li>
                        @endif
                    @endif
                        <li class="breadcumb__item"><i class="fas fa-chevron-right"></i></li>
                        <li class="breadcumb__item"> <h1 class="breadcumb__item-text pageTitle"> {{__($pageTitle) }}  </h1> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Breadcumb End Here ==================== -->
