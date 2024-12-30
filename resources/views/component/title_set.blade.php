<?php function titleSet($spShowTitleSet = null, $spTitle = null, $spSubTitle = null, $spStatus = null, $spMessage = null){ 
    
ob_start();?>

@if(!empty($spShowTitleSet) && $spShowTitleSet == true)
    <div class="level-item is-5">
        <div>
            <h3><strong>{{ $spTitle }}</strong> |  {{ ucfirst($spSubTitle) }}</h3>
            
        </div>
        @if(!empty($spStatus) && $spStatus == 1)
            <p class="has-text-success hideMessage">
                {{ !empty($spMessage) ? $spMessage : NULL }}
            </p>
        @else
            <p class="has-text-danger hideMessage">
                {{ !empty($spMessage) ? $spMessage : NULL }}
            </p>
        @endif
    </div>
@endif

<?php 
    $content = ob_get_contents();
    ob_get_clean();
    return $content;
}
?>


@section('header_title_set')
    <style>
        .navbar .level-item.is-5 strong, .navbar .level-item.is-5{
            color: #fff;
            font-size: 17px;
        }
    </style>

<div class="is-hidden-touch is-flex">
    <?php //echo titleSet($spShowTitleSet ?? null, $spTitle ?? null, $spSubTitle ?? null, $spStatus ?? null, $spMessage ?? null);?>
</div>

@endsection



<div class="column is-5">
    <?php echo titleSet($spShowTitleSet ?? null, $spTitle ?? null, $spSubTitle ?? null, $spStatus ?? null, $spMessage ?? null);?>
</div>






<?php 
/*

// Backup Code 


@if(!empty($spShowTitleSet) && $spShowTitleSet == true)
    <div class="level-left">
        <div class="level-item is-5">
            <div>
                <h3><strong>{{ $spTitle }}</strong> |  {{ ucfirst($spSubTitle) }}</h3>
               
            </div>
            @if(!empty($spStatus) && $spStatus == 1)
                <p class="has-text-success hideMessage">
                    {{ !empty($spMessage) ? $spMessage : NULL }}
                </p>
            @else
                <p class="has-text-danger hideMessage">
                    {{ !empty($spMessage) ? $spMessage : NULL }}
                </p>
            @endif
        </div>
    </div>
@endif

*/


?>