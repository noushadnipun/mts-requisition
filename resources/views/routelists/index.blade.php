@extends('layouts.app')

@section('title')
    Route Lists
@endsection

<section class="hero is-white borderBtmLight">
    <nav class="level">
        @include('component.title_set', [
            'spTitle' => 'Route Lists',
            'spSubTitle' => 'add or edit route list',
            'spShowTitleSet' => true
        ])

        @include('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spAddUrl' => route('routelists.create'),
            'spAllData' => route('routelists.index'),
            'spSearchData' => route('routelists.search'),
        ])

        @include('component.filter_set', [
            'spShowFilterSet' => true,
            'spPlaceholder' => 'Search routes...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ])
    </nav>
</section>

@section('column_left')
    <div class="columns is-multiline">
        @foreach($routelists as $routelist)
            <div class="column is-4">
                <div class="borderedCol">
                    <article class="media">
                        <div class="media-content">
                            <div class="content">
                                <p>
                                    <strong>
                                        <a href="javascript:void(0)"
                                           title="View route">
                                            {{ $routelist->route_name }}
                                        </a>
                                    </strong>
                                    <br/>
                                    <small>
                                        <strong>Role: </strong>

                                        <?php
                                        $html = null;
                                        $datas = explode(',', $routelist->to_role);
                                        foreach ($datas as $d) {
                                            if ($d > 1 && count($datas) > 1) {
                                                $html .= ', ';
                                            }
                                            $html .= \App\Models\Role::where('id', $d)->first()->name;
                                        }
                                        echo $html;
                                        ?>
                                    </small>
                                    <br/>
                                    @if($routelist->parent_menu_id != NULL)
                                        <small>
                                            <?php $route = \App\Models\Routelist::select('route_name')->where('id', $routelist->parent_menu_id)->get()->first(); ?>
                                            <strong>Parent Menu: </strong> {{ $route['route_name'] ?? NULL }}
                                        </small>
                                    @else
                                        <small style="color: green;"> is a parent route</small>
                                    @endif
                                    <br/>
                                    <small><strong>Route Hash:</strong> {{ $routelist->route_hash }}</small>
                                    <br/>
                                    <small><strong>Details:</strong> {{ $routelist->route_description }}</small>
                                    <br/>
                                    <small>
                                        <strong>Will show on menu? : </strong>
                                        {{ ($routelist->show_menu == 1) ? 'Yes' : 'No' }}
                                    </small>
                                </p>
                            </div>
                            <nav class="level is-mobile">
                                <div class="level-left">
                                    {{--                                    <a href="#"--}}
                                    {{--                                       class="level-item"--}}
                                    {{--                                       title="View user data">--}}
                                    {{--                                        <span class="icon is-small"><i class="fas fa-eye"></i></span>--}}
                                    {{--                                    </a>--}}
                                    <a href="{{ route('routelists.edit', $routelist->id) }}"
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
