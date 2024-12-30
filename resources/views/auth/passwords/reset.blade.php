@extends('layouts.app')
@section('title')
    Change Password
@endsection

<section class="hero is-white borderBtmLight">
    <nav class="level">
        @include('component.title_set', [
            'spTitle' => 'Change Password',
            'spSubTitle' => 'set your new password',
            'spShowTitleSet' => true
        ])

        @include('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spAddUrl' => route('users.create'),
            'spAllData' => route('users.index'),
            'spSearchData' => route('users.search'),
            'spTitle' => 'Users',
        ])

        @include('component.filter_set', [
            'spShowFilterSet' => true,
            'spPlaceholder' => 'Search user...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ])
    </nav>
</section>
@section('column_left')
    <div class="columns">
        <div class="column is-4"></div>
        <div class="column is-4">
            <article class="panel is-primary">
                <div class="customContainer">
                    {{--                        <form method="POST" action="{{ route('password.update') }}">--}}
                    {{--                            @csrf--}}

                    {{--                            <input type="hidden" name="token" value="{{ $token }}">--}}

                    {{ Form::open(array('url' => route('users.update_password', auth()->user()->id), 'method' => 'PUT', 'value' => 'PATCH', 'id' => 'add_user', 'files' => true, 'autocomplete' => 'off')) }}

                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                {{ Form::label('email', 'E-Mail Address', array('class' => 'label')) }}
                                <div class="control">
                                    <input id="email" type="email"
                                           class="input @error('email') is-invalid @enderror" name="email"
                                           value="{{ $user->email ?? $user->email }}" required autocomplete="email"
                                           readonly
                                           autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="columns">
                        <div class="column">
                            <div class="field">
                                {{ Form::label('current_password', 'Current Password', array('class' => 'label')) }}
                                <div class="control">
                                    <input id="current_password" type="password"
                                           class="input @error('password') is-invalid @enderror" name="password"
                                           required>

                                    @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                {{ Form::label('password', 'Password', array('class' => 'label')) }}
                                <div class="control">
                                    <input id="password" type="password"
                                           class="input @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                {{ Form::label('confirm_password', 'Confirm Password', array('class' => 'label')) }}
                                <div class="control">
                                    <input id="password-confirm" type="password" class="input"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="button is-success is-small">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </div>
                    {{ Form::close() }}

                </div>
            </article>
        </div>
        <div class="column is-4"></div>
    </div>

@endsection
@section('column_right')
@endsection
