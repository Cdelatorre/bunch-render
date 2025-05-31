@extends($activeTemplate.'layouts.master')
@section('content')

<section class="account bg-img login position-relative">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-7">
                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2">@lang('Stripe Hosted')</h3>
                        </div>

                        <form role="form" id="payment-form" method="{{$data->method}}" action="{{$data->url}}">
                            @csrf
                            <input type="hidden" value="{{$data->track}}" name="track">
                            <div class="row">

                                <div class="col-md-6">
                                    <label class="form--label">@lang('Name on Card')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form--control" name="name"
                                            value="{{ old('name') }}" required autocomplete="off" autofocus />
                                        <span class="input-group-text"><i class="fa fa-font"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form--label">@lang('Card Number')</label>
                                    <div class="input-group">
                                        <input type="tel" class="form-control form--control" name="cardNumber"
                                            autocomplete="off" value="{{ old('cardNumber') }}" required autofocus />
                                        <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                                    </div>
                                </div>

                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label class="form--label">@lang('Expiration Date')</label>
                                    <input type="tel" class="form-control form--control" name="cardExpiry"
                                        value="{{ old('cardExpiry') }}" autocomplete="off" required />
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form--label">@lang('CVC Code')</label>
                                    <input type="tel" class="form-control form--control" name="cardCVC"
                                        value="{{ old('cardCVC') }}" autocomplete="off" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="btn btn--base w-100" type="submit"> @lang('Save')</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection


@push('script')
<script src="{{ asset('assets/common/js/card.js') }}"></script>

<script>
    (function ($) {
        "use strict";
        var card = new Card({
            form: '#payment-form',
            container: '.card-wrapper',
            formSelectors: {
                numberInput: 'input[name="cardNumber"]',
                expiryInput: 'input[name="cardExpiry"]',
                cvcInput: 'input[name="cardCVC"]',
                nameInput: 'input[name="name"]'
            }
        });
    })(jQuery);
</script>
@endpush
