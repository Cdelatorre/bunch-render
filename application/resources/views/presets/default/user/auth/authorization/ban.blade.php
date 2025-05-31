@extends($activeTemplate .'layouts.frontend')
@section('content')

<section class="account bg-img login py-60 position-relative">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-7">
                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2 text-danger"> @lang('You are banned')</h3>
                        </div>
                        <p class="fw-bold mb-1">@lang('Reason'):</p>
                        <p>{{ __(@$user->ban_reason) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
