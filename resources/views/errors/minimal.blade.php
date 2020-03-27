<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="format-detection" content="telephone=no">
	<title>@yield('title')</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('/assets/site/css/app.css') }}">
</head>
<body class="error">
	<div class="error-container">
		<a href="{{ route('site.home.index') }}" class="error-logo"><img src="preview/400/255/images/logo-big.png" alt="sportliga.com"></a>
		<div class="error-number">
			@yield('code')
		</div>	
    	<h2>@yield('message')</h2>
    	<p>@yield('description')</p>
    	<hr>
    	<p>Вы можете перейти на <a href="{{ route('site.home.index') }}">Главную страницу</a><br>или воспользоваться <a href="{{ route('site.sitemap.index') }}">Картой&nbsp;сайта</a>.</p>
	</div>
</body>
</html>
