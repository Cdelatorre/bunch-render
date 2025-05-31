@extends($activeTemplate.'layouts.frontend')
@section('content')

@php
    $contact = getContent('contact_us.content',true);
@endphp

<!-- ==================== Contact Start Here ==================== -->
<section class="conact-area py-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="contact-left-wrap">
                    {{-- <h4 class="site-tile">
                        {{ @$contact->data_values->greeting }}
                    </h4> --}}
                    <form method="post" class="verify-gcaptcha">
                        @csrf
                        <div class="row gy-md-4 gy-3">
                            <div class="col-sm-12">
                                <input name="name" type="text" class="form--control" value="@if(auth()->user()){{ auth()->user()->fullname }} @else{{ old('name') }}@endif" @if(auth()->user()) readonly @endif required placeholder="@lang('Fullname')">
                            </div>
                            <div class="col-sm-12">
                                <input name="email" type="email" class="form--control"
                                    value="@if(auth()->user()){{ auth()->user()->email }}@else{{  old('email') }}@endif"
                                    @if(auth()->user()) readonly @endif required placeholder="@lang('Email')">
                            </div>
                            <div class="col-sm-12">
                                <input name="subject" type="text" class="form--control"
                                    value="{{old('subject')}}" placeholder="@lang('Subject')" required>
                            </div>
                            <div class="col-sm-12">
                                <textarea name="message" wrap="off" class="form--control" placeholder="@lang('Write your message')"
                                    required>{{old('message')}}</textarea>
                            </div>
                            <x-captcha></x-captcha>
                            <div class="col-sm-12">
                                <button id="recaptcha" class="btn btn--base w-100"> @lang('Submit Now')<span class="button__icon"> <i class="fas fa-paper-plane"></i></span></button>
                            </div>
                        </div>
                    </form>
                    <div class="contact-left-bottom">
                        <div class="icon-wrapper">
                            <span class="dotted-radius"></span>
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 41 41" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M24.6368 37.2549C24.6368 35.8378 23.488 34.689 22.071 34.689H18.929C18.2485 34.689 17.5959 34.9594 17.1147 35.4406C16.6335 35.9217 16.3632 36.5744 16.3632 37.2549C16.3632 38.6719 17.512 39.8207 18.929 39.8207H22.071C23.488 39.8207 24.6368 38.6719 24.6368 37.2549ZM5.39414 30.6386C5.82272 30.6713 6.34123 30.6902 6.86205 30.6597C7.13953 32.0668 7.82884 33.3719 8.85776 34.4009C10.2237 35.7668 12.0763 36.5342 14.0081 36.5342H14.9871C14.9439 36.7704 14.9218 37.0115 14.9218 37.2549C14.9218 37.501 14.9439 37.7419 14.9865 37.9756H14.0081C11.694 37.9756 9.47476 37.0564 7.83853 35.4201C6.53317 34.1147 5.68411 32.4383 5.39414 30.6386ZM4.66095 29.1049C3.52296 28.913 2.464 28.372 1.63736 27.5453C0.588975 26.4969 0 25.0749 0 23.5923V20.1855C0 18.7029 0.588975 17.2809 1.63736 16.2325C2.68574 15.1842 4.10769 14.5951 5.59033 14.5951H5.96246C6.55728 7.08729 12.8388 1.17969 20.5 1.17969C28.1612 1.17969 34.4427 7.08729 35.0375 14.5951H35.4097C36.8923 14.5951 38.3143 15.1842 39.3626 16.2325C40.411 17.2809 41 18.7029 41 20.1855V23.5923C41 25.0749 40.411 26.4969 39.3626 27.5453C38.3143 28.5937 36.8923 29.1827 35.4097 29.1827H33.76C33.0758 29.1827 32.5212 28.628 32.5212 27.9439V15.7634C32.5212 9.12424 27.1391 3.74219 20.5 3.74219C13.8609 3.74219 8.47883 9.12424 8.47883 15.7634V27.9439C8.47883 28.4269 8.20232 28.8455 7.79889 29.0498C6.68836 29.4351 4.96613 29.1563 4.66095 29.1049Z"></path>
                                     </svg>
                                </div>
                        </div>
                        <p class="site-title">@lang('Get in touch with us')</p>
                        <a class="text--base" href="tel:{{__(@$contact->data_values->contact_number)}}">{{__(@$contact->data_values->contact_number)}}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="contact-right-wrapper mt-3">
                    <div class="action-category-wrapper">
                        <div class="action-category-item">
                            <div class="action-category-item__icon">
                                <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56" viewBox="0 0 62 56" fill="none">
                                    <path d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z"></path>
                                    </svg>
                                    <i class="fas fa-phone-volume"></i>
                            </div>
                            <div class="action-category-item__text mt-2">
                                <p class="site-title"><a href="tel:{{__(@$contact->data_values->contact_number)}}">{{__(@$contact->data_values->contact_number)}}</a></p>
                            </div>
                        </div>
                        <div class="action-category-item">
                            <div class="action-category-item__icon">
                                <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56" viewBox="0 0 62 56" fill="none">
                                    <path d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z"></path>
                                    </svg>
                                    <i class="far fa-envelope"></i>
                            </div>
                            <div class="action-category-item__text mt-2">
                                <p class="site-title"><a href="mailto:{{__(@$contact->data_values->email)}}">{{__(@$contact->data_values->email)}}</a></p>
                            </div>
                        </div>
                        <div class="action-category-item">
                            <div class="action-category-item__icon">
                                <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56" viewBox="0 0 62 56" fill="none">
                                    <path d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z"></path>
                                    </svg>
                                    <i class="fas fa-map-marker-alt mt-2"></i>
                            </div>
                            <div class="action-category-item__text">
                                <p class="site-title"><a href="javascript:void(0)">{{__(@$contact->data_values->address)}}</a></p>
                            </div>
                        </div>
                        <div class="action-category-item">
                            <div class="action-category-item__icon">
                                <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56" viewBox="0 0 62 56" fill="none">
                                    <path d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z"></path>
                                </svg>
                                <i class="fas fa-headset"></i>
                            </div>
                            <div class="action-category-item__text mt-2">
                                <p class="site-title"><a href="mailto:{{__(@$contact->data_values->support_email)}}">{{__(@$contact->data_values->support_email)}}</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="google-map-wrap">
                        <iframe src="https://maps.google.com/maps?q={{ @$contact->data_values->latitude }},{{ @$contact->data_values->longitude }}&hl=es;z=14&amp;output=embed" width="100%" height="425" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Contact End Here ==================== -->

@endsection
