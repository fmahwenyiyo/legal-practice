
@php
    $users = \Auth::user();
    $logo = asset('storage/uploads/profile/');
    $currantLang = $users->currentLanguage();
    $languages=App\Models\Utility::languages();
    $mode_setting = \App\Models\Utility::mode_layout();

@endphp

    <header class="dash-header {{(isset($mode_setting['cust_theme_bg']) && $mode_setting['cust_theme_bg'] == 'on')?'transprent-bg':''}}">
    <div class="header-wrapper">
        <div class="me-auto dash-mob-drp">
            <ul class="list-unstyled">

                <li class="dash-h-item mob-hamburger">
                    <a href="#!" class="dash-head-link" id="mobile-collapse">
                        <div class="hamburger hamburger--arrowturn">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </a>
                </li>

                <li class="dropdown dash-h-item drp-company">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0 " data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="theme-avtar">
                            <img alt="#" style="width:30px;"
                                src="{{ !empty(\Auth::user()->avatar) ? $logo . \Auth::user()->avatar : $logo . '/avatar.png' }}"
                                class="header-avtar">
                        </span>
                        <span class="hide-mob ms-2">
                            @if (!Auth::guest())
                                {{ __('Hi, ') }}{{ Auth::user()->name }}!
                            @else
                                {{ __('Guest') }}
                            @endif
                        </span>
                        <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                    </a>

                    <div class="dropdown-menu dash-h-dropdown">
                        <a href="{{route('users.edit', Auth::user()->id)}}" class="dropdown-item">
                            <i class="ti ti-user"></i>
                            <span>{{ __('Profile') }}</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" id="form_logout">
                            @csrf
                            <a href="#"  class="dropdown-item" id="logout-form">
                                <i class="ti ti-power"></i>
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </div>
                </li>

            </ul>
        </div>
        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown dash-h-item drp-language">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ti ti-world nocolor"></i>
                        <span class="drp-text hide-mob">{{ Str::upper($currantLang) }}</span>
                        <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown dropdown-menu-end " aria-labelledby="dropdownLanguage">
                        @foreach (App\Models\Utility::languages() as $lang)
                            <a href="{{ route('change.language', $lang) }}" class="dropdown-item {{ basename(App::getLocale()) == $lang ? 'text-danger' : '' }}">
                                {{ Str::upper($lang) }}
                            </a>
                        @endforeach
                        @can('create language')
                            <div class="dropdown-divider m-0"></div>
                            <a href="{{ route('manage.language', [basename(App::getLocale())]) }}"
                                class="dropdown-item text-primary">{{ __('Manage Language') }}</a>
                        @endcan
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>

@push('custom-script')
    <script>
        $('#logout-form').on('click',function(){
            event.preventDefault();
            $('#form_logout').trigger('submit');
        });
    </script>
@endpush
