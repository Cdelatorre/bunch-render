@extends($activeTemplate.'layouts.auth')
@section('content')
@php
    $policyPages = getContent('policy_pages.element',false,null,true);
    $credentials = $general->socialite_credentials;
@endphp
<!--=======-** Registration start **-=======-->
<section class="account bg-img register position-relative">
    <div class="account-inner">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-12">
                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2"> @lang('Welcome to Fitters!')</h3>
                            <h5 class="account-form__title mb-2"> @lang('Enter your details to enjoy everything we have for you')</h3>
                        </div>
                        <form action="{{ route('user.register') }}" method="POST" class="verify-gcaptcha">
                            @csrf
                            <div class="row gy-3">
                                @if(session()->get('reference') != null)
                                <div class="col-sm-12">
                                    <div class="form-group position-relative">
                                        <label for="referenceBy" class="form--label">@lang('ReferenceBy')</label>
                                        <input type="text" name="referBy" id="referenceBy" class="form--control" value="{{session()->get('reference')}}" readonly placeholder="@lang('Reference')">
                                    </div>
                                </div>
                                @endif
                                <div class="col-sm-12">
                                    <label class="form--label">@lang('Username')</label>
                                    <div class="form-group position-relative {{ $errors->has('username') ? 'has-error' : '' }}">
                                        <input type="text" class="form--control checkUser" name="username" value="{{ old('username') }}" required placeholder="@lang('Username')">
                                        <small class="text-danger usernameExist"></small>
                                        <div class="password-show-hide far fa-user "></div>
                                        @if($errors->has('username'))
                                        <span class="mt-1 form-validation-error">
                                            {{ $errors->first('username') }}
                                        </span>
                                        @endif
                                     </div>
                                </div>
                                <div class="col-sm-12 mt-2">
                                    <label class="form--label">@lang('Email')</label>
                                    <div class="form-group position-relative {{ $errors->has('email') ? 'has-error' : '' }}">
                                        <input type="email" class="form--control checkUser" name="email" value="{{ old('email') }}" required placeholder="@lang('Email')">
                                        <div class="password-show-hide fas fa-envelope"></div>
                                        @if($errors->has('email'))
                                        <span class="mt-1 form-validation-error">
                                            {{ $errors->first('email') }}
                                        </span>
                                        @endif
                                     </div>
                                </div>

                                <div class="col-sm-12 mt-2">
                                    <label class="form--label">@lang('Password')</label>
                                    <div class="form-group position-relative {{ $errors->has('password') ? 'has-error' : '' }}">
                                        <input id="password" type="password" class="form-control form--control" name="password" placeholder="@lang('Password')" required>
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
                                        @if($errors->has('password'))
                                        <span class="mt-1 form-validation-error">
                                            {{ $errors->first('password') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2">
                                    <label class="form--label">@lang('Confirm Password')</label>
                                    <div class="form-group position-relative {{ $errors->has('password') ? 'has-error' : '' }}">
                                        <input id="password_confirmation" type="password" class="form-control form--control" name="password_confirmation"  placeholder="@lang('Confirm Password')" required>
                                        <div class="password-show-hide fas fa-eye-slash toggle-password-change" data-target="password_confirmation"> </div>
                                        @if($errors->has('password'))
                                        <span class="mt-1 form-validation-error">
                                            {{ $errors->first('password') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <x-captcha></x-captcha>

                                @if($general->agree)
                                <div class="col-sm-12 mt-2">
                                    <div class="form--check">
                                        <input class="form-check-input" type="checkbox" id="agree" @checked(old('agree')) name="agree" required>
                                        <div class="form-check-label">
                                            <label for="agree" class="form--label"> @lang('I agree with Licences Info')</label>
                                            @foreach($policyPages as $policy) <a class="policy" href="{{ route('policy.pages',[slug($policy->data_values->title),$policy->id]) }}">{{ __($policy->data_values->title) }}</a> @if(!$loop->last), @endif @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="col-sm-12">
                                    <button type="submit" id="recaptcha" class="btn btn--base w-100 mt-2 mb-2">
                                        @lang('Sign Up')
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

                                            @if ($credentials->google->status == 1)
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
                                        <p class="have-account__text">@lang('Already Have An Account?') <a href="{{ route('user.login') }}" class="have-account__link">@lang('Login Now')</a></p>
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
<!-- Registration End Here  -->


<div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog custom--modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="existModalLongTitle">@lang('You are with us')</h5>
                <span class="close" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div class="modal-body">
                <p>@lang('You already have an account please Login ')</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--sm btn--base two" data-bs-dismiss="modal">@lang('Close')</button>
                <a href="{{ route('user.login') }}" class="btn btn--sm btn--base">@lang('Login')</a>
            </div>
        </div>
    </div>
</div>


@endsection
@push('style')
<style>
    /* .country-code .input-group-text{
        background: #fff !important;
    } */
    .country-code select{
        border: none;
    }
    .country-code select:focus{
        border: none;
        outline: none;
    }
    .modal-content{
        background-color:hsl(var(--black)) !important;
    }

</style>
@endpush

@push('script-lib')
<script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush