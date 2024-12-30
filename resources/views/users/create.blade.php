@extends('layouts.app')
@section('title')
    Create User
@endsection
<section class="hero is-white borderBtmLight">
    <nav class="level">
        @include('component.title_set', [
            'spTitle' => 'Create User',
            'spSubTitle' => 'start with basic information',
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
            <a class="is-active">Basic Information</a>
        </p>

        <div class="customContainer">
            {{ Form::open(array('url' => route('users.store'), 'method' => 'post', 'value' => 'PATCH', 'id' => 'add_user', 'files' => true, 'autocomplete' => 'off')) }}
            <div class="columns">
                <div class="column is-6">
                    <div class="field">
                        {{ Form::label('name', 'Name', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::text('name', NULL, ['required', 'class' => 'input', 'placeholder' => 'Enter name...']) }}
                        </div>
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        {{ Form::label('employee_no', 'Employee no', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::number('employee_no', NULL, ['class' => 'input', 'required' => true, 'placeholder' => 'Enter employee no...']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-6">
                    <div class="field">
                        {{ Form::label('phone', 'Mobile', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::number('phone', NULL, ['required', 'class' => 'input', 'placeholder' => 'Enter phone no...', 'maxlength' => 11, 'minlength' => 11]) }}
                        </div>
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        {{ Form::label('emergency_phone', 'Emergency mobile', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::number('emergency_phone', NULL, ['class' => 'input', 'placeholder' => 'Enter phone no...', 'maxlength' => 11, 'minlength' => 11]) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-3">
                    <div class="field">
                        {{ Form::label('email', 'Email', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::text('email', NULL, ['class' => 'input', 'type' => 'email', 'placeholder' => 'Enter email...']) }}
                            {{--                            <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>--}}
                            {{--                        <p class="help is-danger">This email is invalid</p>--}}
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        {{Form::label('department','Department',['class' => 'label'])}}
                        <div class="control">
                            <div class="select" style="width: 100%">
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
                                {{ Form::select('department', $departments ?? NULL, NULL, ['class' => 'input is-small']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        {{Form::label('designation','Designation',['class' => 'label'])}}
                        <div class="control">
                            <div class="select" style="width: 100%">
                                <?php $designations = \App\Models\Designation::pluck('name', 'id'); ?>
                                {{ Form::select('designation', $designations ?? NULL, NULL, ['class' => 'input  is-small']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        {{Form::label('role','User Role',['class' => 'label'])}}
                        <div class="control">
                            <div class="select" style="width: 100%">
                                <?php $designations = \App\Models\Role::pluck('name', 'id'); ?>
                                {{ Form::select('role', $designations ?? NULL, NULL, ['class' => 'input is-small']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field is-grouped">
                <div class="control">
                    <button class="button is-success is-small">Save Changes</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </article>
@endsection

@section('column_right')

    <div class="box">
        <h1 class="title is-5">Important Note</h1>
        <p>
            The default password is stored in the database when the admin authority creates the user.
            <br/>
            Default password: <strong>mtsbd123</strong>
        </p>
        <br/>
        <p>
            After you provide the basic information, you create a list of users, now you will find the created user and
            update the information for your user.
        </p>
    </div>
    {{-- <div class="box">
        <h1 class="title is-5"> গুরুত্বপুর্ণ তথ্য </h1>
        <p>
            এডমিন কর্তৃক প্রতিটি ইউজার তৈরির সময় ডিফল্ট পাসওয়ার্ড ডাটাবেজে জমা হয় ।
            <br/>
            ডিফল্ট পাসওয়ার্ড: <strong>mtsbd123</strong>
        </p>
        <br/>
        <p>
            বেসিক তথ্য দেয়ার পর আপনি ইউজার্স লিস্টে গেলে এখন তৈরী করা ইউজারকে পাবেন এবং তখন আপনি ইউজারের জন্য বাকি তথ্য
            আপডেট করতে পারবেন। ইউজার তৈরির কাজকে সহজ করতে আমরা শুরুতে একজন ইউজারের জন্য যাবতীয় তথ্য ডাটাবেজে পাঠাই না।
        </p>
    </div> --}}
@endsection
