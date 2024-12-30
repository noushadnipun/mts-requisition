@extends('layouts.app')
@section('title')
    User Photos
@endsection

<section class="hero is-white borderBtmLight">
    <nav class="level">
        @include('component.title_set', [
            'spTitle' => 'User Photos',
            'spSubTitle' => 'user avatar and signature',
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
        <div class="panel-tabs">
            <a href="{{ route('users.basic_info', $id) }}">Basic Information</a>
            <a href="{{ route('users.contact_info', $id) }}">Other Information</a>
            <a href="{{ route('users.user_photos', $id) }}" class="is-active">Images</a>
            <a href="{{ route('users.user_permissions', $id) }}">Permissions</a>
            <a href="{{ route('users.financial_info', $id) }}">Financial Information</a>
        </div>

        <div class="customContainer">
            {{ Form::open(array('url' => route('users.user_photos', $id), 'method' => 'post', 'value' => 'PATCH', 'id' => 'add_user', 'files' => true, 'autocomplete' => 'off', '')) }}
            <div class="columns">
                <div class="column is-4">
                    <div class="field">
                        {{ Form::label('avatar', 'User Avatar', array('class' => 'label')) }}
                        <div class="control">
                            <input type="file" name="avatar">
                        </div>
                    </div>
                    <div class="field">
                        {{ Form::label('signature', 'User Signature', array('class' => 'label')) }}
                        <div class="control">
                            <input type="file" name="signature">
                        </div>
                    </div>
                </div>
                <div class="column is-4">

                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <div class="field is-grouped">
                        <div class="control">
                            <input type="submit"
                                   name="user_photos"
                                   class="button is-success is-small"
                                   value="Save Changes"/>
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
