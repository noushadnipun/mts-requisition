@extends('layouts.noapp')
@section('content')

    <div class="box is-centered">
        <h1 class="title has-text-success is-justify-content-center">{{ __('Register') }}</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="field">
                <label for="" class="label">{{ __('Name') }}</label>
                <div class="control has-icons-left">
                    <input type="text" placeholder="e.g. bobsmith@gmail.com"
                           class="input  @error('name') is-invalid @enderror" name="name"
                           value="{{ old('name') }}" required autocomplete="name" autofocus>
                    <span class="icon is-small is-left"><i class="fa fa-envelope"></i></span>
                    @error('name')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>

            <div class="field">
                <label for="" class="label">{{ __('E-Mail Address') }}</label>
                <div class="control has-icons-left">
                    <input type="email" placeholder="e.g. bobsmith@gmail.com"
                           class="input @error('email') is-invalid @enderror" name="email"
                           value="{{ old('email') }}" required autocomplete="email">
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
                <label for="" class="label">{{ __('Confirm Password') }}</label>
                <div class="control has-icons-left">
                    <input type="password" placeholder="*******" class="input @error('password') is-invalid @enderror"
                           name="password_confirmation" required autocomplete="new-password">
                    <span class="icon is-small is-left">
                  <i class="fa fa-lock"></i>
                </span>
                    @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>

            <div class="field">
                <button class="button is-success is-small">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>

@endsection
