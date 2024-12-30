@extends('layouts.app')
@section('title')
    Basic Information
@endsection

<section class="hero is-white borderBtmLight">
    <nav class="level">
        @include('component.title_set', [
            'spTitle' => 'Basic Information',
            'spSubTitle' => 'Edit user basic information',
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
    <article class="panel is-primary">
        <div class="customContainer">
            {{ Form::open(array('url' => route('user-password.update'), 'method' => 'PUT', 'value' => 'PATCH', 'id' => 'add_user', 'files' => true, 'autocomplete' => 'off')) }}
            <div class="columns">
                <div class="column is-6">
                    <div class="field">
                        {{ Form::label('password', 'Password', array('class' => 'label')) }}
                        <div class="control">
                            <input name="password" type="password" class="input" placeholder="Enter password..."
                                   required/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-6">
                    <div class="field">
                        {{ Form::label('confirm_password', 'Confirm Password', array('class' => 'label')) }}
                        <div class="control">
                            <input name="confirm_password" type="password" class="input"
                                   placeholder="Enter confirm password..." required/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="field is-grouped">
                        <div class="control">
                            <input type="submit"
                                   name="basic_info"
                                   class="button is-success is-small"
                                   value="Change"/>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </article>
@endsection

@section('column_right')
@endsection
