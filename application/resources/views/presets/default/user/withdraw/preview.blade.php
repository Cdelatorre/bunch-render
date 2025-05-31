@extends($activeTemplate.'layouts.master')
@section('content')

<section class="account bg-img login py-60 position-relative">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2">@lang('Withdraw Via') {{ $withdraw->method->name }}</h3>
                        </div>
                        <form action="{{route('user.withdraw.submit')}}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="row gy-4">
                                <div class="mb-2 withdraw-preview-text">
                                    @php
                                    echo $withdraw->method->description;
                                    @endphp
                                </div>
                                <x-custom-form identifier="id" identifierValue="{{ $withdraw->method->form_id }}"></x-custom-form>
                                @if(auth()->user()->ts)
                                <div class="col-sm-12">
                                    <label class="form--label">@lang('Google Authenticator Code')</label>
                                    <div class="input-group">
                                        <input type="text" name="authenticator_code" class="form-control form--control" required>
                                    </div>
                                </div>
                                @endif
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
