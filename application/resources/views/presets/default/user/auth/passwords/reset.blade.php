@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="account position-relative py-60">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-6">
                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2"> {{ __($pageTitle) }} </h3>
                        </div>
                        <p class="mb-3">@lang("Your account is verified successfully. Now you can change your password. Please enter a strong password and don't share it with anyone.")
                        </p>
                        <form method="POST" action="{{ route('user.password.update') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="row gy-3">
                                <div class="col-sm-12">
                                    <div class="form-group input-group position-relative">
                                        <input type="password" class="form--control" id="password" name="password" placeholder="@lang('Password')" required>
                                        <div class="password-show-hide fas fa-eye-slash toggle-password-change" data-target="password"></div>
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
                                    <div class="form-group input-group mb-2 position-relative">
                                        <input type="password" class="form--control" id="password_confirmation" name="password_confirmation" placeholder="@lang('Confirm Password')" required="">
                                        <div class="password-show-hide fas fa-eye-slash toggle-password-change" data-target="password_confirmation"></div>
                                     </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
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
