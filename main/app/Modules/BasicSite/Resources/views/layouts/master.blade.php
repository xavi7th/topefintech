<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Module BasicSite</title>

       {{-- Laravel Mix - CSS File --}}
       {{-- <link rel="stylesheet" href="{{ mix('css/basicsite.css') }}"> --}}

    </head>
    <body>
        @yield('content')

        {{-- Laravel Mix - JS File --}}
        {{-- <script src="{{ mix('js/basicsite.js') }}"></script> 
        <script src="{{ mix('js/app-vendor.js') }}"></script>
		<script src="{{ mix('js/manifest.js') }}"></script>
		<script src="{{ mix('js/vendor.js') }}"></script>
		<script src="{{ mix('js/basicsite-app.js') }}"></script>
    --}}

    </body>
</html>
