@php
    $languages = App\Models\Language::all();
@endphp
<div class="dashboard_profile">
    <div class="dashboard_profile__details">
        <div class="dashboard_profile_wrap mb-5">
            <div class="logo-wrapper">
                <a href="{{route('home')}}" class="normal-logo"> <img src="{{ getImage('assets/images/general/logo.png') }}" alt="@lang('Normarl Logo')"></a>

            </div>
            <i class="las la-times close-hide-show"></i>
        </div>
        <div class="responsive-lang-wrap ms-4">
            <div class="input-grp d-flex align-items-center">
                <i class="fas fa-globe me-2"></i>
                <select class="form--control form-select f-control f-dropdown langSel">
                    @foreach ($languages as $lang)
                        <option value="{{$lang->code}}" @if(Session::get('lang')==$lang->code) selected @endif> {{__($lang->name)}} </option>
                    @endforeach
                </select>
              </div>
        </div>

        <ul class="sidebar-menu-list">
            <li class="sidebar-menu-list__item {{ Route::is('user.home') ? 'active' : '' }}">
                <a href="{{route('user.home')}}" class="sidebar-menu-list__link">
                    <span class="icon">
                        <i class="las la-th-large"></i>
                    </span>
                    <span>@lang('Dashboard')</span>
                </a>
            </li>

            <li class="sidebar-menu-list__item {{Route::is('user.request.history') ? 'active' : ''}}">
                <a href="{{route('user.request.history')}}" class="sidebar-menu-list__link">
                    <span class="icon">
                        <i class="las la-hammer"></i>
                    </span>
                    <span>@lang('Request History')</span>

                </a>
            </li>

            <li class="sidebar-menu-list__item {{Route::is('user.reviews.history') ? 'active' : ''}}">
                <a href="{{route('user.reviews.history')}}" class="sidebar-menu-list__link">
                <span class="icon">
                    <i class="las la-trophy"></i>
                </span>
                <span>@lang('Winning History')</span>

                </a>
            </li>
            <li class="sidebar-menu-list__item {{Route::is('user.auctionWishlist') ? 'active' : ''}}">
                <a href="{{route('user.auctionWishlist')}}" class="sidebar-menu-list__link">
                <span class="icon">
                    <i class="lab la-gratipay"></i>
                </span>
                <span>@lang('Wishlists')</span>

                </a>
            </li>


            <li class="sidebar-menu-list__item has-dropdown {{ Route::is('user.kyc.form') ? 'active' : '' }} {{ Route::is('user.kyc.data') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-menu-list__link">
                    <span class="icon">
                        <i class="las la-user-shield"></i>
                    </span>
                    <span>@lang('KYC')</span>

                </a>
                <div class="sidebar-submenu {{ Route::is('user.kyc.form') ? 'd-block' : '' }} {{ Route::is('user.kyc.data') ? 'd-block' : '' }}">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item {{ Route::is('user.kyc.form') ? 'active' : '' }}">
                            <a href="{{route('user.kyc.form')}}" class="sidebar-submenu-list__link">@lang('Form')</a>
                        </li>
                        <li class="sidebar-submenu-list__item {{ Route::is('user.kyc.data') ? 'active' : '' }}">
                            <a href="{{route('user.kyc.data')}}"  class="sidebar-submenu-list__link">@lang('Log')</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-menu-list__item has-dropdown {{ Route::is('user.profile.setting') ? 'active' : '' }} {{ Route::is('user.change.password') ? 'active' : '' }} {{ Route::is('user.twofactor') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-menu-list__link">
                    <span class="icon"><i class="las la-gavel"></i></span>
                    <span>@lang('Gyms')</span>
                </a>
                <div class="sidebar-submenu {{ Route::is('user.product.*') ? 'd-block' : '' }}">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item {{ Route::is('user.product.create') ? 'active' : '' }}">
                            <a href="{{ route('user.product.create') }}" class="sidebar-submenu-list__link">@lang('Create')</a>
                        </li>
                        <li class="sidebar-submenu-list__item {{ Route::is('user.product.index') ? 'active' : '' }}">
                            <a href="{{ route('user.product.index') }}" class="sidebar-submenu-list__link">@lang('All') </a>
                        </li>
                        <li class="sidebar-submenu-list__item {{ Route::is('user.product.pending') ? 'active' : '' }}">
                            <a href="{{ route('user.product.pending') }}" class="sidebar-submenu-list__link">@lang('Pending') </a>
                        </li>
                        <li class="sidebar-submenu-list__item {{ Route::is('user.product.live') ? 'active' : '' }}">
                            <a href="{{ route('user.product.live') }}" class="sidebar-submenu-list__link">@lang('Live') </a>
                        </li>
                        <li class="sidebar-submenu-list__item {{ Route::is('user.product.upcoming') ? 'active' : '' }}">
                            <a href="{{ route('user.product.upcoming') }}" class="sidebar-submenu-list__link">@lang('Upcomming') </a>
                        </li>
                        <li class="sidebar-submenu-list__item {{ Route::is('user.product.expired') ? 'active' : '' }}">
                            <a href="{{ route('user.product.expired') }}" class="sidebar-submenu-list__link">@lang('Expired') </a>
                        </li>
                        <li class="sidebar-submenu-list__item {{ Route::is('user.product.cancel') ? 'active' : '' }}">
                            <a href="{{ route('user.product.cancel') }}" class="sidebar-submenu-list__link">@lang('Cancel') </a>
                        </li>
                        <li class="sidebar-submenu-list__item {{ Route::is('user.product.winners') ? 'active' : '' }}">
                            <a href="{{ route('user.product.winners') }}" class="sidebar-submenu-list__link">@lang('Winners') </a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="sidebar-menu-list__item {{ Route::is('user.transactions') ? 'active' : '' }}">
                <a href="{{route('user.transactions')}}" class="sidebar-menu-list__link">
                    <span class="icon">
                        <i class="las la-search-dollar"></i>
                    </span>
                    <span>@lang('Transactions')</span>
                </a>
            </li>

            <li class="sidebar-menu-list__item has-dropdown {{ Route::is('user.deposit') ? 'active' : '' }} {{ Route::is('user.deposit.history') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-menu-list__link">
                    <span class="icon">
                        <i class="las la-hand-holding-usd"></i>
                    </span>
                    <span>@lang('Add Money')</span>
                </a>
                <div class="sidebar-submenu {{ Route::is('user.deposit') ? 'd-block' : '' }} {{ Route::is('user.deposit.history') ? 'd-block' : '' }}">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item {{ Route::is('user.deposit') ? 'active' : '' }}">
                            <a href="{{route('user.deposit')}}" class="sidebar-submenu-list__link">@lang('Add')</a>
                        </li>
                        <li class="sidebar-submenu-list__item {{ Route::is('user.deposit.history') ? 'active' : '' }}">
                            <a href="{{route('user.deposit.history')}}"  class="sidebar-submenu-list__link">@lang('Logs')</a>
                        </li>
                    </ul>
                </div>
            </li>


            <li class="sidebar-menu-list__item has-dropdown {{ Route::is('user.withdraw') ? 'active' : '' }} {{ Route::is('user.withdraw.history') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-menu-list__link">
                    <span class="icon">
                        <i class="las la-suitcase"></i>
                    </span>
                    <span>@lang('Withdraw')</span>
                </a>
                <div class="sidebar-submenu {{ Route::is('user.withdraw') ? 'd-block' : '' }} {{ Route::is('user.withdraw.history') ? 'd-block' : '' }}">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item {{ Route::is('user.withdraw') ? 'active' : '' }}">
                            <a href="{{route('user.withdraw')}}" class="sidebar-submenu-list__link">@lang('Balance')</a>
                        </li>
                        <li class="sidebar-submenu-list__item {{ Route::is('user.withdraw.history') ? 'active' : '' }}">
                            <a href="{{route('user.withdraw.history')}}"  class="sidebar-submenu-list__link">@lang('Logs')</a>
                        </li>
                    </ul>
                </div>
            </li>


            <li class="sidebar-menu-list__item {{ Route::is('ticket') ? 'active' : '' }}">
                <a href="{{route('ticket')}}" class="sidebar-menu-list__link">
                    <span class="icon">
                        <i class="las la-ticket-alt"></i>
                    </span>
                   <span>@lang('My Tickets')</span>
                </a>
            </li>

            <li class="sidebar-menu-list__item {{ Route::is('ticket.open') ? 'active' : '' }}">
                <a href="{{route('ticket.open')}}" class="sidebar-menu-list__link">
                    <span class="icon">
                        <i class="las la-plus-square"></i>
                    </span>
                    <span>@lang('Create Ticket')</span>
                </a>
            </li>

            <li class="sidebar-menu-list__item {{ Route::is('user.profile.setting') ? 'active' : '' }}">
                <a href="{{ route('user.profile.setting') }}" class="sidebar-menu-list__link">
                    <span class="icon">
                        <i class="las la-user"></i>
                    </span>
                    <span>@lang('Profile Setting')</span>
                </a>
            </li>

            <li class="sidebar-menu-list__item {{ Route::is('user.twofactor') ? 'active' : '' }}">
                <a href="{{ route('user.twofactor') }}" class="sidebar-menu-list__link">
                <span class="icon">
                    <i class="las la-shield-alt"></i>
                </span>
                <span>@lang('Two Factor')</span>
                </a>
            </li>

            <li class="sidebar-menu-list__item {{ Route::is('user.change.password') ? 'active' : '' }}">
                <a href="{{ route('user.change.password') }}" class="sidebar-menu-list__link">
                <span class="icon">
                    <i class="las la-key"></i>
                </span>
                <span>@lang('Change Password')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item">
                <a href="{{ route('user.logout') }}" class="sidebar-menu-list__link">
                <span class="icon">
                    <i class="las la-sign-out-alt"></i>
                </span>
                    <span>@lang('Log Out')</span>
                </a>
            </li>

        </ul>
    </div>
  </div>
