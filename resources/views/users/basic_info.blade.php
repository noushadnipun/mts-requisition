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
        <p class="panel-tabs">
            <a href="{{ route('users.basic_info', $id) }}" class="is-active">Basic Information</a>
            <a href="{{ route('users.contact_info', $id) }}">Other Information</a>
            <a href="{{ route('users.user_photos', $id) }}">Images</a>
            <a href="{{ route('users.user_permissions', $id) }}">Permissions</a>
            <a href="{{ route('users.financial_info', $id) }}">Financial Information</a>
        </p>

        <div class="customContainer">
            {{ Form::open(array('url' => route('users.basic_info', $id), 'method' => 'post', 'value' => 'PATCH', 'id' => 'add_user', 'files' => true, 'autocomplete' => 'off')) }}
            <div class="columns">
                <div class="column is-6">
                    <div class="field">
                        {{ Form::label('name', 'Name', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::text('name', $user->name, ['required', 'class' => 'input', 'placeholder' => 'Enter name...']) }}
                        </div>
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        {{ Form::label('employee_no', 'Employee no', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::number('employee_no', $user->employee_no, ['class' => 'input', 'required' => true, 'placeholder' => 'Enter employee no...']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-6">
                    <div class="field">
                        {{ Form::label('phone', 'Mobile', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::number('phone', $user->phone, ['required', 'class' => 'input', 'placeholder' => 'Enter phone no...', 'maxlength' => 11, 'minlength' => 11]) }}
                        </div>
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        {{ Form::label('emergency_phone', 'Emergency mobile', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::number('emergency_phone', $user->emergency_phone, ['class' => 'input', 'required' => true, 'placeholder' => 'Enter phone no...', 'maxlength' => 11, 'minlength' => 11]) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-4">
                    <div class="field">
                        {{ Form::label('email', 'Email', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::text('email', $user->email, ['class' => 'input', 'type' => 'email', 'placeholder' => 'Enter email...']) }}
                        </div>
                    </div>
                </div>
                <div class="column is-2">
                    <div class="field">
                        {{Form::label('department','Department',['class' => 'label'])}}
                        <div class="control">
                            <div class="select is-fullwidth">
                                <?php
                                //$designations = \App\Models\Designation::pluck('name', 'id');
                                $departments = array(
                                    '' => 'Select a department',
                                    'Accounts & Finance' => 'Accounts & Finance',
                                    'Administration'  => 'Administration',
                                    'Maintenance' => 'Maintenance',
                                    'Management' => 'Management',
                                    'E-Commerce' => 'E-Commerce',
                                    'Tourism'   => 'Tourism',
                                    'Technical' => 'Technical',
                                    'HR' => 'HR',
                                    'Office Staff' => 'Office Staff',
                                );
                                ?>
                                {{ Form::select('department', $departments ?? NULL, $user->department, ['class' => 'input is-small']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        {{Form::label('designation','Designation',['class' => 'label'])}}
                        <div class="control">
                            <div class="select is-fullwidth">
                                <?php $designations = \App\Models\Designation::pluck('name', 'id'); ?>
                                {{ Form::select('designation', $designations ?? NULL, $user->designation, ['class' => 'input is-small']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        {{Form::label('role','User Group',['class' => 'label'])}}
                        <div class="control">
                            <div class="select is-fullwidth">
                                <?php $roles = \App\Models\Role::pluck('name', 'id'); ?>
                                {{ Form::select('role', $roles ?? NULL, $user->role, ['class' => 'input is-small']) }}
                            </div>
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
