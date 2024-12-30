@extends('layouts.app')
@section('title')
    User Permission
@endsection

<section class="hero is-white borderBtmLight">
    <nav class="level">
        @include('component.title_set', [
            'spTitle' => 'User Permission Information',
            'spSubTitle' => 'Edit user User permission information',
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
            <a href="{{ route('users.basic_info', $id) }}">Basic Information</a>
            <a href="{{ route('users.contact_info', $id) }}">Other Information</a>
            <a href="{{ route('users.user_photos', $id) }}">Images</a>
            <a href="{{ route('users.user_permissions', $id) }}" class="is-active">Permissions</a>
            <a href="{{ route('users.financial_info', $id) }}">Financial Information</a>
        </p>

        <div class="customContainer">
            {{ Form::open(array('url' => route('users.user_permissions', $id), 'method' => 'post', 'value' => 'PATCH', 'id' => 'add_user', 'files' => true, 'autocomplete' => 'off')) }}
            <div class="columns">
                <div class="column">
                    <?php $routelist = \App\Models\Routelist::get(); ?>
                    <table class="table is-bordered">
                        <tr>
                            <th></th>
                            <th>Route Name</th>
                            <th>URL</th>
                            <th>Description</th>
                            <th>Note</th>
                            <th>In</th>
                            <th>For</th>
                        </tr>
                        @foreach($routelist as $key => $list)
                            <?php
                            $data = \DB::table('permissions')->select('checked')->where('route_id', $list->id)->where('user_id', $id)->get()->all();

                            if ($data) {
                                foreach ($data as $d) {
                                    if ($d->checked == 'on') {
                                        $checked = 'checked';
                                    } else {
                                        $checked = '';
                                    }
                                }

                            } else {
                                $checked = '';
                            }
                            ?>
                            <tr>
                                <td>
                                    <input name="permission[{{ $key }}][route_id]"
                                           type="hidden"
                                           value="{{ $list->id }}"/>
                                    <input name="permission[{{ $key }}][user_id]"
                                           type="hidden"
                                           value="{{ $id }}"/>
                                    @if ($data ?? '')
                                        <input name="permission[{{ $key }}][checked]"
                                               type="hidden" {{ $checked ?? ''}} value="off"/>
                                        <input name="permission[{{ $key }}][checked]"
                                               type="checkbox" {{ $checked ?? ''}} value="on"/>
                                    @else
                                        <input name="permission[{{ $key }}][checked]"
                                               type="checkbox" {{ $checked ?? ''}} value="on"/>
                                    @endif
                                </td>
                                <td>{{ $list->route_name }}</td>
                                <td>{{ $list->route_url }}</td>
                                <td>{{ $list->route_description }}</td>
                                <td>{{ $list->route_note }}</td>
                                <td>
                                    <?php
                                    $designation = \App\Models\Designation::where('id', $list->route_grouping)->get()->all();
                                    foreach ($designation as $desi) {
                                        echo $desi->name;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $roles = \App\Models\Role::where('id', $list->to_role)->get()->all();
                                    foreach ($roles as $role) {
                                        echo $role->name;
                                    }
                                    ?>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="field is-grouped">
                        <div class="control">
                            <input type="submit"
                                   name="user_permissions"
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
