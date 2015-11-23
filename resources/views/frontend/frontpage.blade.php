@extends('frontend.layout')

@section('content')

    <?php

    /* Forsiðumyndir */
    $forsidumyndir = getContentBySlug('_forsidumyndir')->getSubs();

    ?>

    @if( ! $forsidumyndir->isEmpty())
        <div class="Banner padded-top">
            <div class="uk-container uk-container-center">
                <div class="Slideshow">
                    <div class="uk-slidenav-position" data-uk-slideshow>
                        <ul class="uk-slideshow">
                            @foreach($forsidumyndir as $mynd)
                                <li><img src="/imagecache/banner/{{ $mynd->img()->first() }}" /></li>
                            @endforeach
                        </ul>

                        <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
                        <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next"></a>

                        <ul class="uk-dotnav uk-dotnav-contrast uk-position-bottom uk-flex-center">
                            @foreach($forsidumyndir as $c => $mynd)
                                <li data-uk-slideshow-item="{{ $c }}"><a href=""></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <?php

    /* Forsiðumyndir */
    $forsidukubbar = getContentBySlug('_forsidukubbar')->getSubs();

    ?>

    @if( ! $forsidukubbar->isEmpty())
        <div class="Kubbar padded">
            <div class="uk-container uk-container-center">
                <div class="uk-grid" data-uk-grid-margin data-uk-grid-match="{target:'.Kubbur'}">

                    @foreach($forsidukubbar as $kubbur)
                        @include('frontend._kubbur', ['kubbur' => $kubbur])
                    @endforeach

                </div>
            </div>
        </div>
    @endif

@stop