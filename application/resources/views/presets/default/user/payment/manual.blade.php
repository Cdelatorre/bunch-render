@extends($activeTemplate.'layouts.master')

@section('content')

    <section class="account bg-img login position-relative">
        <div class="account-inner">
            <div class="container">
                <div class="row gy-4 justify-content-center">
                    <div class="col-xl-8 col-lg-8 col-md-10">
                        <div class="account-form">
                            <div class="account-form__content mb-4">
                                <h3 class="account-form__title mb-2"> {{__($pageTitle)}}</h3>
                            </div>
                            <form action="{{ route('user.deposit.manual.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="method_code">
                                <input type="hidden" name="currency">

                                <div class="row gy-4">
                                    <div class="col-md-12 text-center">
                                        <p class="text-center mt-2">@lang('You have requested') <b class="text-success">{{ showAmount($data['amount'])  }} {{__($general->cur_text)}}</b> , @lang('Please pay')
                                            <b class="text-success">{{showAmount($data['final_amo']) .' '.$data['method_currency'] }} </b> @lang('for successful payment')
                                        </p>
                                        <h4 class="text-center mb-4">@lang('Please follow the instruction below')</h4>
                                        <p class="my-4 text-center">@php echo  $data->gateway->description @endphp</p>
                                    </div>

                                    <x-custom-form identifier="id" identifierValue="{{ $gateway->form_id }}"></x-custom-form>

                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn--base w-100 mt-4 mb-4">
                                            @lang('Confirm')
                                        </button>
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
