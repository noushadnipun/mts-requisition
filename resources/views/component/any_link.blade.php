<div class="column is-1">
        <div class="level-item is-4">
        @if(!empty($spAllData))
            <a href="{{ $spAllData  ?? NULL }}"
            class="button is-small {{ $spCss  ?? 'is-info-light' }} is-rounded"
            aria-haspopup="true"
            aria-controls="dropdown-menu3">
                <span><i class="fas fa-database"></i> {{ $spTitle ?? 'All Datas' }}</span>
            </a>
            @endif
            @if($spAddUrl != '#')
            <a href="{{ $spAddUrl ?? NULL }}" class="button is-small is-info-light is-rounded" aria-haspopup="true"
            aria-controls="dropdown-menu">
                <span><i class="fas fa-plus"></i> Add</span>
            </a>
        @endif    
    </div>
</div>