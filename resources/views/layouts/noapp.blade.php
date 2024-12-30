
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/styles.css') }}?<?php echo rand(0,999);?>"/>
    <script type="text/javascript"> var baseurl = "<?php echo url('/'); ?>";</script>
</head>
<body class="o_web_client o_home_menu_background">

@include('layouts.notification')

<section class="hero is-fullheight">
    @yield('full_width_content')
    <div class="hero-body">
        <div class="container">
            @if (!empty($__env->yieldContent('dashboard')))
                @yield('dashboard')
            @else
                <div class="columns is-centered">
                    <div class="column is-5-tablet is-4-desktop is-3-widescreen">
                        @yield('content')
                    </div>
                </div>
            @endif


        </div>
    </div>
</section>
@include('layouts.footer')
@yield('cusjs')
</body>
</html>
