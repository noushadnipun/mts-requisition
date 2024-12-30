@extends('layouts.noapp')

@section('content')

    <div class="box is-centered">
        <h1 class="title has-text-success is-justify-content-center">
            {{ env('APP_NAME') }}
            {{--            {{ __('Login') }}--}}
        </h1>
        <form action="{{ route('login') }}" method="post">
            @csrf

            <div class="field">
                <label for="" class="label">{{ __('E-Mail Address') }}</label>
                <div class="control has-icons-left">
                    <input type="email" placeholder="e.g. info@bizbosserp.com"
                           class="input @error('email') is-invalid @enderror" name="email"
                           value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <span class="icon is-small is-left"><i class="fa fa-envelope"></i></span>
                    @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
            <div class="field">
                <label for="" class="label">{{ __('Password') }}</label>
                <div class="control has-icons-left">
                    <input type="password" placeholder="*******" class="input @error('password') is-invalid @enderror"
                           name="password"
                           required autocomplete="current-password" {{ old('remember') ? 'checked' : '' }}>
                    <span class="icon is-small is-left">
                  <i class="fa fa-lock"></i>
                </span>
                    @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
            <div class="field">
                <label for="" class="checkbox">
                    <input type="checkbox">
                    {{ __('Remember Me') }}
                </label>
            </div>
            <div class="field">
                <button class="button is-success is-small">
                    {{ __('Login') }}
                </button>
            </div>
            <div class="field">
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </form>
    </div>
@endsection
