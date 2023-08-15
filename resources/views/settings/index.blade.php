@extends('layouts.app')

@section('page-title', __('Settings'))


@section('breadcrumb')
    <li class="breadcrumb-item">{{ __('Settings') }}</li>
@endsection

@php
    use App\Models\Utility;
    $color = isset($settings['color']) ? $settings['color'] : 'theme-1';
    $logo = asset('storage/uploads/logo/');
    $logo_light = Utility::getValByName('company_logo_light');
    $logo_dark = Utility::getValByName('company_logo_dark');
    $company_favicon = Utility::getValByName('company_favicon');
    $lang = Utility::getValByName('default_language');
    $file_type = config('files_types');
    $setting = Utility::settings();
    $meta_image = Utility::get_file('uploads/metaevent/');

    $local_storage_validation = $setting['local_storage_validation'];
    $local_storage_validations = explode(',', $local_storage_validation);

    $s3_storage_validation = $setting['s3_storage_validation'];
    $s3_storage_validations = explode(',', $s3_storage_validation);

    $wasabi_storage_validation = $setting['wasabi_storage_validation'];
    $wasabi_storage_validations = explode(',', $wasabi_storage_validation);
@endphp



@section('content')

    <div class="row p-0 g-0">
        <div class="col-sm-12">
            <div class="row g-0">
                <div class="col-xl-3 border-end border-bottom ">
                    <div class="card shadow-none bg-transparent sticky-top" style="top:30px">
                        <div class="list-group list-group-flush rounded-0" id="useradd-sidenav">
                            <a href="#useradd-1"
                                class="list-group-item list-group-item-action border-0">{{ __('Brand Settings') }}
                                <div class="float-end dark"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#useradd-7"
                                class="list-group-item list-group-item-action border-0">{{ __('Payment Settings') }}
                                <div class="float-end "><i class="ti ti-chevron-right"></i></div>
                            </a>




                        </div>
                    </div>
                </div>

                <div class="col-xl-9" data-bs-spy="scroll" data-bs-target="#useradd-sidenav" data-bs-offset="0" tabindex="0">

                    <!--Business Setting-->
                    <div class="card shadow-none rounded-0 border" id="useradd-1">
                        {{ Form::model($settings, ['route' => 'settings.store', 'method' => 'POST', 'enctype' => 'multipart/form-data'])
                        }}
                        <div class="card-header">
                            <h5>{{ __('Brand Settings') }}</h5>
                            <small class="text-muted">{{ __('Edit your brand details') }}</small>
                        </div>

                        <div class="card-body pb-0  ">
                            <div class="row">
                                <div class="col-lg-4 col-sm-6 col-md-6 dashboard-card">
                                    <div class="card shadow-none border rounded-0">
                                        <div class="card-header">
                                            <h5>{{ __('Logo dark') }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class=" setting-card">
                                                <div class="d-flex flex-column justify-content-between align-items-center h-100">
                                                    <div class="logo-content mt-4">

                                                        <a href="{{ $logo .'/' . (isset($logo_dark) && !empty($logo_dark) ? $logo_dark : '/logo-dark.png') }}"
                                                            target="_blank">
                                                            <img class="img_setting" id="blah" alt="your image"
                                                                src="{{ $logo .'/'. (isset($logo_dark) && !empty($logo_dark) ? $logo_dark : '/logo-dark.png') }}"
                                                                width="200px" class="big-logo">
                                                        </a>
                                                    </div>
                                                    <div class="choose-files mt-5">
                                                        <label for="company_logo">
                                                            <div class=" bg-primary company_logo_update m-auto"> <i
                                                                    class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                            </div>
                                                            <input type="file" name="company_logo_dark" id="company_logo"
                                                                class="form-control file" data-filename="company_logo_update"
                                                                onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">

                                                        </label>
                                                    </div>
                                                    @error('company_logo')
                                                    <div class="row">
                                                        <span class="invalid-logo" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-md-6 dashboard-card">
                                    <div class="card shadow-none border rounded-0">
                                        <div class="card-header">
                                            <h5>{{ __('Logo Light') }}</h5>
                                        </div>
                                        <div class="card-body ">
                                            <div class=" setting-card">
                                                <div class="d-flex flex-column justify-content-between align-items-center h-100">
                                                    <div class="logo-content mt-4">

                                                        <a href="{{ $logo .'/'. (isset($logo_light) && !empty($logo_light) ? $logo_light : '/logo-light.png') }}"
                                                            target="_blank">
                                                            <img id="blah1" alt="your image"
                                                                src="{{ $logo .'/'. (isset($logo_light) && !empty($logo_light) ? $logo_light : '/logo-light.png') }}"
                                                                width="200px" class="big-logo img_setting">
                                                        </a>
                                                    </div>
                                                    <div class="choose-files mt-5">
                                                        <label for="company_logo_light">
                                                            <div class=" bg-primary dark_logo_update m-auto"> <i
                                                                    class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                            </div>
                                                            <input type="file" name="company_logo_light" id="company_logo_light"
                                                                class="form-control file" data-filename="dark_logo_update"
                                                                onchange="document.getElementById('blah1').src = window.URL.createObjectURL(this.files[0])">
                                                        </label>
                                                    </div>
                                                    @error('company_logo_light')
                                                    <div class="row">
                                                        <span class="invalid-logo" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-md-6 dashboard-card">
                                    <div class="card shadow-none border rounded-0">
                                        <div class="card-header">
                                            <h5>{{ __('Favicon') }}</h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class=" setting-card">
                                                <div class="d-flex flex-column justify-content-between align-items-center h-100">
                                                    <div class="logo-content mt-4">
                                                        <a href="{{ $logo .'/'. (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : '/favicon.png') }}"
                                                            target="_blank">
                                                            <img id="blah2" alt="your image"
                                                                src="{{ $logo .'/'. (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : '/favicon.png') }}"
                                                                width="80px" class="big-logo img_setting">
                                                        </a>
                                                    </div>
                                                    <div class="choose-files mt-4">
                                                        <label for="company_favicon">
                                                            <div class="bg-primary company_favicon_update m-auto"> <i
                                                                    class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                            </div>
                                                            <input type="file" name="company_favicon" id="company_favicon"
                                                                class="form-control file" data-filename="company_favicon_update"
                                                                onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])">
                                                        </label>
                                                    </div>
                                                    @error('logo')
                                                    <div class="row">
                                                        <span class="invalid-logo" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('title_text', __('Title Text'), ['class' => 'form-label']) }}
                                            {{ Form::text('title_text', Utility::getValByName('title_text'), ['class' => 'form-control',
                                            'placeholder' => __('Title Text')]) }}
                                            @error('title_text')
                                            <span class="invalid-title_text" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('footer_text', __('Footer Text'), ['class' => 'form-label']) }}
                                            {{ Form::text('footer_text', Utility::getValByName('footer_text'), ['class' =>
                                            'form-control', 'placeholder' => __('Enter Footer Text')]) }}
                                            @error('footer_text')
                                            <span class="invalid-footer_text" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            {{ Form::label('default_language', __('Default Language'), ['class' => 'form-label']) }}
                                            <div class="changeLanguage">

                                                <select name="default_language" id="default_language" class="form-control select">
                                                    @foreach (\App\Models\Utility::languages() as $language)
                                                    <option @if ($lang==$language) selected @endif value="{{ $language }}">{{
                                                        Str::upper($language) }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('default_language')
                                            <span class="invalid-default_language" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-4 my-auto">
                                                <div class="form-group">
                                                    <label class="text-dark mb-1 mt-3" for="SITE_RTL">{{ __('Enable RTL') }}</label>
                                                    <div class="">
                                                        <input type="checkbox" name="SITE_RTL" id="SITE_RTL" data-toggle="switchbutton"
                                                            {{ $settings['SITE_RTL']=='on' ? 'checked="checked"' : '' }}
                                                            data-onstyle="primary">
                                                        <label class="form-check-labe" for="SITE_RTL"></label>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <h4 class="small-title">{{ __('Theme Customizer') }}</h4>
                                <div class="setting-card setting-logo-box p-3">
                                    <div class="row">
                                        <div class="col-4 my-auto">
                                            <h6 class="mt-2">
                                                <i data-feather="credit-card" class="me-2"></i>{{ __('Primary color settings') }}
                                            </h6>
                                            <hr class="my-2" />

                                            <div class="theme-color themes-color">
                                                <a href="#!" class="{{ $settings['color'] == 'theme-1' ? 'active_color' : '' }}"
                                                    data-value="theme-1" onclick="check_theme('theme-1')"></a>
                                                <input type="radio" class="theme_color" name="color" value="theme-1"
                                                    style="display: none;">
                                                <a href="#!" class="{{ $settings['color'] == 'theme-2' ? 'active_color' : '' }} "
                                                    data-value="theme-2" onclick="check_theme('theme-2')"></a>
                                                <input type="radio" class="theme_color" name="color" value="theme-2"
                                                    style="display: none;">
                                                <a href="#!" class="{{ $settings['color'] == 'theme-3' ? 'active_color' : '' }}"
                                                    data-value="theme-3" onclick="check_theme('theme-3')"></a>
                                                <input type="radio" class="theme_color" name="color" value="theme-3"
                                                    style="display: none;">
                                                <a href="#!" class="{{ $settings['color'] == 'theme-4' ? 'active_color' : '' }}"
                                                    data-value="theme-4" onclick="check_theme('theme-4')"></a>
                                                <input type="radio" class="theme_color" name="color" value="theme-4"
                                                    style="display: none;">
                                                <a href="#!" class="{{ $settings['color'] == 'theme-5' ? 'active_color' : '' }}"
                                                    data-value="theme-5" onclick="check_theme('theme-5')"></a>
                                                <input type="radio" class="theme_color" name="color" value="theme-5"
                                                    style="display: none;">
                                                <br>
                                                <a href="#!" class="{{ $settings['color'] == 'theme-6' ? 'active_color' : '' }}"
                                                    data-value="theme-6" onclick="check_theme('theme-6')"></a>
                                                <input type="radio" class="theme_color" name="color" value="theme-6"
                                                    style="display: none;">
                                                <a href="#!" class="{{ $settings['color'] == 'theme-7' ? 'active_color' : '' }}"
                                                    data-value="theme-7" onclick="check_theme('theme-7')"></a>
                                                <input type="radio" class="theme_color" name="color" value="theme-7"
                                                    style="display: none;">
                                                <a href="#!" class="{{ $settings['color'] == 'theme-8' ? 'active_color' : '' }}"
                                                    data-value="theme-8" onclick="check_theme('theme-8')"></a>
                                                <input type="radio" class="theme_color" name="color" value="theme-8"
                                                    style="display: none;">
                                                <a href="#!" class="{{ $settings['color'] == 'theme-9' ? 'active_color' : '' }}"
                                                    data-value="theme-9" onclick="check_theme('theme-9')"></a>
                                                <input type="radio" class="theme_color" name="color" value="theme-9"
                                                    style="display: none;">
                                                <a href="#!" class="{{ $settings['color'] == 'theme-10' ? 'active_color' : '' }}"
                                                    data-value="theme-10" onclick="check_theme('theme-10')"></a>
                                                <input type="radio" class="theme_color" name="color" value="theme-10"
                                                    style="display: none;">
                                            </div>
                                        </div>
                                        <div class="col-4 ">
                                            <h6 class="mt-2">
                                                <i data-feather="layout" class="me-2"></i>{{ __('Sidebar settings') }}
                                            </h6>
                                            <hr class="my-2" />
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="site_transparent"
                                                    name="cust_theme_bg" {{ Utility::getValByName('cust_theme_bg')=='on' ? 'checked'
                                                    : '' }} />

                                                <label class="form-check-label f-w-600 pl-1" for="site_transparent">{{ __('Transparent layout') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-4 ">
                                            <h6 class="mt-2">
                                                <i data-feather="sun" class="me-2"></i>{{ __('Layout settings') }}
                                            </h6>
                                            <hr class="my-2" />
                                            <div class="form-check form-switch mt-2">
                                                <input type="checkbox" class="form-check-input" id="cust-darklayout"
                                                    name="cust_darklayout" {{ Utility::getValByName('cust_darklayout')=='on' ? 'checked'
                                                    : '' }} />
                                                <label class="form-check-label f-w-600 pl-1" for="cust-darklayout">{{ __('Dark Layout')
                                                    }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer text-end pb-0 pe-0">
                                    <div class="form-group">
                                        <input class="btn btn-print-invoice btn-primary m-r-10" type="submit"
                                            value="{{ __('Save Changes') }}">
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                    <!--Payment Setting-->
                    <div id="useradd-7" class="card shadow-none rounded-0 border">
                        <div class="card-header">
                            <h5>{{ __('Payment Settings') }}</h5>
                            <small class="text-muted">{{ __('These details will be used to collect invoice payments. Each invoice will have a payment button based on the below configuration.') }}</small>
                        </div>
                        <div class="card-body pb-0">

                            {{ Form::model($settings, ['route' => 'payment.settings', 'method' => 'POST']) }}

                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    {{ Form::label('site_currency', __('Currency *'), ['class' => 'form-label']) }}
                                    {{ Form::text('site_currency', isset($company_payment_setting['site_currency']) ?
                                    $company_payment_setting['site_currency'] : '', ['class' => 'form-control font-style']) }}
                                    @error('site_currency')
                                    <span class="invalid-site_currency" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{ Form::label('site_currency_symbol', __('Currency Symbol *'), ['class' => 'form-label']) }}
                                    {{ Form::text('site_currency_symbol', isset($company_payment_setting['site_currency_symbol']) ?
                                    $company_payment_setting['site_currency_symbol'] : '', ['class' => 'form-control']) }}
                                    @error('site_currency_symbol')
                                    <span class="invalid-site_currency_symbol" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="faq justify-content-center">
                                <div class="row">
                                    <div class="accordion accordion-flush setting-accordion" id="accordionExample">
                                        {{-- bank-transfer --}}
                                        <div class="accordion-item ">
                                            <h2 class="accordion-header" id="heading-2-16">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse16" aria-expanded="false" aria-controls="collapse16">
                                                    <span class="d-flex align-items-center">

                                                        {{ __('Bank Transfer') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2">{{ __('Enable') }}</span>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_bank_enabled" value="off">
                                                            <input type="checkbox" class="form-check-input input-primary"
                                                                name="is_bank_enabled" id="is_bank_enabled" {{
                                                                isset($company_payment_setting['is_bank_enabled']) &&
                                                                $company_payment_setting['is_bank_enabled']=='on' ? 'checked="checked"'
                                                                : '' }}>
                                                            <label class="form-check-label" for="customswitchv1-1"></label>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapse16" class="accordion-collapse collapse" aria-labelledby="heading-2-16"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row gy-4">
                                                        <div class="col-md-6 mt-3">
                                                            <div class="form-group">
                                                                {!! Form::label('inputname', __('Bank Details'), ['class' =>
                                                                'col-form-label']) !!}

                                                                @php
                                                                $bank_details = !empty($company_payment_setting['bank_details']) ?
                                                                $company_payment_setting['bank_details'] : '';
                                                                @endphp
                                                                {!! Form::textarea('bank_details', $bank_details, [
                                                                'class' => 'form-control',
                                                                'rows' => '6',
                                                                'required' => 'required',
                                                                ]) !!}
                                                                <small class="text-xs">
                                                                    {{ __('Example : Bank : Bank Name <br> Account Number : 0000 0000 <br>') }}.
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Strip -->
                                        <div class="accordion-item ">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                        <span class="d-flex align-items-center">
                                                            <i class=""></i>

                                                            {{ __('Stripe') }}
                                                        </span>

                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2"> {{ __('Enable') }} </span>
                                                            <div class="form-check form-switch custom-switch-v1">
                                                                <input type="hidden" name="is_stripe_enabled" value="off">
                                                                <input type="checkbox" class="form-check-input" name="is_stripe_enabled"
                                                                    id="is_stripe_enabled" {{
                                                                    isset($company_payment_setting['is_stripe_enabled']) &&
                                                                    $company_payment_setting['is_stripe_enabled']=='on'
                                                                    ? 'checked="checked"' : '' }}>

                                                            </div>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row gy-4">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="stripe_key" class="col-form-label">{{ __('Stripe Key')
                                                                        }}</label>
                                                                    <input class="form-control" placeholder="{{ __('Stripe Key') }}"
                                                                        name="stripe_key" type="text"
                                                                        value="{{ !isset($company_payment_setting['stripe_key']) || is_null($company_payment_setting['stripe_key']) ? '' : $company_payment_setting['stripe_key'] }}"
                                                                        id="stripe_key">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="stripe_secret" class="col-form-label">{{ __('Stripe Secret') }}</label>
                                                                    <input class="form-control " placeholder="{{ __('Stripe Secret') }}"
                                                                        name="stripe_secret" type="text"
                                                                        value="{{ !isset($company_payment_setting['stripe_secret']) || is_null($company_payment_setting['stripe_secret']) ? '' : $company_payment_setting['stripe_secret'] }}"
                                                                        id="stripe_secret">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Paypal -->
                                        <div class="accordion-item ">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne2 " aria-expanded="false"
                                                        aria-controls="collapseOne2">
                                                        <span class="d-flex align-items-center">
                                                            <i class=""></i>
                                                            {{ __('Paypal') }}
                                                        </span>

                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">{{ __('Enable') }}</span>
                                                            <div class="form-check form-switch custom-switch-v1">
                                                                <input type="hidden" name="is_paypal_enabled" value="off">
                                                                <input type="checkbox" class="form-check-input" name="is_paypal_enabled"
                                                                    id="is_paypal_enabled" {{
                                                                    isset($company_payment_setting['is_paypal_enabled']) &&
                                                                    $company_payment_setting['is_paypal_enabled']=='on'
                                                                    ? 'checked="checked"' : '' }}>

                                                            </div>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapseOne2" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row gy-4">
                                                            <div class="col-md-12">
                                                                <label class="paypal-label col-form-label" for="paypal_mode">{{
                                                                    __('Paypal Mode') }}</label> <br>
                                                                <div class="d-flex">
                                                                    <div class="mr-2" style="margin-right: 15px;">
                                                                        <div class="border card p-3">
                                                                            <div class="form-check">
                                                                                <label
                                                                                    class="form-check-labe text-dark {{ isset($company_payment_setting['paypal_mode']) && $company_payment_setting['paypal_mode'] == 'sandbox' ? 'active' : '' }}">
                                                                                    <input type="radio" name="paypal_mode"
                                                                                        value="sandbox" class="form-check-input" {{
                                                                                        isset($company_payment_setting['paypal_mode'])
                                                                                        &&
                                                                                        $company_payment_setting['paypal_mode']=='sandbox'
                                                                                        ? 'checked="checked"' : '' }}>

                                                                                    {{ __('Sandbox') }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mr-2">
                                                                        <div class="border card p-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-labe text-dark">
                                                                                    <input type="radio" name="paypal_mode" value="live"
                                                                                        class="form-check-input" {{
                                                                                        isset($company_payment_setting['paypal_mode'])
                                                                                        &&
                                                                                        $company_payment_setting['paypal_mode']=='live'
                                                                                        ? 'checked="checked"' : '' }}>

                                                                                    {{ __('Live') }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="paypal_client_id" class="col-form-label">{{ __('Client ID') }}</label>
                                                                    <input type="text" name="paypal_client_id" id="paypal_client_id"
                                                                        class="form-control"
                                                                        value="{{ !isset($company_payment_setting['paypal_client_id']) || is_null($company_payment_setting['paypal_client_id']) ? '' : $company_payment_setting['paypal_client_id'] }}"
                                                                        placeholder="{{ __('Client ID') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="paypal_secret_key" class="col-form-label">{{ __('Secret Key') }}</label>
                                                                    <input type="text" name="paypal_secret_key" id="paypal_secret_key"
                                                                        class="form-control"
                                                                        value="{{ !isset($company_payment_setting['paypal_secret_key']) || is_null($company_payment_setting['paypal_secret_key']) ? '' : $company_payment_setting['paypal_secret_key'] }}"
                                                                        placeholder="{{ __('Secret Key') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Paystack -->
                                        <div class="accordion-item ">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne3" aria-expanded="false"
                                                        aria-controls="collapseOne3">
                                                        <span class="d-flex align-items-center">
                                                            <i class=""></i>

                                                            {{ __('Paystack') }}
                                                        </span>

                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">{{ __('Enable') }}</span>
                                                            <div class="form-check form-switch custom-switch-v1">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="is_paystack_enabled" id="is_paystack_enabled" {{
                                                                    isset($company_payment_setting['is_paystack_enabled']) &&
                                                                    $company_payment_setting['is_paystack_enabled']=='on' ? 'checked'
                                                                    : '' }}>

                                                            </div>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapseOne3" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row gy-4">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="paypal_client_id" class="col-form-label">{{ __('Public Key') }}</label>
                                                                    <input type="text" name="paystack_public_key"
                                                                        id="paystack_public_key" class="form-control"
                                                                        value="{{ !isset($company_payment_setting['paystack_public_key']) || is_null($company_payment_setting['paystack_public_key']) ? '' : $company_payment_setting['paystack_public_key'] }}"
                                                                        placeholder="{{ __('Public Key') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="paystack_secret_key" class="col-form-label">{{ __('Secret Key') }}</label>
                                                                    <input type="text" name="paystack_secret_key"
                                                                        id="paystack_secret_key" class="form-control"
                                                                        value="{{ !isset($company_payment_setting['paystack_secret_key']) || is_null($company_payment_setting['paystack_secret_key']) ? '' : $company_payment_setting['paystack_secret_key'] }}"
                                                                        placeholder="{{ __('Secret Key') }}">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- FLUTTERWAVE -->
                                        <div class="accordion-item ">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne4" aria-expanded="false"
                                                        aria-controls="collapseOne4">
                                                        <span class="d-flex align-items-center">
                                                            <i class=""></i>

                                                            {{ __('Flutterware') }}
                                                        </span>

                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">{{ __('Enable') }}</span>
                                                            <div class="form-check form-switch custom-switch-v1">
                                                                <input type="hidden" name="is_flutterwave_enabled" value="off">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="is_flutterwave_enabled" id="is_flutterwave_enabled" {{
                                                                    isset($company_payment_setting['is_flutterwave_enabled']) &&
                                                                    $company_payment_setting['is_flutterwave_enabled']=='on' ? 'checked'
                                                                    : '' }}>

                                                            </div>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapseOne4" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row gy-4">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="paypal_client_id" class="col-form-label">{{ __('Public Key') }}</label>
                                                                    <input type="text" name="flutterwave_public_key"
                                                                        id="flutterwave_public_key" class="form-control"
                                                                        value="{{ !isset($company_payment_setting['flutterwave_public_key']) || is_null($company_payment_setting['flutterwave_public_key']) ? '' : $company_payment_setting['flutterwave_public_key'] }}"
                                                                        placeholder="{{ __('Public Key') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="paystack_secret_key" class="col-form-label">{{ __('Secret Key') }}</label>
                                                                    <input type="text" name="flutterwave_secret_key"
                                                                        id="flutterwave_secret_key" class="form-control"
                                                                        value="{{ !isset($company_payment_setting['flutterwave_secret_key']) || is_null($company_payment_setting['flutterwave_secret_key']) ? '' : $company_payment_setting['flutterwave_secret_key'] }}"
                                                                        placeholder="{{ __('Secret Key') }}">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Razorpay -->
                                        <div class="accordion-item ">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne5" aria-expanded="false"
                                                        aria-controls="collapseOne5">
                                                        <span class="d-flex align-items-center">
                                                            <i class=""></i>

                                                            {{ __('Razorpay') }}
                                                        </span>

                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">{{ __('Enable') }}</span>
                                                            <div class="form-check form-switch custom-switch-v1">
                                                                <input type="hidden" name="is_razorpay_enabled" value="off">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="is_razorpay_enabled" id="is_razorpay_enabled" {{
                                                                    isset($company_payment_setting['is_razorpay_enabled']) &&
                                                                    $company_payment_setting['is_razorpay_enabled']=='on'
                                                                    ? 'checked="checked"' : '' }}>

                                                            </div>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapseOne5" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row gy-4">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="paypal_client_id" class="col-form-label">{{ __('Public Key') }}</label>

                                                                    <input type="text" name="razorpay_public_key"
                                                                        id="razorpay_public_key" class="form-control"
                                                                        value="{{ !isset($company_payment_setting['razorpay_public_key']) || is_null($company_payment_setting['razorpay_public_key']) ? '' : $company_payment_setting['razorpay_public_key'] }}"
                                                                        placeholder="{{ __('Public Key') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="paystack_secret_key" class="col-form-label">{{ __('Secret Key') }}</label>
                                                                    <input type="text" name="razorpay_secret_key"
                                                                        id="razorpay_secret_key" class="form-control"
                                                                        value="{{ !isset($company_payment_setting['razorpay_secret_key']) || is_null($company_payment_setting['razorpay_secret_key']) ? '' : $company_payment_setting['razorpay_secret_key'] }}"
                                                                        placeholder="{{ __('Secret Key') }}">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Mercado Pago -->
                                        <div class="accordion-item ">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne6" aria-expanded="false"
                                                        aria-controls="collapseOne6">
                                                        <span class="d-flex align-items-center">
                                                            <i class=""></i>
                                                            {{ __('Mercado Pago') }}
                                                        </span>

                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">{{ __('Enable') }}</span>
                                                            <div class="form-check form-switch custom-switch-v1">
                                                                <input type="hidden" name="is_mercado_enabled" value="off">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="is_mercado_enabled" id="is_mercado_enabled" {{
                                                                    isset($company_payment_setting['is_mercado_enabled']) &&
                                                                    $company_payment_setting['is_mercado_enabled']=='on' ? 'checked'
                                                                    : '' }}>

                                                            </div>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapseOne6" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row gy-4">
                                                            <div class="col-md-12 ">
                                                                <label class="coingate-label col-form-label" for="mercado_mode">{{
                                                                    __('Mercado Mode') }}</label> <br>
                                                                <div class="d-flex">
                                                                    <div class="mr-2" style="margin-right: 15px;">
                                                                        <div class="border card p-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-labe text-dark">
                                                                                    <input type="radio" name="mercado_mode"
                                                                                        value="sandbox" class="form-check-input" {{
                                                                                        (isset($company_payment_setting['mercado_mode'])
                                                                                        && $company_payment_setting['mercado_mode']==''
                                                                                        ) ||
                                                                                        (isset($company_payment_setting['mercado_mode'])
                                                                                        &&
                                                                                        $company_payment_setting['mercado_mode']=='sandbox'
                                                                                        ) ? 'checked="checked"' : '' }}>
                                                                                    {{ __('Sandbox') }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mr-2">
                                                                        <div class="border card p-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-labe text-dark">
                                                                                    <input type="radio" name="mercado_mode" value="live"
                                                                                        class="form-check-input" {{
                                                                                        isset($company_payment_setting['mercado_mode'])
                                                                                        &&
                                                                                        $company_payment_setting['mercado_mode']=='live'
                                                                                        ? 'checked="checked"' : '' }}>
                                                                                    {{ __('Live') }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="mercado_access_token" class="col-form-label">{{
                                                                        __('Access Token') }}</label>
                                                                    <input type="text" name="mercado_access_token"
                                                                        id="mercado_access_token" class="form-control"
                                                                        value="{{ isset($company_payment_setting['mercado_access_token']) ? $company_payment_setting['mercado_access_token'] : '' }}"
                                                                        placeholder="{{ __('Access Token') }}" />
                                                                    @if ($errors->has('mercado_secret_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('mercado_access_token') }}
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Paytm -->
                                        <div class="accordion-item ">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne7" aria-expanded="false"
                                                        aria-controls="collapseOne7">
                                                        <span class="d-flex align-items-center">
                                                            <i class=""></i>
                                                            {{ __('Paytm') }}
                                                        </span>

                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">{{ __('Enable') }}</span>
                                                            <div class="form-check form-switch custom-switch-v1">
                                                                <input type="hidden" name="is_paytm_enabled" value="off">
                                                                <input type="checkbox" class="form-check-input" name="is_paytm_enabled"
                                                                    id="is_paytm_enabled" {{
                                                                    isset($company_payment_setting['is_paytm_enabled']) &&
                                                                    $company_payment_setting['is_paytm_enabled']=='on'
                                                                    ? 'checked="checked"' : '' }}>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapseOne7" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row gy-4">
                                                            <div class="col-md-12">
                                                                <label class="paypal-label col-form-label" for="paypal_mode">{{
                                                                    __('Paytm Environment') }}</label>
                                                                <br>
                                                                <div class="d-flex">
                                                                    <div class="mr-2" style="margin-right: 15px;">
                                                                        <div class="border card p-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-labe text-dark">

                                                                                    <input type="radio" name="paytm_mode" value="local"
                                                                                        class="form-check-input" {{
                                                                                        !isset($company_payment_setting['paytm_mode'])
                                                                                        || $company_payment_setting['paytm_mode']=='' ||
                                                                                        $company_payment_setting['paytm_mode']=='local'
                                                                                        ? 'checked="checked"' : '' }}>

                                                                                    {{ __('Local') }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mr-2">
                                                                        <div class="border card p-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-labe text-dark">
                                                                                    <input type="radio" name="paytm_mode"
                                                                                        value="production" class="form-check-input" {{
                                                                                        isset($company_payment_setting['paytm_mode']) &&
                                                                                        $company_payment_setting['paytm_mode']=='production'
                                                                                        ? 'checked="checked"' : '' }}>

                                                                                    {{ __('Production') }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="paytm_public_key" class="col-form-label">{{ __('Merchant ID') }}</label>
                                                                    <input type="text" name="paytm_merchant_id" id="paytm_merchant_id"
                                                                        class="form-control"
                                                                        value="{{ !isset($company_payment_setting['paytm_merchant_id']) || is_null($company_payment_setting['paytm_merchant_id']) ? '' : $company_payment_setting['paytm_merchant_id'] }}"
                                                                        placeholder="{{ __('Merchant ID') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="paytm_secret_key" class="col-form-label">{{ __('Merchant Key') }}</label>
                                                                    <input type="text" name="paytm_merchant_key" id="paytm_merchant_key"
                                                                        class="form-control"
                                                                        value="{{ !isset($company_payment_setting['paytm_merchant_key']) || is_null($company_payment_setting['paytm_merchant_key']) ? '' : $company_payment_setting['paytm_merchant_key'] }}"
                                                                        placeholder="{{ __('Merchant Key') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="paytm_industry_type" class="col-form-label">{{
                                                                        __('Industry Type') }}</label>
                                                                    <input type="text" name="paytm_industry_type"
                                                                        id="paytm_industry_type" class="form-control"
                                                                        value="{{ !isset($company_payment_setting['paytm_industry_type']) || is_null($company_payment_setting['paytm_industry_type']) ? '' : $company_payment_setting['paytm_industry_type'] }}"
                                                                        placeholder="Industry Type">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Mollie -->
                                        <div class="accordion-item ">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne8" aria-expanded="false"
                                                        aria-controls="collapseOne8">
                                                        <span class="d-flex align-items-center">
                                                            <i class=""></i>
                                                            {{ __('Mollie') }}
                                                        </span>

                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">{{ __('Enable') }}</span>
                                                            <div class="form-check form-switch custom-switch-v1">
                                                                <input type="hidden" name="is_mollie_enabled" value="off">
                                                                <input type="checkbox" class="form-check-input" name="is_mollie_enabled"
                                                                    id="is_mollie_enabled" {{
                                                                    isset($company_payment_setting['is_mollie_enabled']) &&
                                                                    $company_payment_setting['is_mollie_enabled']=='on' ? 'checked' : ''
                                                                    }}>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapseOne8" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row gy-4">

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="mollie_api_key" class="col-form-label">{{ __('Mollie Api Key') }}</label>
                                                                    <input type="text" name="mollie_api_key" id="mollie_api_key"
                                                                        class="form-control"
                                                                        value="{{ !isset($company_payment_setting['mollie_api_key']) || is_null($company_payment_setting['mollie_api_key']) ? '' : $company_payment_setting['mollie_api_key'] }}"
                                                                        placeholder="{{ __('Mollie Api Key') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="mollie_profile_id" class="col-form-label">{{ __('Mollie Profile ID') }}</label>
                                                                    <input type="text" name="mollie_profile_id" id="mollie_profile_id"
                                                                        class="form-control"
                                                                        value="{{ !isset($company_payment_setting['mollie_profile_id']) || is_null($company_payment_setting['mollie_profile_id']) ? '' : $company_payment_setting['mollie_profile_id'] }}"
                                                                        placeholder="{{ __('Mollie Profile ID') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="mollie_partner_id" class="col-form-label">{{ __('Mollie Partner ID') }}</label>
                                                                    <input type="text" name="mollie_partner_id" id="mollie_partner_id"
                                                                        class="form-control"
                                                                        value="{{ !isset($company_payment_setting['mollie_partner_id']) || is_null($company_payment_setting['mollie_partner_id']) ? '' : $company_payment_setting['mollie_partner_id'] }}"
                                                                        placeholder="{{ __('Mollie Partner Id') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Skrill -->
                                        <div class="accordion-item ">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne9" aria-expanded="false"
                                                        aria-controls="collapseOne9">
                                                        <span class="d-flex align-items-center">
                                                            <i class=""></i>

                                                            {{ __('Skrill') }}
                                                        </span>

                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">{{ __('Enable') }}</span>
                                                            <div class="form-check form-switch custom-switch-v1">
                                                                <input type="hidden" name="is_skrill_enabled" value="off">
                                                                <input type="checkbox" class="form-check-input" name="is_skrill_enabled"
                                                                    id="is_skrill_enabled" {{
                                                                    isset($company_payment_setting['is_skrill_enabled']) &&
                                                                    $company_payment_setting['is_skrill_enabled']=='on' ? 'checked' : ''
                                                                    }}>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapseOne9" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row gy-4">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="mollie_api_key" class="col-form-label">{{ __('Skrill Email') }}</label>
                                                                    <input type="text" name="skrill_email" id="skrill_email"
                                                                        class="form-control"
                                                                        value="{{ !isset($company_payment_setting['skrill_email']) || is_null($company_payment_setting['skrill_email']) ? '' : $company_payment_setting['skrill_email'] }}"
                                                                        placeholder="{{ __('Enter Skrill Email') }}">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- CoinGate -->
                                        <div class="accordion-item ">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne10" aria-expanded="false"
                                                        aria-controls="collapseOne10">
                                                        <span class="d-flex align-items-center">
                                                            <i class=""></i>
                                                            {{ __('CoinGate') }}
                                                        </span>

                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">{{ __('Enable') }}</span>
                                                            <div class="form-check form-switch custom-switch-v1">
                                                                <input type="hidden" name="is_coingate_enabled" value="off">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="is_coingate_enabled" id="is_coingate_enabled" {{
                                                                    isset($company_payment_setting['is_coingate_enabled']) &&
                                                                    $company_payment_setting['is_coingate_enabled']=='on' ? 'checked'
                                                                    : '' }}>

                                                            </div>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapseOne10" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row gy-4">
                                                            <div class="col-md-12">
                                                                <label class="col-form-label" for="coingate_mode">{{ __('CoinGate Mode')
                                                                    }}</label>
                                                                <br>
                                                                <div class="d-flex">
                                                                    <div class="mr-2" style="margin-right: 15px;">
                                                                        <div class="border card p-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-labe text-dark">

                                                                                    <input type="radio" name="coingate_mode"
                                                                                        value="sandbox" class="form-check-input" {{
                                                                                        !isset($company_payment_setting['coingate_mode'])
                                                                                        || $company_payment_setting['coingate_mode']==''
                                                                                        ||
                                                                                        $company_payment_setting['coingate_mode']=='sandbox'
                                                                                        ? 'checked="checked"' : '' }}>

                                                                                    {{ __('Sandbox') }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mr-2">
                                                                        <div class="border card p-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-labe text-dark">
                                                                                    <input type="radio" name="coingate_mode"
                                                                                        value="live" class="form-check-input" {{
                                                                                        isset($company_payment_setting['coingate_mode'])
                                                                                        &&
                                                                                        $company_payment_setting['coingate_mode']=='live'
                                                                                        ? 'checked="checked"' : '' }}>
                                                                                    {{ __('Live') }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="coingate_auth_token" class="col-form-label">{{ __('CoinGate Auth Token') }}</label>
                                                                    <input type="text" name="coingate_auth_token"
                                                                        id="coingate_auth_token" class="form-control"
                                                                        value="{{ !isset($company_payment_setting['coingate_auth_token']) || is_null($company_payment_setting['coingate_auth_token']) ? '' : $company_payment_setting['coingate_auth_token'] }}"
                                                                        placeholder="{{ __('CoinGate Auth Token') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- PaymentWall -->
                                        <div class="accordion-item ">
                                            <h2 class="accordion-header" id="heading11">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                                                    <span class="d-flex align-items-center">
                                                        <i class=""></i> {{
                                                        __('PaymentWall') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2">{{ __('Enable') }}</span>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_paymentwall_enabled" value="off">
                                                            <input type="checkbox" class="form-check-input input-primary"
                                                                name="is_paymentwall_enabled" id="is_paymentwall_enabled" {{
                                                                isset($company_payment_setting['is_paymentwall_enabled']) &&
                                                                $company_payment_setting['is_paymentwall_enabled']=='on'
                                                                ? 'checked="checked"' : '' }}>
                                                            <label class="form-check-label" for="customswitchv1-2"></label>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapse11" class="accordion-collapse collapse" aria-labelledby="heading11"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="paymentwall_public_key" class="col-form-label">{{ __('Public Key')}}</label>
                                                                <input type="text" name="paymentwall_public_key"
                                                                    id="paymentwall_public_key" class="form-control"
                                                                    value="{{(!isset($company_payment_setting['paymentwall_public_key']) || is_null($company_payment_setting['paymentwall_public_key'])) ? '' : $company_payment_setting['paymentwall_public_key']}}"
                                                                    placeholder="{{ __('Public Key')}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="paymentwall_private_key" class="col-form-label">{{
                                                                    __('Private Key')
                                                                    }}</label>
                                                                <input type="text" name="paymentwall_private_key"
                                                                    id="paymentwall_private_key" class="form-control"
                                                                    value="{{(!isset($company_payment_setting['paymentwall_private_key']) || is_null($company_payment_setting['paymentwall_private_key'])) ? '' : $company_payment_setting['paymentwall_private_key']}}"
                                                                    placeholder="{{ __('Private Key') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- toyyibpay -->
                                        <div class="accordion-item ">
                                            <h2 class="accordion-header" id="heading12">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                                                    <span class="d-flex align-items-center">
                                                        <i class=""></i> {{
                                                        __('Toyyibpay') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2">{{ __('Enable') }}</span>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_toyyibpay_enabled" value="off">
                                                            <input type="checkbox" class="form-check-input input-primary"
                                                                name="is_toyyibpay_enabled" id="is_toyyibpay_enabled" {{
                                                                isset($company_payment_setting['is_toyyibpay_enabled']) &&
                                                                $company_payment_setting['is_toyyibpay_enabled']=='on'
                                                                ? 'checked="checked"' : '' }}>
                                                            <label class="form-check-label" for="customswitchv1-2"></label>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapse12" class="accordion-collapse collapse" aria-labelledby="heading12"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="paymentwall_public_key" class="col-form-label">{{ __('Secret Key')}}</label>
                                                                <input type="text" name="toyyibpay_secret_key" id="toyyibpay_secret_key"
                                                                    class="form-control"
                                                                    value="{{ !isset($company_payment_setting['toyyibpay_secret_key']) || is_null($company_payment_setting['toyyibpay_secret_key']) ? '' : $company_payment_setting['toyyibpay_secret_key'] }}"
                                                                    placeholder="{{ __('Secret Key') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="paymentwall_private_key" class="col-form-label">{{ __('Category Code') }}</label>
                                                                <input type="text" name="category_code" id="category_code"
                                                                    class="form-control"
                                                                    value="{{ !isset($company_payment_setting['category_code']) || is_null($company_payment_setting['category_code']) ? '' : $company_payment_setting['category_code'] }}"
                                                                    placeholder="{{ __('Category Code') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- PayFast --}}
                                        <div class="accordion-item ">
                                            <h2 class="accordion-header" id="heading-2-14">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse14" aria-expanded="true" aria-controls="collapse14">
                                                    <span class="d-flex align-items-center">

                                                        {{ __('Payfast') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2">{{__('Enable')}}</span>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_payfast_enabled" value="off">
                                                            <input type="checkbox" class="form-check-input input-primary"
                                                                name="is_payfast_enabled" id="is_payfast_enabled" {{
                                                                isset($company_payment_setting['is_payfast_enabled']) &&
                                                                $company_payment_setting['is_payfast_enabled']=='on'
                                                                ? 'checked="checked"' : '' }}>
                                                            <label class="form-check-label" for="customswitchv1-2"></label>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>

                                            <div id="collapse14" class="accordion-collapse collapse" aria-labelledby="heading-2-14"
                                                data-bs-parent="#accordionExample">

                                                <div class="accordion-body">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                        <div class="col-md-12 mb-2">
                                                            <label class="col-form-label" for="payfast_mode">{{ __('Payfast Mode')
                                                                }}</label>
                                                            <br>
                                                            <div class="d-flex">
                                                                <div class="mr-2" style="margin-right: 15px;">
                                                                    <div class="border card p-3">
                                                                        <div class="form-check">
                                                                            <label class="form-check-labe text-dark">

                                                                                <input type="radio" name="payfast_mode" value="sandbox"
                                                                                    class="form-check-input" {{
                                                                                    !isset($company_payment_setting['payfast_mode']) ||
                                                                                    $company_payment_setting['payfast_mode']=='' ||
                                                                                    $company_payment_setting['payfast_mode']=='sandbox'
                                                                                    ? 'checked="checked"' : '' }}>

                                                                                {{ __('Sandbox') }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mr-2">
                                                                    <div class="border card p-3">
                                                                        <div class="form-check">
                                                                            <label class="form-check-labe text-dark">
                                                                                <input type="radio" name="payfast_mode" value="live"
                                                                                    class="form-check-input" {{
                                                                                    isset($company_payment_setting['payfast_mode']) &&
                                                                                    $company_payment_setting['payfast_mode']=='live'
                                                                                    ? 'checked="checked"' : '' }}>
                                                                                {{ __('Live') }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="payfast_merchant_id" class="form-label">{{ __('Merchant Id') }}</label>
                                                                    <input type="text" name="payfast_merchant_id"
                                                                        id="payfast_merchant_id" class="form-control"
                                                                        value="{{ !isset($company_payment_setting['payfast_merchant_id']) || is_null($company_payment_setting['payfast_merchant_id']) ? '' : $company_payment_setting['payfast_merchant_id'] }}"
                                                                        placeholder="{{ __('Merchant Id') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="payfast_merchant_key" class="form-label">{{ __('Merchant Key') }}</label>
                                                                    <input type="text" name="payfast_merchant_key"
                                                                        id="payfast_merchant_key" class="form-control"
                                                                        value="{{ !isset($company_payment_setting['payfast_merchant_key']) || is_null($company_payment_setting['payfast_merchant_key']) ? '' : $company_payment_setting['payfast_merchant_key'] }}"
                                                                        placeholder="{{ __('Merchant Key') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="payfast_signature" class="form-label">{{ __('Salt Passphrase') }}</label>
                                                                    <input type="text" name="payfast_signature" id="payfast_signature"
                                                                        class="form-control"
                                                                        value="{{ !isset($company_payment_setting['payfast_signature']) || is_null($company_payment_setting['payfast_signature']) ? '' : $company_payment_setting['payfast_signature'] }}"
                                                                        placeholder="{{ __('Salt Passphrase') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer text-end pb-0 pe-0">
                                    <div class="form-group">
                                        <input class="btn btn-print-invoice  btn-primary" type="submit"
                                            value="{{ __('Save Changes') }}">
                                    </div>
                                </div>
                                </form>
                            </div>


                        </div>
                        <!-- [ Main Content ] end -->
                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection



@push('custom-script')
<script>
    var scrollSpy = new bootstrap.ScrollSpy(document.body, {
        target: '#useradd-sidenav',
        offset: 300
    })

    $(document).ready(function() {

        if ($('#site_transparent').length > 0) {
            var custthemebg = document.querySelector("#site_transparent");
            custthemebg.addEventListener("click", function() {
                if (custthemebg.checked) {
                    document.querySelector(".dash-sidebar").classList.add("transprent-bg");
                    document
                        .querySelector(".dash-header:not(.dash-mob-header)")
                        .classList.add("transprent-bg");
                } else {
                    document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
                    document
                        .querySelector(".dash-header:not(.dash-mob-header)")
                        .classList.remove("transprent-bg");
                }
            });
        }

        if ($('#cust-darklayout').length > 0) {
            var custthemedark = document.querySelector("#cust-darklayout");
            custthemedark.addEventListener("click", function() {

                if (custthemedark.checked) {
                    $('#style').attr('href', '{{ env('APP_URL') }}' +
                        '/public/assets/css/style-dark.css');
                    $('#custom-dark').attr('href', '{{ env('APP_URL') }}' +
                        '/public/assets/css/custom-dark.css');
                    $('.dash-sidebar .main-logo a img').attr('src', '{{ $logo . $logo_light }}');

                } else {
                    $('#style').attr('href', '{{ env('APP_URL') }}' + '/public/assets/css/style.css');
                    $('.dash-sidebar .main-logo a img').attr('src', '{{ $logo . $logo_dark }}');
                    $('#custom-dark').attr('href', '');

                }
            });
        }
    })

    $(document).on("click", '.send_email', function(e) {

        e.preventDefault();
        var title = $(this).attr('data-title');

        var size = 'md';
        var url = $(this).attr('data-url');

        if (typeof url != 'undefined') {
            $("#commanModel .modal-title").html(title);
            $("#commanModel .modal-dialog").addClass('modal-' + size);
            $("#commanModel").modal('show');

            $.post(url, {
                _token: '{{ csrf_token() }}',
                mail_driver: $("#mail_driver").val(),
                mail_host: $("#mail_host").val(),
                mail_port: $("#mail_port").val(),
                mail_username: $("#mail_username").val(),
                mail_password: $("#mail_password").val(),
                mail_encryption: $("#mail_encryption").val(),
                mail_from_address: $("#mail_from_address").val(),
                mail_from_name: $("#mail_from_name").val(),
            }, function(data) {
                $('#commanModel .modal-body').html(data);
            });
        }
    });


    $(document).on('submit', '#test_email', function(e) {
        e.preventDefault();
        $("#email_sending").show();
        var post = $(this).serialize();
        var url = $(this).attr('action');
        $.ajax({
            type: "post",
            url: url,
            data: post,
            cache: false,
            beforeSend: function() {
                $('#test_email .btn-create').attr('disabled', 'disabled');
            },
            success: function(data) {
                if (data.is_success) {
                    show_toastr('success', data.message, 'success');
                } else {
                    show_toastr('Error', data.message, 'error');
                }
                $("#email_sending").hide();
            },
            complete: function() {
                $('#test_email .btn-create').removeAttr('disabled');
            },
        });
    });

    $(document).ready(function(){
        $(".list-group-item").first().addClass('active');

        $(".list-group-item").on('click',function() {
            $(".list-group-item").removeClass('active')
            $(this).addClass('active');
        });
    })

    function check_theme(color_val) {
        $('#theme_color').prop('checked', false);
        $('input[value="' + color_val + '"]').prop('checked', true);
    }

    $(document).on('change', '[name=storage_setting]', function() {
        if ($(this).val() == 's3') {
            $('.s3-setting').removeClass('d-none');
            $('.wasabi-setting').addClass('d-none');
            $('.local-setting').addClass('d-none');
        } else if ($(this).val() == 'wasabi') {
            $('.s3-setting').addClass('d-none');
            $('.wasabi-setting').removeClass('d-none');
            $('.local-setting').addClass('d-none');
        } else {
            $('.s3-setting').addClass('d-none');
            $('.wasabi-setting').addClass('d-none');
            $('.local-setting').removeClass('d-none');
        }
    });



    function enablecookie() {
        const element = $('#enable_cookie').is(':checked');
        $('.cookieDiv').addClass('disabledCookie');
        if (element == true) {
            $('.cookieDiv').removeClass('disabledCookie');
            $("#cookie_logging").attr('checked', true);
        } else {
            $('.cookieDiv').addClass('disabledCookie');
            $("#cookie_logging").attr('checked', false);
        }
    }
</script>
@endpush
