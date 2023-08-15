@extends('layouts.app')
@if($user->id == Auth::user()->id)
    @section('page-title', __('Profile'))
@else
    @section('page-title', __('Edit Member'))
@endif


@php
    $logo = asset('storage/uploads/profile/');
@endphp
@section('breadcrumb')
@if($user->id == Auth::user()->id)
    <li class="breadcrumb-item">{{ __('Profile') }}</li>
@else
    <li class="breadcrumb-item">{{ __('Edit Member') }}</li>
@endif
@endsection

@section('content')
    <div class="row p-0 g-0">

        <div class="col-sm-12">
            <div class="row g-0">
                <div class="col-xl-3 border-end border-bottom">
                    <div class="card shadow-none bg-transparent sticky-top" style="top:70px">
                        <div class="list-group list-group-flush rounded-0" id="useradd-sidenav">
                            <a href="#useradd-1"
                                class="list-group-item list-group-item-action">{{ __('Information') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            @if($user->id == Auth::user()->id)
                            <a href="#useradd-2"
                                class="list-group-item list-group-item-action">{{ __('Change Password') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            @endif

                        </div>
                    </div>
                </div>


                <div class="col-xl-9">
                    <div id="useradd-1" class="card  shadow-none rounded-0 border-bottom">

                            <div class="card-header">
                                @if (Auth::user()->id == 1)
                                    <h5 class="mb-0">{{ __('Personal Information') }}</h5>
                                @else
                                    <h5 class="mb-0">{{ __('Member Information') }}</h5>

                                @endif
                            </div>
                            <div class="card-body">

                                {{ Form::model($user, ['route' => ['users.update',$user->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                                <div class=" setting-card">
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-6 col-md-6">
                                            <div class="card-body text-center">
                                                <div class="logo-content">

                                                    <a href="{{ !empty($user->avatar) ? $logo .'/'. $user : $logo . '/avatar.png' }}" target="_blank">
                                                            <img src="{{ !empty($user->avatar) ? $logo .'/'. $user->avatar : $logo . '/avatar.png' }}" width="100" id="profile">
                                                        </a>
                                                </div>
                                                <div class="choose-files mt-4">
                                                    <label for="profile_pic">
                                                        <div class="bg-primary profile_update"
                                                            style="max-width: 100% !important;"> <i
                                                                class="ti ti-upload px-1"></i>{{__('Choose file here')}}
                                                        </div>
                                                        <input type="file" class="file" name="profile" accept="image/*"
                                                            id="profile_pic"
                                                            onchange="document.getElementById('profile').src = window.URL.createObjectURL(this.files[0])">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 col-sm-6 col-md-6">
                                            <div class="card-body">

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                         <label class="col-form-label text-dark">{{ __('Name') }}</label>
                                            <input class="form-control " name="name" type="text" id="fullname"
                                                placeholder="{{ __('Enter Your Name') }}" value="{{ $user->name }}"
                                                required autocomplete="name">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="email"
                                                class="col-form-label text-dark">{{ __('Email') }}</label>
                                            <input class="form-control " name="email" type="text" id="email"
                                                placeholder="{{ __('Enter Your Email Address') }}"
                                                value="{{ $user->email }}" required autocomplete="email">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row card-body">
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="mobile_number"
                                                class="col-form-label text-dark">{{ __('Mobile Number') }}</label>
                                            <input class="form-control " name="mobile_number" type="number"
                                                id="mobile_number" placeholder="{{ __('Enter Your Mobile Number') }}"
                                                value="{{ !empty($user_detail->mobile_number) ? $user_detail->mobile_number : '' }}"
                                                autocomplete="mobile_number">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="address"
                                                class="col-form-label text-dark">{{ __('Address') }}</label>
                                            <input class="form-control " name="address" type="text" id="address"
                                                placeholder="{{ __('Enter Your Address') }}"
                                                value="{{ !empty($user_detail->address) ? $user_detail->address : '' }}"
                                                autocomplete="address">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="city"
                                                class="col-form-label text-dark">{{ __('City') }}</label>
                                            <input class="form-control " name="city" type="text" id="city"
                                                placeholder="{{ __('Enter Your City') }}"
                                                value="{{ !empty($user_detail->city) ? $user_detail->city : '' }}"
                                                autocomplete="city">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="state"
                                                class="col-form-label text-dark">{{ __('State') }}</label>
                                            <input class="form-control " name="state" type="text" id="state"
                                                placeholder="{{ __('Enter Your State') }}"
                                                value="{{ !empty($user_detail->state) ? $user_detail->state : '' }}"
                                                autocomplete="state">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="zip_code"
                                                class="col-form-label text-dark">{{ __('Zip/Postal Code') }}</label>
                                            <input class="form-control " name="zip_code" type="number" id="zip_code"
                                                placeholder="{{ __('Enter Your Zip/Postal Code') }}"
                                                value="{{ !empty($user_detail->zip_code) ? $user_detail->zip_code : '' }}"
                                                autocomplete="zip_code">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="landmark"
                                                class="col-form-label text-dark">{{ __('Landmark') }}</label>
                                            <input class="form-control " name="landmark" type="text" id="landmark"
                                                placeholder="{{ __('Enter Your Landmark') }}"
                                                value="{{ !empty($user_detail->landmark) ? $user_detail->landmark : '' }}"
                                                autocomplete="landmark">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="about"
                                                class="col-form-label text-dark">{{ __('Brief About Yourself') }}</label>
                                            <input class="form-control " name="about" type="text" id="about"
                                                placeholder="{{ __('Enter Your About Yourself') }}"
                                                value="{{ !empty($user_detail->about) ? $user_detail->about : '' }}"
                                                autocomplete="about">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-end">
                                        <input type="submit" value="{{ __('Save Changes') }}"
                                            class="btn btn-print-invoice  btn-primary m-r-10">
                                    </div>
                                </div>
                                </form>

                                {{ Form::close() }}
                            </div>

                    </div>
                    @if($user->id == Auth::user()->id)
                    <div id="useradd-2" class="card  shadow-none rounded-0 border-bottom">

                            <div class="card-header">
                                <h5 class="mb-0">{{ __('Change Password') }}</h5>
                                <small> {{ __('Details about your member account password change') }}</small>
                            </div>
                            <div class="card-body">
                                {{ Form::open(['route' => ['member.change.password', $user->id], 'method' => 'POST']) }}

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="password"
                                                class="form-label col-form-label text-dark">{{ __('New Password') }}</label>
                                            <input class="form-control" name="password" type="password" id="password"
                                                required autocomplete="password"
                                                placeholder="{{ __('Enter New Password') }}">
                                            @error('password')
                                                <span class="invalid-password" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="confirm_password"
                                                class="form-label col-form-label text-dark">{{ __('Confirm Password') }}</label>
                                            <input class="form-control" name="confirm_password" type="password"
                                                id="confirm_password" required autocomplete="confirm_password"
                                                placeholder="{{ __('Confirm New Password') }}">
                                            @error('confirm_password')
                                                <span class="invalid-confirm_password" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer pr-0">
                                    {{ Form::submit(__('Update'), ['class' => 'btn  btn-primary']) }}
                                </div>
                                {{ Form::close() }}
                            </div>

                    </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
@endsection


@push('custom-script')
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300,

        })
        $(".list-group-item").on('click',function() {
            $('.list-group-item').filter(function() {
                return this.href == id;
            }).parent().removeClass('text-primary');
        });
    </script>
@endpush
