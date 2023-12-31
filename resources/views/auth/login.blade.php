@extends('layouts.guest')

@push('custom-scripts')
@if (env('RECAPTCHA_MODULE') == 'yes')
{!! NoCaptcha::renderJs() !!}
@endif
@endpush

@section('page-title')
{{ __('Login') }}
@endsection

@section('auth-lang')
<select class="btn btn-primary my-1 me-2 " name="language" id="language"
    onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
    @foreach(App\Models\Utility::languages() as $language)
    <option @if($lang==$language) selected @endif value="{{ route('login',$language) }}">{{Str::upper($language)}}
    </option>
    @endforeach
</select>
@endsection

@section('content')
<div class="">
    <h2 class="mb-3 f-w-600">{{ __('Login') }}</h2>
</div>
{{ Form::open(['route' => 'login', 'method' => 'post', 'id' => 'loginForm']) }}
@csrf
<div class="">
    <div class="form-group mb-3">
        <label for="email" class="form-label">{{ __('Email') }}</label>
        <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email"
            value="{{ old('email') }}" required autocomplete="email" autofocus>
        @error('email')
        <div class="invalid-feedback" role="alert">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="password" class="form-label">{{ __('Password') }}</label>
        <input class="form-control @error('password') is-invalid @enderror" id="password" type="password"
            name="password" required autocomplete="current-password">
        @error('password')
        <div class="invalid-feedback" role="alert">{{ $message }}</div>
        @enderror

    </div>

    @if (env('RECAPTCHA_MODULE') == 'yes')
    <div class="form-group mb-3">
        {!! NoCaptcha::display() !!}
        @error('g-recaptcha-response')
        <span class="small text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    @endif
    <div class="form-group mb-4">
        @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="text-xs">{{ __('Forgot Your Password?') }}</a>
        @endif
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary btn-block mt-2" id="login_button">{{ __('Login') }}</button>
    </div>

    @if(App\Models\Utility::getValByName('signup_button')=='on')
        <p class="my-4 text-center">{{ __("Don't have an account?") }}
            <a href="{{route('register',$lang)}}" class="my-4 text-primary">{{__('Register')}}</a>
        </p>
    @endif

</div>
{{ Form::close() }}
@endsection

