@extends('layouts.app')

@section('title')
    Other setting
@endsection

<section class="hero is-white borderBtmLight">
    <nav class="level">
        @include('component.title_set', [
            'spTitle' => 'Payment setting',
            'spSubTitle' => 'add or edit payment setting data',
            'spShowTitleSet' => true
        ])

        @include('component.button_set', [
            'spShowButtonSet' => false,
            'spAddUrl' => null,
            'spAllData' => route('settings.index'),
            'spSearchData' => null,
            'spExportCSV' => null,
        ])

        @include('component.filter_set', [
            'spShowFilterSet' => false,
            'spPlaceholder' => 'Search setting...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ])
    </nav>
</section>


@section('column_left')
    <article class="panel is-primary">
        <p class="panel-tabs">
            <a href="{{ route('settings.global', 1) }}">
                <i class="fas fa-wrench"></i>&nbsp; Global Settings
            </a>
            <a href="{{ route('settings.payment', 2) }}">
                <i class="fas fa-dollar-sign"></i>&nbsp; Payment Settings
            </a>
            <a href="{{ route('settings.time', 3) }}">
                <i class="fas fa-clock"></i>&nbsp; Time Settings
            </a>
            <a href="{{ route('settings.email', 4) }}" class="">
                <i class="fas fa-envelope"></i>&nbsp; Email Settings
            </a>
            <a href="{{ route('settings.other', 5) }}" class="is-active">
                <i class="fas fa-cog"></i>&nbsp; Other Settings
            </a>
        </p>

        <div class="customContainer">
            {{ Form::open(array('url' => route('settings.other', 5), 'method' => 'post', 'value' => 'PATCH', 'id' => 'add_user', 'files' => true, 'autocomplete' => 'off')) }}
   

            <?php
            if (!empty($setting)) {
                $fields = json_decode($setting->settings);
            }
            ?>

            <div class="columns">
                <div class="column is-12">
                    <div class="field">
                        {{ Form::label('email_address', 'Percentage of project lock', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::text('project_lock_percentage', $fields->project_lock_percentage ?? NULL, ['required', 'class' => 'input', 'rows' => 2, 'cols' => 40, 'placeholder' => '95', 'style' => 'height: auto !important']) }}
                        </div>
                        <small class="lead"></small>
                    </div>
                  
                  
                  <div class="field">
                        {{ Form::label('email_address', 'CFO restriction', array('class' => 'label')) }}
                        <div class="control">                   
                           <input type="checkbox" name="cfo_restriction" value="1" {{$fields->cfo_restriction == '1' ? 'checked' : null }}> 
                        </div>
                        <small class="lead"></small>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <div class="field is-grouped">
                        <div class="control">
                            <button class="button is-success is-small">Save Changes</button>
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
