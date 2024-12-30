@extends('layouts.app')

@section('title')
    User Profile
@endsection

<section class="hero is-white borderBtmLight">
    <nav class="level">
        @include('component.title_set', [
            'spTitle' => 'User Profile',
            'spSubTitle' => 'a single user data',
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
    {{--    <article class="panel is-primary">--}}
    {{--        <div class="customContainer">--}}
    <div class="card tile is-child">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-account default"></i></span>
                Basic Information
            </p>
        </header>
        <div class="card-content">
            <div class="is-user-avatar image has-max-width is-aligned-center">
                @if(!empty($user->avatar))
                    <img src="{{ url($user->avatar) }}" alt="{{ $user->name }}">
                @else
                    User Photo
                @endif
            </div>
            <hr/>
            <div class="card-data">
                <div class="columns">
                    <div class="column is-2">Name</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->name }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Email</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->email }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Employee No</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->employee_no }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Username</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->username }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Role</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ \App\Models\Role::where('id', $user->role)->first()->name }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Birthday</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->birthday }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Gender</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->gender }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Marital Status</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->marital_status }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Phone No</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->phone }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Phone No (Alternative)</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->emergency_phone }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Basic Salary</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->basic_salary }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Employee Status</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->employee_status ?? NULL }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Employee Status Note</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->employee_status_reason ?? NULL }}</div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div class="card tile is-child">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-account default"></i></span>
                Company and Other Information
            </p>
        </header>
        <div class="card-content">
            <div class="card-data">
                <div class="columns">
                    <div class="column is-2">Father</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->father }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Mother</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->mother }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Address</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->address }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">District</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->district }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Post Code</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->postcode }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Company</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->company }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Designation</div>
                    <div class="column is-1">:</div>
                    <div
                        class="column">{{ \App\Models\Designation::where('id', $user->designation)->first()->name }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Join Date</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->join_date }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Company Address</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->company_address }}</div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div class="card tile is-child">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-account default"></i></span>
                Financial Information
            </p>
        </header>
        <div class="card-content">
            <div class="card-data">
                <div class="columns">
                    <div class="column is-2">Bank Information</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->bank_information }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Mobile Banking Information</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->mbanking_information }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Email (Alternative)</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->alternative_email }}</div>
                </div>
                <div class="columns">
                    <div class="column is-2">Is Active</div>
                    <div class="column is-1">:</div>
                    <div class="column">{{ $user->is_active }}</div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div class="card tile is-child">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-account default"></i></span>
                Reading folder from module
            </p>
        </header>
    </div>
@endsection

@section('column_right')
    {{--    <div class="box">--}}
    {{--        <h1 class="title is-5">Important Note</h1>--}}
    {{--        <p>--}}
    {{--            The default password is stored in the database when the admin authority creates the user.--}}
    {{--            <br/>--}}
    {{--            Default password: <strong>bizradix@123</strong>--}}
    {{--        </p>--}}
    {{--        <br/>--}}
    {{--        <p>--}}
    {{--            After you provide the basic information, you create a list of users, now you will find the created user and--}}
    {{--            update the information for your user.--}}
    {{--        </p>--}}
    {{--    </div>--}}
    {{--    <div class="box">--}}
    {{--        <h1 class="title is-5"> গুরুত্বপুর্ণ তথ্য </h1>--}}
    {{--        <p>--}}
    {{--            এডমিন কর্তৃক প্রতিটি ইউজার তৈরির সময় ডিফল্ট পাসওয়ার্ড ডাটাবেজে জমা হয় ।--}}
    {{--            <br/>--}}
    {{--            ডিফল্ট পাসওয়ার্ড: <strong>bizradix@123</strong>--}}
    {{--        </p>--}}
    {{--        <br/>--}}
    {{--        <p>--}}
    {{--            বেসিক তথ্য দেয়ার পর আপনি ইউজার্স লিস্টে গেলে এখন তৈরী করা ইউজারকে পাবেন এবং তখন আপনি ইউজারের জন্য বাকি তথ্য--}}
    {{--            আপডেট করতে পারবেন। ইউজার তৈরির কাজকে সহজ করতে আমরা শুরুতে একজন ইউজারের জন্য যাবতীয় তথ্য ডাটাবেজে পাঠাই না।--}}
    {{--        </p>--}}
    {{--    </div>--}}
@endsection
