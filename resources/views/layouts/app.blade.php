<noscript>
    <?php
    $arr = [
        'session_id' => session()->getId(),
        'user_id' => auth()->user()->id,
        'javascript_value' => 'No',
    ];
    $match = [
        'session_id' => session()->getId(),
        'user_id' => auth()->user()->id
    ];

    $inserted = \App\Models\Attack::insertOrUpdate($match, $arr);
    ?>

</noscript>

<!DOCTYPE html>
<html class="has-navbar-fixed-top" lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>
        @if($__env->yieldContent('title'))
            @yield('title')
        @else
            {{ 'Mobile Tele Solutions &#8211; A Service to Remember' }}
        @endif
    </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/styles.css') }}? <?php echo rand(0,999);?>"/>
    <script type="text/javascript"> var baseurl = "<?php echo url('/'); ?>";</script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $.noConflict();
            $.ajax({
                url: "{{ route('ajaxTest') }}",
                method: 'GET'
            });

        });
    </script>
    @yield('headjs')
</head>
<body>

<?php /*<div class="pageload1"></div>
		<div class="pageload2"><img src="{{asset('public/images/preloader.gif')}}"></div>
        */ ?>

<div class="tap1"></div>
<div class="tap2"><img src="{{asset('public/images/preloader.gif')}}"></div>
<script>
    /*
        $(window).on('load', function () {
            $(".pageload1").hide();
            $(".pageload2").hide();
            $(".tap1").hide();
            $(".tap2").hide();
        });
        */
</script>
@php
    //task Site Complete or running Status
    /**
    * if any data get in task_site_complete table based on  Manager User id
    *
    */
    $todayDate = date('Y-m-d');
    $last2DaysDate = date('Y-m-d', strtotime($todayDate. ' - 1 days'));
    $siteComeplteStatusCheck = Tritiyo\Site\Models\TaskSiteComplete::where('user_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->get();
    $getTask = Tritiyo\Task\Models\Task::where('user_id', auth()->user()->id)->where('tasks.task_for', '<', $last2DaysDate)->first();

    //dd($getTask);
    if(auth()->user()->isManager(auth()->user()->id)){

        $manager_id = auth()->user()->id;

        //dd($last2DaysDate);
        $sites = Tritiyo\Task\Models\Task::leftjoin('tasks_site', 'tasks_site.task_id', 'tasks.id')
                                    ->leftjoin('sites', 'sites.id', 'tasks_site.site_id')
                                    ->select('tasks.id as task_id', 'tasks.task_for as task_for', 'tasks_site.site_id as site_id', 'sites.*')
                                    ->where('tasks.user_id', $manager_id)
                                    ->where('sites.completion_status', 'Running')
                                    ->where(function ($query) {
                                        $query->where('sites.site_type',  NULL)
                                              ->orWhere('sites.site_type',  'Fresh')
                                              ->orWhere('sites.site_type',  'Old');
                                    })
                                    //->where('tasks.task_for', [$last2DaysDate, $todayDate])
                                    ->where('tasks.task_for', '<', $last2DaysDate)
                                    ->groupBy('tasks_site.site_id')
                                    ->get();


             if(count($sites) > 0){
                if($getTask == null){

                } else {

                    if(count($siteComeplteStatusCheck) > 0){

                    } else {
                        //echo Redirect::to('/site/updated-status');
  						$siteUpdateStatusRedirect = url('/').'/site/updated-status';
  						echo "<script>window.location.href='".$siteUpdateStatusRedirect."';</script>";
                    }
                }
             } else {

             }

    }


@endphp


@include('layouts.header')

<div class="columns">
    @if (!empty($__env->yieldContent('column_left')) && !empty($__env->yieldContent('column_right')))
        <div class="column is-8">
            <div class="content_padding">
                @yield('column_left')
            </div>
        </div>
        <div class="column o-aside">
            <div class="content_padding">
                @yield('column_right')
            </div>
        </div>
    @else
        <div class="column">
            <div class="content_padding">
                @yield('column_left')
            </div>
        </div>
    @endif
</div>
@include('layouts.footer')

<div
    style="padding: 5px 25px; right: 0px; bottom: 0px; position: fixed; margin-top: 10px; z-index: -1; font-size: 12px; color: #f1f1f1;">
    <span style="color: #ffffff;">Software developed</span> by
    <a class="onhover" href="http://www.tritiyo.com" target="_blank">
        Tritiyo Limited
    </a>
</div>
<style type="text/css">
    a.onhover {
        color: yellow;
    }

    a.onhover:hover {
        color: #F1F1F1;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@yield('cusjs')
@yield('cus_js')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css">
<script>
    $.fn.select2.defaults.set("theme", "bootstrap");
</script>
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/form.css').'?'.rand(0,999) }}"/>
</body>
</html>

