@extends('layouts.app')

@section('title')
    Users
@endsection

<section class="hero is-white borderBtmLight">
    <nav class="level">
        @include('component.title_set', [
            'spTitle' => 'Users',
            'spSubTitle' => 'all users here',
            'spShowTitleSet' => true
        ])

        

        @include('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spTitle' => 'Users',
            'spAddUrl' => route('users.create'),
            'spAllData' => route('users.index'),
            'spSearchData' => route('users.search'),
            'spTitle' => 'Users',
        ])

        <div class="column is-2">
            <div class="control">
                @php 
                    $filterUser = ['Enroll', 'Terminated', 'Long Leave', 'Left Job', 'On Hold'];
                	$filterDepartments = [
                        'Accounts & Finance' => 'Accounts & Finance',
                        'Administration'  => 'Administration',
                        'Maintenance' => 'Maintenance',
                        'Management' => 'Management',
                        'E-Commerce' => 'E-Commerce',
                        'Tourism'   => 'Tourism',
                        'Technical' => 'Technical',
                        'HR' => 'HR',
                        'Office Staff' => 'Office Staff',
                      ];
                @endphp
                <form action="{{route('users.index')}}" method="get" class="is-inline-block" style="vertical-align: top;">
                  <!-- employee status -->
                    <select name="filter_user" id="filter_user" class="select sb-example-1" xonchange="this.form.submit()">
                        <option  value=""> Filter User</option>
                        @foreach ($filterUser as $value)
                            <option value="{{$value}}" {{$value == request()->get('filter_user') ? 'selected' : ''}}>{{$value}}</option>
                        @endforeach
                    </select>
                  <!-- Deprtments Filter -->
                  	<select name="filter_department" id="filter_department" class="select sb-example-1" xonchange="this.form.submit()">
                        <option  value=""> Filter Department</option>
                        @foreach ($filterDepartments as $value)
                            <option value="{{$value}}" {{$value == request()->get('filter_department') ? 'selected' : ''}}>{{$value}}</option>
                        @endforeach
                    </select>
                  <button type="submit" style="vertical-align: top; margin-top: 1px;" class="button is-small is-info-light is-rounded"><i class="fa fa-search"></i></button>
                </form>
              
              
            
              
            </div>
        </div>

        @include('component.filter_set', [
            'spShowFilterSet' => true,
            'spAddUrl' => route('users.create'),
            'spAllData' => route('users.index'),
            'spSearchData' => route('users.search'),
            'spPlaceholder' => 'Search user...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ])
    </nav>
</section>
@php
    function enrollStatus($status) {
        switch ($status) {
          case 'Enroll':
            $colorClass = '';
            break;
          case 'Terminated':
            $colorClass = 'is-danger has-text-danger';
            break;
          case 'Long Leave':
            $colorClass = 'is-link has-text-link';
            break;
            case 'Left Job':
                $colorClass = 'is-warning has-text-warning';
            break;
          default:
            $colorClass = '';
        }
        return $colorClass;
    }
@endphp
@section('column_left')
    <div class="columns is-multiline">
        <?php
      	if (request()->get('filter_user') && request()->get('filter_department') ){
            $users = \App\Models\User::where('employee_status', request()->get('filter_user'))->where('department', request()->get('filter_department'))->orderBy('id', 'desc')->paginate(24);
        }
      	elseif (request()->get('filter_user')){
            $users = \App\Models\User::where('employee_status', request()->get('filter_user'))->orderBy('id', 'desc')->paginate(24);
        }elseif (request()->get('filter_department')){
            $users = \App\Models\User::where('department', request()->get('filter_department'))->orderBy('id', 'desc')->paginate(24);
        }
        ?>

        @foreach($users as $user)
      		
            <div class="column is-3">
                <article class="borderedCol media message {{ enrollStatus($user->employee_status) }}">
                    <div class="media-content">
                        <div class="content">
                            <div>
                                <strong>
                                    <a href="{{ route('users.show', $user->id) }}"
                                    title="View user">
                                        {{ $user->name }}
                                    </a>
                                </strong>
                            </div>
                            <div style="color: #000 !important;">
                                <small>
                                    <strong>Designation: </strong> {{ \App\Models\Designation::where('id', $user->designation)->first()->name }}
                                </small>
                              	<br/>
                              	 <small>
                                    <strong>Department: </strong> {{ $user->department ?? Null }}
                                </small>
                                <br/>
                                <small>
                                    <strong>Role: </strong> {{ \App\Models\Role::where('id', $user->role)->first()->name }}
                                </small>
                                <br/>
                                <small>
                                    <strong>Email: </strong> {{ $user->email }}
                                </small>
                                <br>
                                <small>
                                    <strong>Employee Status: </strong> {{ $user->employee_status }}
                                </small>
                                <br/>
                                <small>
                                    <strong>Employee No:</strong> {{ $user->employee_no }} &
                                    <strong>Phone: </strong> {{ $user->phone }}
                                </small>
                            </div>
                        </div>
                        <nav class="level is-mobile">
                            <div class="level-left">
                                <a href="{{ route('users.show', $user->id) }}"
                                class="level-item"
                                title="View user data">
                                    <span class="icon is-small"><i class="fas fa-eye"></i></span>
                                </a>
                                <a href="{{ route('users.basic_info', $user->id) }}"
                                class="level-item"
                                title="View all transaction">
                                    <span class="icon is-info is-small"><i class="fas fa-edit"></i></span>
                                </a>
                                
                                <a href="{{ route('users.reset_password', $user->id) }}"
                                class="level-item"
                                 onclick="confirm('Are you sure?')"
                                title="Reset Password">
                                    <span class="icon is-danger is-small" style="color: red;"><i class="fas fa-lock"></i></span>
                                </a>
                                
                                <!--
                                <a class="level-item" title="Delete user" href="javascript:void(0)" onclick="confirm('Are you sure?')">
                                    <span class="icon is-small is-red"><i class="fas fa-times"></i></span>
                                </a>
                                -->
                            </div>
                        </nav>
                    </div>
                    <figure class="media-right">
                        <p class="image is-64x64">
                            @if(!empty($user->avatar))
                                <img class="is-rounded avatar"
                                    src="{{ url($user->avatar) }}" alt="{{ $user->name }}">
                            @else
                                <img class="is-rounded avatar"
                                    src="https://bulma.io/images/placeholders/128x128.png">
                            @endif
                        </p>
                    </figure>
                </article>
            </div>
        @endforeach
    </div>

    <div class="pagination_wrap pagination is-centered">
      @if (request()->get('filter_user') && request()->get('filter_department'))
      	{{ $users->appends(['filter_user'=> request()->get('filter_user'), 'filter_department'=> request()->get('filter_department')])->links('pagination::bootstrap-4') }}
      @elseif(request()->get('filter_user') )
      	{{ $users->appends(['filter_user'=> request()->get('filter_user')])->links('pagination::bootstrap-4') }}
       @elseif(request()->get('filter_department') )
      	{{ $users->appends(['filter_department'=> request()->get('filter_department')])->links('pagination::bootstrap-4') }}
      @else
        {{ $users->links('pagination::bootstrap-4') }}
      @endif
    </div>
@endsection

<style>
    article.media {
        border: 1px solid #eeeeee;
    }

    article.media.message {
        padding: 10px;
        font-size: 13px;
        overflow-wrap: break-word;
    }

    img.avatar {
        width: 70px !important;
        height: 70px !important;
        min-width: 70px !important;
        min-height: 70px !important;
    }

    .message a:not(.button):not(.tag):not(.dropdown-item) {
        text-decoration: none !important;
    }

</style>
