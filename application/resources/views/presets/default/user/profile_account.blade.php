@extends($activeTemplate.'layouts.master')
@section('content')

<div class="row gy-4 justify-content-center">
    <div class="col-xl-4 col-lg-4">
       <div class="profile-left">
            <div class="dashboard_profile_wrap">
                <div class="profile_photo mt-3">
                    <img src="{{ getImage(getFilePath('userProfile').'/'.auth()->user()->image,getFileSize('userProfile')) }}" alt="@lang('User\'s prifile picture')">
                    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="photo_upload">
                            <label for="file_upload"><i class="fas fa-image"></i></label>
                            <input id="file_upload" name="image" type="file" class="upload_file" onchange="this.form.submit()" accept=".png, .jpeg, .jpg">
                        </div>
                    </form>
                </div>
            @if ($user->gm === 1)
                <a href="{{ getProductUrl($product) }}" class="sidebar-menu-list__link active">
                    {{ $product->title }}
                </a>
            @endif
                <h3>{{ strtolower($user->email) }}</h3>
                <p>{{ '@'.$user->username }}</p>
            </div>
       </div>
    </div>
    <div class="col-xl-8 col-lg-8">
        <div class="profile-right-wrap">
            <div class="row gy-3">
                <div class="col-sm-12">
                    <div class="profile-right">
                        <h5>@lang('Update Profile')</h5>
                    </div>
                </div>
            </div>
            <form method="post" enctype="multipart/form-data">
                @csrf
                <div class="row gy-3">
                    {{-- $user->gm === 1 => Gym Management --}}
                @if($user->gm === 1)
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="title" class="form--label">@lang('Your Name')</label>
                            <input type="text" class="form--control custom-form-field" id="title" name="title" value="{{$product->title}}" placeholder="@lang('Your Name')" required>
                        </div>
                    </div>
                @else
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="firstname" class="form--label">@lang('First Name')</label>
                            <input type="text" class="form--control custom-form-field" id="firstname" name="firstname" value="{{$user->firstname}}" placeholder="@lang('First Name')" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="lastname" class="form--label">@lang('Last Name')</label>
                            <input type="text" class="form--control custom-form-field" id="lastname" name="lastname" value="{{$user->lastname}}" required placeholder="@lang('Last Name')">
                        </div>
                    </div>
                @endif
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="username" class="form--label">@lang('Username')</label>
                            <input type="text" class="form--control custom-form-field" id="username" value="{{$user->username}}">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="email" class="form--label">@lang('Email')</label>
                            <input type="email" class="form--control custom-form-field" id="email" value="{{$user->email}}">
                        </div>
                    </div>
                @if($user->gm === 1)
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="mobile" class="form--label">@lang('Mobile')</label>
                            <input type="text" name="mobile" class="form--control custom-form-field" id="mobile" value="{{$product->phone}}">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="website" class="form--label">@lang('Website')</label>
                            <input type="text" name="website" class="form--control custom-form-field" id="website" value="{{$product->website}}">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="social_link" class="form--label">@lang('Social')</label>
                            <input type="text" name="social_link" class="form--control custom-form-field" id="social_link" value="{{$product->social_link}}">
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 d-none">
                        <div class="form-group">
                            <label for="short_description" class="form--label">@lang('Short Description')</label>
                            <textarea rows="4" name="short_description" class="form--control custom-form-field" id="short_description">{{@$product->short_description}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12">
                                <label for="description" class="form--label">@lang('Description')</label>
                                <textarea class="form--control custom-form-field trumEdit wyg" id="description" name="description" placeholder="@lang('Description')">{{@$product->description}}</textarea>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="mobile" class="form--label">@lang('Mobile')</label>
                            <input type="text" name="mobile" class="form--control custom-form-field" id="mobile" value="{{$user->mobile}}">
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 d-none">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12">
                                <label for="myself" class="form--label">@lang('Describe Yourself')</label>
                                <textarea class="form--control trumEdit wyg" id="myself" name="myself" placeholder="@lang('Describe yourself')">{{@$user->myself}}</textarea>
                            </div>
                        </div>
                    </div>
                @endif

                </div>

                <div class="row mt-4">
                    <div class="col-sm-12">
                        <div class="profile-right">
                            <h5>@lang('Address')</h5>
                        </div>
                    </div>
                </div>
                <div class="row gy-4">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="autocomplete" class="form--label">@lang('Find Your Location')</label>
                            <input type="text" name="autocomplete" class="form--control custom-form-field" id="autocomplete" placeholder="@lang('Find Your Location')">
                        </div>
                    </div>
                    @php
                        if($user->gm === 1) {
                            $address = json_decode($product->address, true) ?? [
                                "street_name" => "",
                                "street_number" => "",
                                "zip_code" => "",
                                "locality" => "",
                                "province" => ""
                            ];
                        } else {
                            $address = json_decode($user->address, true) ?? [
                                "street_name" => "",
                                "street_number" => "",
                                "zip_code" => "",
                                "locality" => "",
                                "province" => ""
                            ];
                        }
                    @endphp
                    <div class="col-md-8 col-sm-12">
                        <div class="form-group">
                            <label class="form--label">@lang('Street Name')</label>
                            <input class="form--control custom-form-field" type="text" name="address[street_name]" value="{{ $address['street_name'] }}" placeholder="@lang('Street Name')">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label class="form--label">@lang('Street Number')</label>
                            <input class="form--control custom-form-field" type="text" name="address[street_number]" value="{{ $address['street_number'] }}" placeholder="@lang('Street Number')">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label class="form--label">@lang('Zip Code')</label>
                            <input class="form--control custom-form-field" type="text" name="address[zip_code]" value="{{ $address['zip_code'] }}" placeholder="@lang('Zip Code')">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label class="form--label">@lang('Locality')</label>
                            <input class="form--control custom-form-field" type="text" name="address[locality]" value="{{ $address['locality'] }}" placeholder="@lang('Locality')">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label class="form--label">@lang('Province')</label>
                            <input class="form--control custom-form-field" type="text" name="address[province]" value="{{ $address['province'] }}" placeholder="@lang('Province')">
                        </div>
                    </div>
                    @if($user->gm === 1)
                    <input class="d-none" type="text" name="latitude" value="{{ $product->latitude }}">
                    <input class="d-none" type="text" name="longitude" value="{{ $product->longitude }}">
                    <input class="d-none" type="text" name="formatted_address" value="{{ $product->formatted_address }}">
                    <input class="d-none" type="text" name="place_id" value="{{ $product->place_id }}">
                    <input class="d-none" type="text" name="google_rating" value="{{ $product->google_rating }}">
                    <input class="d-none" type="text" name="google_review_count" value="{{ $product->google_review_count }}">
                    @endif
                </div>

            @if($user->gm === 1)
                <div class="row mt-4">
                    <div class="col-sm-12">
                        <div class="profile-right">
                            <h5>@lang('Billing Address')</h5>
                        </div>
                    </div>
                </div>
                <div class="row gy-4">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="billing_autocomplete" class="form--label">@lang('Find Your Location')</label>
                            <input type="text" name="billing_autocomplete" class="form--control custom-form-field" id="billing_autocomplete" placeholder="@lang('Find Your Location')">
                        </div>
                    </div>
                    @php
                        $billing_address = json_decode($product->billing_address, true) ?? [
                            "street_name" => "",
                            "street_number" => "",
                            "zip_code" => "",
                            "locality" => "",
                            "province" => ""
                        ];
                    @endphp
                    <div class="col-md-8 col-sm-12">
                        <div class="form-group">
                            <label class="form--label">@lang('Street Name')</label>
                            <input class="form--control custom-form-field" type="text" name="billing_address[street_name]" value="{{ $billing_address['street_name'] }}" placeholder="@lang('Street Name')">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label class="form--label">@lang('Street Number')</label>
                            <input class="form--control custom-form-field" type="text" name="billing_address[street_number]" value="{{ $billing_address['street_number'] }}" placeholder="@lang('Street Number')">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label class="form--label">@lang('Zip Code')</label>
                            <input class="form--control custom-form-field" type="text" name="billing_address[zip_code]" value="{{ $billing_address['zip_code'] }}" placeholder="@lang('Zip Code')">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label class="form--label">@lang('Locality')</label>
                            <input class="form--control custom-form-field" type="text" name="billing_address[locality]" value="{{ $billing_address['locality'] }}" placeholder="@lang('Locality')">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label class="form--label">@lang('Province')</label>
                            <input class="form--control custom-form-field" type="text" name="billing_address[province]" value="{{ $billing_address['province'] }}" placeholder="@lang('Province')">
                        </div>
                    </div>
                </div>
            @endif
                <div class="row mt-4">
                    <div class="col-sm-12">
                        <div class="profile-right">
                            <h5>@lang('Change Password')</h5>
                        </div>
                    </div>
                </div>
                <div class="row gy-4">
                    @if(!$newPassword)
                    <div class="col-sm-12">
                        <div class="input-group">
                            <input id="current_password" type="password" class="form--control custom-form-field" placeholder="@lang('Current Password')" name="current_password" autocomplete="off">
                            <div class="password-show-hide fas fa-eye-slash toggle-password-change" data-target="current_password"> </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-sm-12">
                        <div class="input-group">
                            <input id="password" type="password" class="form--control custom-form-field" name="password" placeholder="@lang('New Password')" autocomplete="off">
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

                    <div class="col-md-12 col-sm-12 mt-4">
                        <div class="row justify-content-between align-items-end">
                            <div class="col-sm-3 mb-3">
                                <button type="button" class="btn btn-delete-account w-100">
                                    @lang('Delete Account')
                                </button>
                            </div>
                            <div class="col-sm-3 mb-3">
                                <button type="submit" class="btn btn-update-account btn--base btn--sm border-none w-100">
                                    @lang('Update Profile')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script-lib')
<script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places" ></script>
<script src="{{ asset('assets/common/js/find_location.js') }}"></script>
@endpush

@push('script')
<script>
    const Toast2 = Swal.mixin({
        toast: true,
        position: 'top-right',
        showCloseButton: true,
        showConfirmButton: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
</script>
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

        $(document).on('click', '.btn-delete-account', async function () {
            const { value: accept } = await Toast2.fire({
                title: "@lang('Delete Account')",
                input: "checkbox",
                inputValue: 1,
                inputPlaceholder: `@lang('I agree to the deletion of my account.')`,
                confirmButtonText: `
                    Continue&nbsp;<i class="fa fa-arrow-right"></i>
                `,
                inputValidator: (result) => {
                    return !result && "@lang('You need to agree to the deletion of your account!')";
                }
            });
            if (accept) {
                $.ajax({
                    type: "post",
                    url: "{{route('user.delete')}}",
                    data: {
                        _token: "{{csrf_token()}}"
                    },
                    success: function (data) {
                        if (data.status == true) {
                            setTimeout(() => {
                                window.location.href = "{{ route('user.logout') }}";
                            }, 1000);
                        }
                    }
                });
            }
        });
    })(jQuery);
</script>
@endpush
