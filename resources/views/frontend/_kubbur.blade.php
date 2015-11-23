@if(isset($kubbur))
    <div class="uk-width-medium-1-3 uk-width-small-1-2">
        <div class="Kubbur">
            <a href="{{ $kubbur->url }}"
               class="Kubbur__image"
               style="background: #EEE url('/imagecache/kubbur/{{ $kubbur->img()->first() }}') center center no-repeat;
                      background-size: cover;"
            >
            </a>
            
            <div class="Kubbur__title">
                <h3>{{ $kubbur->title }}</h3>
            </div>

            @if($kubbur->content)
                <div class="Kubbur__content">
                    {{ shortenClean($kubbur->content, 100) }}
                </div>
            @endif

            <a class="takki" href="{{ $kubbur->url }}">Lesa meira...</a>
        </div>
    </div>
@endif