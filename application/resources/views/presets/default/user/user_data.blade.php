@extends($activeTemplate.'layouts.frontend')

@section('content')
<section class="account position-relative py-60">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-7 col-xl-7 col-md-9">
                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2"> {{ __($pageTitle) }} </h3>
                        </div>

                            <form method="POST" action="{{ route('user.data.submit') }}">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-sm-6 mb-2">
                                        <label class="form--label">@lang('First Name')</label>
                                        <input type="text" class="form--control custom-form-field" name="firstname"
                                            value="{{ old('firstname') }}" required>
                                    </div>

                                    <div class="form-group col-sm-6 mb-2">
                                        <label class="form--label">@lang('Last Name')</label>
                                        <input type="text" class="form--control custom-form-field" name="lastname"
                                            value="{{ old('lastname') }}" required>
                                    </div>

                                    <div class="col-md-12 col-sm-12 mb-2">
                                        <div class="form-group">
                                            <label for="autocomplete" class="form--label">@lang('Find Your Location')</label>
                                            <input type="text" name="autocomplete" class="form--control custom-form-field" id="autocomplete" placeholder="@lang('Find Your Location')">
                                        </div>
                                    </div>

                                    <div class="col-md-8 col-sm-12 mb-2">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Street Name')</label>
                                            <input class="form--control custom-form-field" type="text" name="address[street_name]" value="" placeholder="@lang('Street Name')">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-2">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Street Number')</label>
                                            <input class="form--control custom-form-field" type="text" name="address[street_number]" value="" placeholder="@lang('Street Number')">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-2">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Zip Code')</label>
                                            <input class="form--control custom-form-field" type="text" name="address[zip_code]" value="" placeholder="@lang('Zip Code')">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-2">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Locality')</label>
                                            <input class="form--control custom-form-field" type="text" name="address[locality]" value="" placeholder="@lang('Locality')">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-2">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Province')</label>
                                            <input class="form--control custom-form-field" type="text" name="address[province]" value="" placeholder="@lang('Province')">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-5">
                                    <button type="submit" class="btn btn--base w-100">
                                        @lang('Submit')
                                    </button>
                                </div>
                            </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
              <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <i class="las la-times"></i>
              </span>
            </div>
            <div class="modal-body">
              <h6 class="text-center">@lang('You already have an account please Login ')</h6>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-dark two" data-bs-dismiss="modal">@lang('Close')</button>
              <a href="{{ route('user.login') }}" class="btn btn--base">@lang('Login')</a>
            </div>
          </div>
        </div>
      </div>
</section>

@endsection


@push('script-lib')
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places" ></script>
<script src="{{ asset('assets/common/js/find_location.js') }}"></script>
@endpush