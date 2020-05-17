<!doctype html>
<html lang="{{ app()->getLocale() }}">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/png" href="/favicon.png">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="index,nofollow">
        <title>{{ env('APP_TITLE') }}</title>
        <meta name="description"
            content="RootUI - clean and powerful solution for your Dashboards, Administration areas.">
        <meta name="keywords" content="admin, dashboard, template, react, reactjs, html, jquery, clean">
        <meta name="author" content="nK">
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400%7cOpen+Sans:300,400,600%7cPT+Serif:400i">
        <link rel="stylesheet" href="{{mix('css/dashboard-app.css')}}">



        @yield('customCSS')

    </head>

    <body data-spy="scroll" data-target=".rui-page-sidebar" data-offset="140"
        class="rui-no-transition rui-navbar-autohide rui-section-lines">
        <div id="app">
            @yield('contents')
        </div>

        <script src="{{ mix('js/manifest.js') }}" defer></script>
        <script src="{{ mix('js/vendor.js') }}" defer></script>
        <script src="{{ mix('js/user-dashboard-app-vendor.js') }}" defer></script>
        <script src="{{ mix('js/user-dashboard-app.js') }}" defer></script>

        @yield('customJS')

    </body>

</html>
