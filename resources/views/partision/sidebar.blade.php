@php
    use App\Models\Utility;
    $company_logo=App\Models\Utility::getValByName('company_logo');
    $company_small_logo=App\Models\Utility::getValByName('company_small_logo');
    $mode_setting = \App\Models\Utility::mode_layout();
    $logo=asset('storage/uploads/logo/');
    $company_logo=Utility::get_company_logo();
    $SITE_RTL = !empty($setting['SITE_RTL'] ) ? $setting['SITE_RTL']  : 'off';

@endphp

<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<!-- [ Pre-loader ] End -->

<!-- [ navigation menu ] start -->
<nav class="dash-sidebar light-sidebar {{(isset($mode_setting['cust_theme_bg']) && $mode_setting['cust_theme_bg'] == 'on')?'transprent-bg':''}}">

    <div class="navbar-wrapper">
        <div class="m-header main-logo">
            <a href="{{route('dashboard')}}" class="b-brand">
                <!-- ========   change your logo hear   ============ -->
                <img src="{{ $logo .'/'. (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') }}" alt="" class="logo logo-lg" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="dash-navbar">


                <li class="dash-item dash-hasmenu {{\Request::route()->getName() == 'dashboard' ? 'active' : ''}}" >
                    <a href="{{ route('dashboard') }}" class="dash-link ">
                        <span class="dash-micon"><i class="ti ti-home"></i>
                        </span><span class="dash-mtext">{{ __('Dashboard') }}</span>
                        <span class="dash-arrow"></span>
                    </a>
                </li>

                @if (Auth::user()->type == 'super admin')


                    @can('manage user')
                    <li class="dash-item dash-hasmenu {{ request()->is('users*') ? 'active' : '' }}">
                        <a href="{{route('users.index')}}" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-users"></i></span><span class="dash-mtext">{{__('User')}}</span>
                        </a>
                    </li>
                    @endcan
                @else
                    @canany(['manage member', 'manage group', 'manage role'])
                    <li class="dash-item dash-hasmenu">
                        <a href="#!" class="dash-link ">
                            <span class="dash-micon"><i class="ti ti-users"></i>
                            </span><span class="dash-mtext">{{ __('Staff') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul
                            class="dash-submenu {{ Request::segment(1) == 'roles'  || Request::segment(1) == 'users' || Request::segment(1) == 'groups' ? 'show' : '' }}">

                            @can('manage role')
                            <li class="dash-item {{ in_array(Request::segment(1), ['roles', '']) ? ' active' : '' }}">
                                <a class="dash-link" href="{{ route('roles.index') }}">{{ __('Role') }}</a>
                            </li>
                            @endcan
                            @can('manage member')
                            <li
                                class="dash-item {{ in_array(Request::segment(1), ['users', '']) || Request::route()->getName() == 'users.edit' ? ' active' : '' }}">
                                <a class="dash-link" href="{{ route('users.index') }}">{{ __('Member') }}</a>
                            </li>
                            @endcan
                            @can('manage group')
                            <li class="dash-item {{ in_array(Request::segment(1), ['groups', '']) ? ' active' : '' }}">
                                <a class="dash-link" href="{{ route('groups.index') }}">{{ __('Group') }}</a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                @endif

                @can('manage advocate')
                <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['advocate']) ? ' active' : '' }}">
                    <a href="{{ route('advocate.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="fa fa-tasks"></i></span>
                        <span class="dash-mtext">{{ __('Advocate') }}</span>
                    </a>
                </li>
                @endcan

                @can('manage case')
                    <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['cases']) ? ' active' : '' }}">
                        <a href="{{ route('cases.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-file-text"></i></span>
                            <span class="dash-mtext">{{ __('Cases') }}</span>
                        </a>
                    </li>
                @endcan

                @can('manage todo')
                <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['todo']) ? ' active' : '' }}">
                    <a href="{{ route('to-do.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-file-plus"></i></span>
                        <span class="dash-mtext">{{ __('To-Do') }}</span>
                    </a>
                </li>
                @endcan



                @can('manage diary')
                    <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['casediary']) || in_array(Request::segment(1), ['calendar']) ? ' active' : '' }}">
                        <a href="{{ route('casediary.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-license"></i></span>
                            <span class="dash-mtext">{{ __('My Case Diary') }}</span>
                        </a>
                    </li>
                @endcan


                @can('manage document')
                    <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['documents']) ? ' active' : '' }}">
                        <a href="{{ route('documents.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-files"></i></span>
                            <span class="dash-mtext">{{ __('Documents') }}</span>
                        </a>
                    </li>
                @endcan

                @can('manage bill')
                    <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['bills']) ? ' active' : '' }}">
                        <a href="{{ route('bills.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-file-analytics"></i></span>
                            <span class="dash-mtext">{{ __('Bill') }}</span>
                        </a>
                    </li>
                @endcan
                @can('manage cause')
                    <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['cause']) ? ' active' : '' }}">
                        <a href="{{ route('cause.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-clipboard-list"></i></span>
                            <span class="dash-mtext">{{ __('Cause List') }}</span>
                        </a>
                    </li>
                @endcan



                @can('manage timesheet')
                    <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['timesheet']) ? ' active' : '' }}">
                        <a href="{{ route('timesheet.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-list-check"></i></span>
                            <span class="dash-mtext">{{ __('Timesheet') }}</span>
                        </a>
                    </li>
                @endcan

                @can('manage expense')
                    <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['expenses']) ? ' active' : '' }}">
                        <a href="{{ route('expenses.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-report"></i></span>
                            <span class="dash-mtext">{{ __('Expense') }}</span>
                        </a>
                    </li>
                @endcan

                @can('manage feereceived')
                    <li class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['fee-receive']) ? ' active' : '' }}">
                        <a href="{{ route('fee-receive.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-receipt-2"></i></span>
                            <span class="dash-mtext">{{ __('Fee Received') }}</span>
                        </a>
                    </li>
                @endcan


                @if(\Auth::user()->type =='company' || \Auth::user()->type =='super admin')
                    <li class="dash-item {{ (Request::segment(1) == 'plans'|| Request::route()->getName() == 'payment')?'active':''}}">
                        <a class="dash-link" href="{{ route('plans.index') }}">
                            <span class="dash-micon"><i class="ti ti-trophy"></i></span><span class="dash-mtext">{{__('Plan')}}</span>
                        </a>
                    </li>
                @endif



                @if (Auth::user()->type != 'super admin')
                    <li class="dash-item dash-hasmenu">
                        <a href="#!" class="dash-link ">
                            <span class="dash-micon"><i class="fa fa-spinner"></i>
                            </span><span class="dash-mtext">{{ __('Constant') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="dash-submenu">
                            <li class="dash-item dash-hasmenu   dash-trigger">
                                <a class="dash-link" href="#">{{ __('Causes') }} <span class="dash-arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-chevron-right">
                                            <polyline points="9 18 15 12 9 6"></polyline>
                                        </svg></span></a>
                                <ul class="dash-submenu">
                                    @can('manage court')
                                        <li class="dash-item ">
                                            <a class="dash-link" href="{{ route('courts.index') }}"> {{ __('Court') }}</a>
                                        </li>
                                    @endcan
                                    @can('manage highcourt')
                                        <li class="dash-item ">
                                            <a class="dash-link" href="{{ route('highcourts.index') }}">
                                                {{ __('High Court') }}</a>
                                        </li>
                                    @endcan
                                    @can('manage bench')
                                        <li class="dash-item ">
                                            <a class="dash-link" href="{{ route('bench.index') }}"> {{ __('Bench') }}</a>
                                        </li>
                                    @endcan
                                </ul>

                            </li>

                            @can('manage tax')
                                <li class="dash-item ">
                                    <a class="dash-link" href="{{ route('taxs.index') }}">{{ __('Tax') }}</a>
                                </li>
                            @endcan

                            @can('manage doctype')
                                <li class="dash-item ">
                                    <a class="dash-link" href="{{ route('doctype.index') }}">{{ __('Document Type') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif



                @if(\Auth::user()->type=='super admin')
                    <li class="dash-item {{ request()->is('plan_request*') ? 'active' : '' }}">
                        <a href="{{ route('plan_request.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-git-pull-request"></i></span><span class="dash-mtext">{{__('Plan Request')}}</span>
                        </a>
                    </li>
                @endif

                @can('manage coupon')
                <li class="dash-item {{ (Request::segment(1) == 'coupons')?'active':''}}">
                    <a class="dash-link" href="{{ route('coupons.index') }}">
                        <span class="dash-micon"><i class="ti ti-gift"></i></span><span class="dash-mtext">{{__('Coupons')}}</span>
                    </a>
                </li>
                @endcan

                @can('manage order')
                    <li class="dash-item {{ (Request::segment(1) == 'orders')?'active':''}}">
                        <a class="dash-link" href="{{ route('order.index') }}">
                            <span class="dash-micon"><i class="ti ti-credit-card"></i></span><span class="dash-mtext">{{__('Order')}}</span>
                        </a>
                    </li>
                @endcan

                @can('manage setting')
                    <li
                        class="dash-item dash-hasmenu {{ in_array(Request::segment(1), ['app-setting']) ? ' active' : '' }}">
                        <a href="{{route('settings.index')}}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-settings"></i></span>
                            <span class="dash-mtext">{{ __('Setting') }}</span>
                        </a>
                    </li>
                @endcan

                @can('manage system settings')
                    <li class="dash-item {{ (Request::route()->getName() == 'admin.settings') ? ' active' : '' }}">
                        <a class="dash-link" href="{{ route('admin.settings') }}">
                            <span class="dash-micon"><i class="ti ti-settings"></i></span><span class="dash-mtext">{{__('System Settings')}}</span>
                        </a>
                    </li>
                @endcan

            </ul>
        </div>
    </div>
</nav>
<!-- [ navigation menu ] end -->
