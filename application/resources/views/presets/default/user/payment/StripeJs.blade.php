@extends($activeTemplate.'layouts.master')
@section('content')

<section class="account bg-img login position-relative">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-7">
                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2">@lang('Stripe Storefront')</h3>
                        </div>

                        <form action="{{$data->url}}" method="{{$data->method}}">
                            <div class="row">
                                <div class="col-sm-12">
                                    <ul class="list-group text-center userData">
                                        <li class="list--group--item d-flex justify-content-between align-items-center">
                                            @lang('You have to pay '):
                                            <strong>{{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</strong>
                                        </li>
                                        <li class="list--group--item d-flex justify-content-between align-items-center">
                                            @lang('You will get '):
                                            <strong>{{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <script src="{{$data->src}}"
                                class="stripe-button"
                                @foreach($data->val as $key=> $value)
                                data-{{$key}}="{{$value}}"
                                @endforeach
                            >
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@push('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function ($) {
            "use strict";
            $('button[type="submit"]').addClass("btn btn--base w-100 mt-3");
            $('button[type="submit"]').text("Pay Now");
        })(jQuery);
    </script>
@endpush
