@php
    $pages = App\Models\Page::all();
    $languages = App\Models\Language::all();
    $socials = getContent('social_icon.element', false);
    $policyPages    = getContent('policy_pages.element');
    $socials = getContent('social_icon.element', false);
    $contactContent = getContent('contact_us.content', true);
    $user = auth()->user();

    if ($user) {
        $userImage = getImage('assets/images/user/profile/'. auth()->user()->image);
    } else {
        $userImage = getImage('assets/images/user/profile/default.png');
    }
@endphp
<!--========================== Header section Start ==========================-->
<div class="header-main-area">
    <div class="header" id="header">
        <div class="container position-relative">
            <div class="row">
                <div class="header-wrapper">

                    <div class="logo-wrapper">
                        <a href="{{route('home')}}" class="normal-logo"> <img src="{{ getImage('assets/images/general/logo.png') }}" alt="@lang('Normal Logo')"></a>
                    </div>


                    <div class="menu-wrapper">
                        <ul class="main-menu">
                            <li class="main-menu__menu-item"><a class="main-menu__menu-link {{ Route::is('addCenter') ? 'active' : '' }}" href="https://www.fitters.club/registra-tu-gimnasio">@lang('Add Your Center')</a></li>

                            {{-- <li class="main-menu__menu-item"><a class="main-menu__menu-link {{ Route::is('product') ? 'active' : '' }}" href="{{route('product')}}">@lang('Browse')</a></li> --}}

                            <li class="main-menu__menu-item">
                                <div class="header-language-wrap d-flex align-items-center">
                                    <div class="language-box ms-1">
                                        <select class="select langSel">
                                            @foreach ($languages as $lang)
                                                <option value="{{$lang->code}}" @if(Session::get('lang')==$lang->code) selected @endif> {{__($lang->name)}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="menu-right-wrapper">
                            <ul>
                                <li class="dropdown dropdown-menu-end sidebar-menu-show-hide">
                                    <button type="button" class="" data-bs-toggle="dropdown" data-display="static" aria-haspopup="true"
                                        aria-expanded="false">
                                        <span class="navbar-user">
                                            <span class="navbar-user__info icon">
                                                <i class="fas fa-bars"></i>
                                            </span>
                                            <span class="navbar-user__thumb">
                                                <img src="{{ $userImage }}" alt="image">
                                            </span>
                                        </span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu--sm p-0 border-0 box--shadow1 dropdown-menu-right">
                                        @guest()
                                            <a href="{{ route('user.login') }}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                                <span class="dropdown-menu__caption">@lang('Login')</span>
                                            </a>
                                            <a href="https://www.fitters.club/registra-tu-gimnasio" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                                <span class="dropdown-menu__caption">@lang('Add Your Center')</span>
                                            </a>
                                            <a href="https://www.fitters.club/blog" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                                <span class="dropdown-menu__caption">@lang('Blog')</span>
                                            </a>
                                        @else
                                            <a href="{{ route('user.profile.account') }}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                                <span class="dropdown-menu__caption">@lang('My Profile')</span>
                                            </a>
                                            <a href="https://www.fitters.club/registra-tu-gimnasio" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                                <span class="dropdown-menu__caption">@lang('Add Your Center')</span>
                                            </a>
                                            <a href="https://www.fitters.club/blog" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                                <span class="dropdown-menu__caption">@lang('Blog')</span>
                                            </a>
                                            <a href="{{ route('user.logout') }}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                                <span class="dropdown-menu__caption">@lang('Logout')</span>
                                            </a>
                                        @endguest()
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--========================== Header section End ==========================-->


 <!--========================== Sidebar mobile menu wrap Start ==========================-->
<div class="sidebar-menu-wrapper">
    <div class="top-close d-flex align-items-center justify-content-between mb-4">
        <div class="header-wrapper-siedebar">
            <div class="logo-wrapper">
                <a href="{{route('home')}}" class="normal-logo" id="footer-logo-normal"> <img src="{{ getImage('assets/images/general/logo_white.png') }}" alt="@lang('Normal Logo')"></a>
            </div>
        </div>
        <i class="las la-times close-hide-show"></i>
    </div>
    <ul class="sidebar-menu-list mobile">
        @guest()
            <li class="sidebar-menu-list__item d-flex justify-content-center">
                <a href="{{ route('user.login') }}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                    @lang('Login')
                </a>
            </li>
            <li class="sidebar-menu-list__item d-flex justify-content-center">
                <a href="https://www.fitters.club/registra-tu-gimnasio" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                    @lang('Add Your Center')
                </a>
            </li>
            <li class="sidebar-menu-list__item d-flex justify-content-center">
                <a href="https://www.fitters.club/blog" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                    @lang('Blog')
                </a>
            </li>
        @else
            <li class="sidebar-menu-list__item d-flex justify-content-center">
                <a href="{{ route('user.profile.setting') }}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                    @lang('My Profile')
                </a>
            </li>
            <li class="sidebar-menu-list__item d-flex justify-content-center">
                <a href="https://www.fitters.club/registra-tu-gimnasio" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                    @lang('Add Your Center')
                </a>
            </li>
            <li class="sidebar-menu-list__item d-flex justify-content-center">
                <a href="https://www.fitters.club/blog" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                    @lang('Blog')
                </a>
            </li>
            <li class="sidebar-menu-list__item d-flex justify-content-center">
                <a href="{{ route('user.logout') }}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                    @lang('Logout')
                </a>
            </li>
        @endguest()
    </ul>
    <div class="sidebar-menu-footer">
        <div class="sidebar-menu-footer-title" >@lang('Contact')</div>
        <ul class="footer-contact-menu">
            <li class="footer-contact-menu__item">
                <div class="footer-contact-menu__item-content">
                    <p><a href="mailto:{{__(@$contactContent->data_values->email)}}">{{__(@$contactContent->data_values->email)}}</a></p>
                </div>
            </li>
        </ul>
        <div class="login-social-wrap">
            <ul class="social-list mb-3">
                @foreach($socials ?? [] as $item)
                <li class="social-list__item">
                    <a href="{{$item->data_values->url}}" class="social-list__link">@php echo $item->data_values->social_icon; @endphp</a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="bottom-footer-text">
                            @php echo $contactContent->data_values->website_footer; @endphp
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <div class="footer-item">
                    <ul class="footer-contact-menu">
                        @foreach ($policyPages as $link)
                            <li class="footer-menu__item"><a class="footer-menu__link" href="{{ route('policy.pages',[slug($link->data_values->title),$link->id]) }}">{{ __(@$link->data_values->title) }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--========================== Sidebar mobile menu wrap End ==========================-->
