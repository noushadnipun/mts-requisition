<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.0.0/animate.min.css"/>
<script src="https://unpkg.com/bulma-toast@2.2.0/dist/bulma-toast.min.js"></script>

@if(Session::has('message') || Session::has('status'))
    @if(Session::get('status') == 0)
        @php
            $color_class = 'is-danger';
        @endphp
    @else
        @php
            $color_class = 'is-success';
        @endphp
    @endif
    <script>
        bulmaToast.toast({
            message: '{{ Session::get('message') }}',
            type: '{{ $color_class }}',
            position: 'bottom-left',
            dismissible: true,
            closeOnClick: true,
            duration: 4000,
            pauseOnHover: true,
            animate: {in: 'fadeIn', out: 'fadeOut'},
        })
    </script>

    <noscript>
        <div style="margin: 10px;">
            <div class="notification is-danger">{{ Session::get('message') }}</div>
        </div>
    </noscript>
@endif

@if($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            bulmaToast.toast({
                message: '{{ $error }}',
                type: 'is-warning',
                position: 'bottom-left',
                dismissible: true,
                closeOnClick: true,
                duration: 4000,
                pauseOnHover: true,
                animate: {in: 'fadeIn', out: 'fadeOut'},
            })
        </script>
    @endforeach
@endif

<style>
    .notification {
        font-size: 18px;
    }
</style>
