<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>@include('frontend._title')</title>
        <meta name="description" content="{{ config('formable.site_description') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta id="token" name="token" value="{{ csrf_token() }}">

        <meta property="og:title" content="{{ isset($page) ? $page->title : config('formable.site_title') }}" />
        <meta property="og:url" content="{{ \Request::root() }}/{{ \Request::path() }}" />

        @if(isset($page))
            @if($page->img()->exists())
                <meta property="og:image"
                      content="{{ \Request::root() }}/imagecache/facebook/{{ $page->img()->first() }}" />
            @else
                <meta property="og:image" content="{{ \Request::root() }}/imagecache/facebook/facebook.jpg" />
            @endif

            @if($page->content)
                <meta property="og:description" content="{{ shortenClean($page->content, 200) }}" />
            @endif
        @else
            <meta property="og:image" content="{{ \Request::root() }}/imagecache/facebook/facebook.jpg" />
            <meta property="og:description" content="{{ config('formable.site_description') }}" />
        @endif

        <meta property="og:image:width" content="600"/>
        <meta property="og:image:height" content="315"/>

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <script src="/js/vendor/modernizr-2.8.3.min.js"></script>

        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/uikit/css/uikit.min.css">
        <link rel="stylesheet" href="/uikit/css/components/slideshow.min.css">
        <link rel="stylesheet" href="/uikit/css/components/slidenav.min.css">
        <link rel="stylesheet" href="/uikit/css/components/dotnav.min.css">
        <link rel="stylesheet" href="/css/app.css">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="/uikit/js/uikit.min.js"></script>
        <script src="/uikit/js/components/slideshow.min.js"></script>
        <script src="/js/vendor/modernizr-2.8.3.min.js"></script>
        <script src="//use.edgefonts.net/lobster-two;source-sans-pro.js"></script>
        <script src="/js/custom.js"></script>
        <script>
        Vue.config.debug = true;
        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
        </script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- This is the off-canvas sidebar -->
        <div id="mobile-menu" class="uk-offcanvas">
            <div class="uk-offcanvas-bar">
                <nav class="Offcanvas">
                    <ul>
                        {!! kalMenu() !!}
                    </ul>
                </nav>
            </div>
        </div>

        <div class="Haus padded alt">
            <div class="uk-container uk-container-center">
                <!--// Stór gluggi -->
                <div class="uk-position-relative uk-visible-large">
                    <a href="/"><img src="/img/logo.png" /></a>

                    <div class="Haus__simi">
                        <i class="uk-icon-phone-square uk-margin-right"></i>555-1234
                    </div>

                    <nav class="top">
                        <ul>
                            {!! kalMenu() !!}
                        </ul>
                    </nav>
                </div>

                <!--// Lítill gluggi -->
                <div class="uk-position-relative uk-hidden-large">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2 uk-text-center">
                            <a href="/"><img src="/img/logo.png" /></a>
                        </div>

                        <div class="uk-width-medium-1-2 uk-text-center-small uk-text-right">
                            <a id="mobile-button" href="#mobile-menu" data-uk-offcanvas>
                                VALMYND<i class="uk-icon-bars uk-icon-large uk-margin-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @yield('content')

        <div class="Fotur alt padded">
            <div class="uk-container uk-container-center">
                <div class="uk-grid" data-uk-grid-margin data-uk-grid-match="{target:'.Dalkur'}">
                    <div class="uk-width-medium-1-4 uk-width-small-1-2">
                        <div class="Dalkur">
                            <h3><i class="uk-icon-building-o uk-margin-right"></i>Fyrirtækið</h3>
                            <ul>
                                <li><i class="uk-icon-star uk-margin-right"></i>Heimilisfang 123</li>
                                <li><i class="uk-icon-map-marker uk-margin-right"></i>101 Reykjavík</li>
                                <li><i class="uk-icon-phone uk-margin-right"></i>555-1234</li>
                                <li><i class="uk-icon-paperclip uk-margin-right"></i>Kt. 112233-4455</li>
                                <li><i class="uk-icon-envelope uk-margin-right"></i><a href="mailto:email@email.is">email@email.is</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-4 uk-width-small-1-2">
                        <div class="Dalkur">
                            <h3><i class="uk-icon-clock-o uk-margin-right"></i>Opnunartímar</h3>
                            <ul>
                                <li><strong>Mán - Fös</strong></li>
                                <li>10:00 - 16:00</li>
                                <li><strong>Laugardaga</strong></li>
                                <li>11:00 - 15:00</li>
                            </ul>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-4 uk-width-small-1-2">
                        <div class="Dalkur">
                            <h3><i class="uk-icon-link uk-margin-right"></i>Tenglar</h3>
                            <ul>
                                {!! kalMenu() !!}
                            </ul>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-4 uk-width-small-1-2">
                        <div class="Dalkur">
                            <h3><i class="uk-icon-facebook-square uk-margin-right"></i>Facebook</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
