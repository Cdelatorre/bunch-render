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
                        <p class="mb-3">@lang('To recover your account please provide your email or username to find your account.')
                        </p>
                        <form method="POST" action="{{ route('user.password.email') }}">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-sm-12">
                                    <label for="email" class="form--label">@lang('Email or Username')</label>
                                    <div class="form-group input-group">
                                        <input type="text" class="form--control form--round-input" id="email" name="value"
                                        value="{{ old('value') }}" required autofocus="off">
                                        <div class="password-show-hide far fa-user "></div>
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
