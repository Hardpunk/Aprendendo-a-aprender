<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="pt-br" itemscope itemtype="https://schema.org/Article">
<!--<![endif]-->

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{{ config('app.name') }}</title>

    <meta content="{{ csrf_token() }}" name="csrf-token">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="canonical" href="/"/>
    <meta name="description" content="{{ config('app.name') }}">
    <meta name="keywords" content="">
    <meta name="author" content="{{ config('app.name') }}">

    <!-- og tags -->
    <meta property='og:type' content='website'/>
    <meta property="og:locale" content="pt_BR">
    <meta property='og:title' content="{{ config('app.name') }}"/>
    <meta property='og:url' content='{{ config('app.url') }}'/>
    <meta property='og:description' content='{{ config('app.name') }}'/>
    <meta property='og:site_name' content='{{ config('app.name') }}'/>
    <meta property='og:image' content="{{ asset('images/favicon/ms-icon-144x144.png') }}"/>
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="144">
    <meta property="og:image:height" content="144">

    <!-- Schema -->
    <meta itemprop="name" content="{{ config('app.name') }}">
    <meta itemprop="description" content="{{ config('app.name') }}">

    <!-- ICONES -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="144x144" href="{{ asset('images/favicon/favicon-144x144.png') }}">
    <link rel="manifest" href="{{ asset('/images/favicon/manifest.json') }}">

    <meta name="msapplication-TileColor" content="#2c4939">
    <meta name="msapplication-TileImage" content="{{ asset('images/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#2c4939">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"
          integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link rel="stylesheet" href="{{ asset('vendor/mdb/css/mdb.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="//cdn.linearicons.com/free/1.0.0/icon-font.min.css">

    @yield('css')
    @yield('js_tags')
</head>

<body>
@if(Route::current()->getName() === 'home')
    <main class="wrapper">
        @include('includes.header')
        @yield('content')
        @include('includes.footer')
    </main>
    <!-- Scripts Gerais -->
    <script src="{{ mix('js/home.js') }}"></script>
@else
    <div id="wrapper">
        @include('includes.header')
        @yield('content')
        @include('includes.footer')
    </div>
    <!-- Scripts Gerais -->
    <script src="{{ mix('js/app.js') }}"></script>
@endif

<script src="{{ asset('vendor/mdb/js/mdb.min.js') }}"></script>

@yield('js')

<div id="cart-list-overlay"></div>

</body>
</html>
