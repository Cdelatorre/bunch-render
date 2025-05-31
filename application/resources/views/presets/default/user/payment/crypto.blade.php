@extends($activeTemplate.'layouts.master')

@section('content')

    <section class="account bg-img login position-relative">
        <div class="account-inner">
            <div class="container">
                <div class="row gy-4 justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-7">
                        <div class="account-form">
                            <div class="account-form__content mb-4">
                                <h3 class="account-form__title mb-2">@lang('Payment Preview')</h3>
                            </div>


                            <div class="row gy-4">
                                <div class="col-sm-12">
                                    <div class="card-body-deposit text-center">
                                        <h4 class="my-2"> @lang('PLEASE SEND EXACTLY') <span class="text-success"> {{ $data->amount }}</span> {{__($data->currency)}}</h4>
                                        <h5 class="mb-2">@lang('TO') <span class="text-success"> {{ $data->sendto }}</span></h5>
                                        <img src="{{$data->img}}" alt="@lang('Image')">
                                        <h4 class="text-white bold my-4">@lang('SCAN TO SEND')</h4>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
