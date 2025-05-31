@extends($activeTemplate.'layouts.master')
@section('content')


<section class="account bg-img login position-relative">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-7">
                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2">@lang('Paystack')</h3>
                        </div>


                        <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST" class="text-center">
                            @csrf

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

                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn--base border-none w-100 mt-3" id="btn-confirm">@lang('Pay Now')</button>
                                </div>
                            </div>

                            <script src="//js.paystack.co/v1/inline.js"
                                data-key="{{ $data->key }}"
                                data-email="{{ $data->email }}"
                                data-amount="{{ round($data->amount) }}"
                                data-currency="{{$data->currency}}"
                                data-ref="{{ $data->ref }}"
                                data-custom-button="btn-confirm">
                            </script>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
