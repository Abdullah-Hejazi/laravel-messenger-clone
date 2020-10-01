@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="action-form">
                <h1 class="form-title">Sign in</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group row">
                        <input id="email" type="email" class="form-input" placeholder="Enter your Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="error-message">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <input id="password" type="password" class="form-input" placeholder="*******" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="error-message">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <div class="form-check">
                            <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="custom-control-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group row mb-0 form-action-button">
                        <button type="submit" class="action-button"> Sign In </button>
                        {{-- 
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        --}}
                    </div>
                    
                    <a class="btn btn-link url-link" href="{{ route('register') }}">
                        {{ __("Don't have an Account ? Register Now !") }}
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
