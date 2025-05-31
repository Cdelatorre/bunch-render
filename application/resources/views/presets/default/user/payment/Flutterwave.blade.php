@extends($activeTemplate.'layouts.master')

@section('content')
<section class="account bg-img login position-relative">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-7">
                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2">@lang('Flutterwave')</h3>
                        </div>
                        <div class="row gy-4">
                            <div class="col-sm-12">
                                <ul class="list-group userData">
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
                                <button type="button" class="btn btn--base border-none w-100 mt-3" id="btn-confirm" onClick="payWithRave()">@lang('Pay Now')</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
@push('script')
    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
    <script>
        "use strict"
        var btn = document.querySelector("#btn-confirm");
        btn.setAttribute("type", "button");
        const API_publicKey = "{{$data->API_publicKey}}";
        function payWithRave() {
            var x = getpaidSetup({
                PBFPubKey: API_publicKey,
                customer_email: "{{$data->customer_email}}",
                amount: "{{$data->amount }}",
                customer_phone: "{{$data->customer_phone}}",
                currency: "{{$data->currency}}",
                txref: "{{$data->txref}}",
                onclose: function () {
                },
                callback: function (response) {
                    var txref = response.tx.txRef;
                    var status = response.tx.status;
                    var chargeResponse = response.tx.chargeResponseCode;
                    if (chargeResponse == "00" || chargeResponse == "0") {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                    } else {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                    }
                        // x.close(); // use this to close the modal immediately after payment.
                    }
                });
        }
    </script>
@endpush
