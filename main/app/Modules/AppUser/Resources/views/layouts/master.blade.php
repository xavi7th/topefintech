<!doctype html>
<html lang="{{ app()->getLocale() }}">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, shrink-to-fit=no">
		<link rel="icon" type="image/png" href="/favicon.png">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="robots" content="noindex,nofollow">
		<title>{{ env('APP_TITLE') }}</title>

		@yield('customCSS')

	</head>

	<body>
		<div id="app">
			@yield('contents')
		</div>

		<script src="{{ mix('js/dashboard-app-vendor.js') }}"></script>
		<script src="{{ mix('js/manifest.js') }}"></script>
		<script src="{{ mix('js/vendor.js') }}"></script>
		<script src="{{ mix('js/dashboard-app.js') }}"></script>

		@yield('customJS')
		<script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>

		<!--Start of Tawk.to Script-->
		<script type="text/javascript">
			var Tawk_API = Tawk_API || {},
				Tawk_LoadStart = new Date();
			( function () {
				var s1 = document.createElement( "script" ),
					s0 = document.getElementsByTagName( "script" )[ 0 ];
				s1.async = true;
				s1.src = 'https://embed.tawk.to/5dcb84b2d96992700fc72a37/default';
				s1.charset = 'UTF-8';
				s1.setAttribute( 'crossorigin', '*' );
				s0.parentNode.insertBefore( s1, s0 );
			} )();
		</script>
		<!--End of Tawk.to Script-->

	</body>

</html>
