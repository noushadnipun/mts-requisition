@extends('layouts.noapp')

@section('title', 'Biz Boss Dashboard')
@section('sub_title', 'all parent menu here')

@section('dashboard')
    <section class="section">
        <div class="columns">
            <div class="column is-2"></div>
            <div class="column is-8">
                <div class="columns is-multiline">
                    <div class="column colorWhite">
                        Welcome, <br/><strong>{{ Auth::user()->name }}</strong>&nbsp;
                        as {{ \App\Models\Role::where('id', Auth::user()->role)->first()->name }}<br/>
                        <a href="{{ url('logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a>

                        <br/>
                        <br/>
                        <strong>You don't have permission to access this page</strong>
                    </div>
                </div>
                <div class="columns is-multiline">
                    <?php
                    $dashboard_menus = \App\Models\Routelist::where('show_menu', '=', 1)
                        ->where('is_active', '=', 1)
                        ->get();
                    ?>
                    @foreach($dashboard_menus as $menu)
                        @if(!empty(Auth::user()->role))
                            @if($menu->to_role == Auth::user()->role ?? 6 && $menu->dashboard_menu == 1)
                                <div class="column is-2">
                                    <div class="isCentered">
                                        @if($menu->route_url == '#' || $menu->route_url == NULL)
                                            <?php $link = '#'; ?>
                                        @else
                                            <?php $link = route($menu->route_url) . '?route_id=' . $menu->id; ?>
                                        @endif
                                        <a href="{{ $link ?? NULL }}"
                                           class="button {{ $menu->bulma_class_icon_bg }} is-large is-accent">
                                            <span><i class="{{ $menu->font_awesome }}"></i></span>
                                        </a>
                                        <div class="o_caption">{{ $menu->route_name }}</div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="column is-2"></div>
        </div>
    </section>
@endsection
