@php
    $languages = App\Models\Language::all();
@endphp
<div class="row ">
    <div class="col-lg-12">
        <div class="dashboard-header-wrap d-flex justify-content-between">
            <div class="header-left d-flex align-items-center gap-4">
                <a href="{{route('user.home')}}" class="sidebar-menu-list__link {{ Route::is('user.home') ? 'active' : '' }}">
                    <span>@lang('Dashboard')</span>
                </a>
            @if(auth()->user()->gm === 1)
                <a href="{{route('user.profile.setting')}}" class="sidebar-menu-list__link {{ Route::is('user.profile.setting') ? 'active' : '' }}">
                    <span>@lang('Profile')</span>
                </a>
                <a href="{{route('user.profile.rates')}}" class="sidebar-menu-list__link {{ Route::is('user.profile.rates') ? 'active' : '' }}">
                    <span>@lang('Rates')</span>
                </a>
            @endif
                <a href="{{route('user.profile.account')}}" class="sidebar-menu-list__link {{ Route::is('user.profile.account') ? 'active' : '' }}">
                    <span>@lang('Account')</span>
                </a>
                {{-- <button> <i class="las la-bars dashboard-show-hide"></i></button> --}}
            </div>
            <div class="header-right">
                <div class="item">
                    <div class="icon">
                        <a href="{{route('user.logout')}}">
                            <i class="fas fa-sign-out-alt pr-2"></i>
                            @lang('Logout')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
