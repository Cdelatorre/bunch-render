@extends($activeTemplate.'layouts.auth')
@section('content')
@php
    // objeto vacío por defecto!!!
    $credentials = (object)[];

    if ($general->socialite_credentials) {
        $credentials = is_string($general->socialite_credentials)
            ? json_decode($general->socialite_credentials)
            : $general->socialite_credentials;
    }

    if (!$credentials || empty((array)$credentials)) {
        $c = getContent('social_login.credential', true);
        if ($c) {
            $credentials = is_string($c->data_values)
                ? json_decode($c->data_values)
                : $c->data_values;
        }
    }

    if (!$credentials) {
        $credentials = (object)[];
    }
@endphp


  <!--=======-** Login start **-=======-->
  <section class="account bg-img login-page position-relative">
    <div class="account-inner">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-12">
                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2"> @lang('Hello again!')</h3>
                            <h5 class="account-form__title mb-2"> @lang('We have missed you')</h3>
                        </div>
                        <form method="POST" action="{{ route('user.login') }}" class="verify-gcaptcha">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-sm-12">
                                    <label class="form--label">@lang('Email')</label>
                                    <div class="form-group position-relative">
                                        <input type="text" class="form--control" name="username" value="{{ old('username') }}" placeholder="@lang('Email')">
                                        <div class="password-show-hide far fa-user "></div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <label class="form--label">@lang('Password')</label>
                                    <div class="form-group position-relative">
                                        <input id="password" type="password" class="form-control form--control" required name="password" placeholder="@lang('password')">
                                        <div class="password-show-hide fas fa-eye-slash toggle-password-change" data-target="password"> </div>
                                    </div>
                                </div>
                                  <x-captcha></x-captcha>
                                <div class="col-sm-12">
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="form--check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label form--label" for="remember">@lang('Remember Me')</label>
                                        </div>
                                        <a href="{{ route('user.password.request') }}" class="forgot-password">@lang('Forgot Your Password?')</a>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" id="recaptcha" class="btn btn--base w-100 mt-2 mb-2">
                                        @lang('Sign In')
                                    </button>
                                </div>

                                @if ($credentials->google->status == 1 || $credentials->facebook->status == 1 || $credentials->linkedin->status == 1)
                                <div class="col-sm-12 mt-2">
                                    <div class="login-social-wrap">
                                        <ul class="social-list mb-3">
                                            @if ($credentials->facebook->status == 1)
                                            <li class="social-list__item">
                                                <a href="{{ route('user.social.login', 'facebook') }}" class="social-list__link"> <i class="fab fa-facebook-f"></i></a>
                                            </li>
                                            @endif

                                            @if (optional($credentials->google)->status == 1)
                                            <li class="social-list__item">
                                                <a href="{{ route('user.social.login', 'google') }}" class="social-list__link"> <i class="fab fa-google"></i></a>
                                            </li>
                                            @endif

                                            @if ($credentials->linkedin->status == 1)
                                            <li class="social-list__item">
                                                <a href="{{ route('user.social.login', 'Linkedin') }}" class="social-list__link"> <i class="fab fa-linkedin-in"></i></a>
                                            </li>
                                            @endif

                                        </ul>
                                    </div>
                                </div>
                                @endif

                                <div class="col-sm-12 mt-0">
                                    <div class="have-account text-center">
                                        <p class="have-account__text">@lang('Don\'t have any account?') <a href="{{ route('user.register') }}" class="have-account__link">@lang('Create Account')</a></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=======-** Login End **-=======-->
@endsection
