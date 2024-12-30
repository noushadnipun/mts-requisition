@extends('layouts.app')
@include('component.title_set', [
    'spTitle' => 'Settings',
    'spSubTitle' => 'settings data',
    'spAddUrl' => route('settings.create'),
    'spAllData' => route('settings.index'),
    'spSearchData' => '#',
    'spExportCSV' => null,
    'spPlaceholder' => 'Search user...',
    'spMessage' => $message = $message ?? NULl,
    'spStatus' => $status = $status ?? NULL
])

@section('column_left')
    <div class="columns is-multiline">
        @foreach($settings as $setting)
            <div class="column is-one-quarter">
                <div class="borderedCol">
                    <article class="media">
                        <div class="media-content">
                            <div class="content">
                                <p>
                                    <strong>
                                        <a href="{{ route('settings.show', $setting->id) }}"
                                           title="View setting">
                                            {{ $setting }}
                                        </a>
                                    </strong>
                                </p>
                            </div>
                            <nav class="level is-mobile">
                                <div class="level-left">
                                    <a href="{{ route('users.show', $setting->id) }}"
                                       class="level-item"
                                       title="View user data">
                                        <span class="icon is-small"><i class="fas fa-eye"></i></span>
                                    </a>
                                    <a href="{{ route('settings', $setting->id) }}"
                                       class="level-item"
                                       title="View all transaction">
                                        <span class="icon is-info is-small"><i class="fas fa-edit"></i></span>
                                    </a>
                                    <a class="level-item" title="Delete user" href="javascript:void(0)"
                                       onclick="confirm('Are you sure?')">
                                        <span class="icon is-small is-red"><i class="fas fa-times"></i></span>
                                    </a>
                                </div>
                            </nav>
                        </div>
                    </article>
                </div>
            </div>
        @endforeach
    </div>
@endsection
