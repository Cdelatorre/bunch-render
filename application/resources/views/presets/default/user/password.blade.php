@extends($activeTemplate.'layouts.master')

@section('content')

    <section class="account bg-img login py-60 position-relative">
        <div class="account-inner">
            <div class="container">
                <div class="row gy-4 justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-7">
                        <div class="account-form">
                            <div class="account-form__content mb-4">
                                <h3 class="account-form__title mb-2"> @lang('Change Password')</h3>
                            </div>
                            <form method="post">
                                @csrf

                                <div class="row gy-4">
                                    <div class="col-sm-12">
                                    <div class="input-group">
                                        <input id="current_password" type="password" class="form-control form--control" placeholder="@lang('Current Password')" name="current_password" required autocomplete="off">
                                        <div class="password-show-hide fas fa-eye-slash toggle-password-change" data-target="current_password"> </div>
                                    </div>
                                    </div>
                                    <div class="col-sm-12">
                                    <div class="input-group">
                                        <input id="password" type="password" class="form-control form--control" name="password" placeholder="@lang('Password')" required autocomplete="off">
                                        <div class="password-show-hide fas fa-eye-slash toggle-password-change" data-target="password"> </div>
                                            @if($general->secure_password)
                                            <div class="input-popup">
                                                <p class="error lower">@lang('1 small letter minimum')</p>
                                                <p class="error capital">@lang('1 capital letter minimum')</p>
                                                <p class="error number">@lang('1 number minimum')</p>
                                                <p class="error special">@lang('1 special character minimum')</p>
                                                <p class="error minimum">@lang('6 character password')</p>
                                            </div>
                                            @endif
                                    </div>
                                    </div>
                                    <div class="col-sm-12">
                                    <div class="input-group">
                                        <input id="password_confirmation" type="password" class="form-control form--control" placeholder="@lang('Confirm Password')" name="password_confirmation"
                                        required autocomplete="off">
                                        <div class="password-show-hide fas fa-eye-slash toggle-password-change" data-target="password_confirmation"> </div>
                                    </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn--base w-100 mt-4 mb-4 border-none">
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
@push('script-lib')
<script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";
        @if ($general -> secure_password)
            $('input[name=password]').on('input', function () {
                secure_password($(this));
            });

        $('[name=password]').focus(function () {
            $(this).closest('.form-group').addClass('hover-input-popup');
        });

        $('[name=password]').focusout(function () {
            $(this).closest('.form-group').removeClass('hover-input-popup');
        });

        @endif
    })(jQuery);
</script>
@endpush
