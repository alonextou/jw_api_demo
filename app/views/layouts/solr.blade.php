<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Catalog</title>
		<link rel="stylesheet" href="/css/app.css" />
		<script src="/bower_components/modernizr/modernizr.js"></script>
	</head>
	<body>

		<nav class="top-bar" data-topbar>
			<ul class="title-area">
				<li class="name">
					<h1><a href="/">Home</a></h1>
				</li>
				<li class="toggle-topbar menu-icon"><a href="/">Menu</a></li>
			</ul>
			<section class="top-bar-section">
				<ul class="right">
					<li class="has-dropdown">
						<a href="#">Catalog: {{ Config::get('catalog.'.Session::get('catalog')) }}</a>
						<ul class="dropdown">
						@foreach(Config::get('catalog') as $key => $val)
							<li><a href="/catalog/{{ $key }}">{{ $val }}</a></li>
						@endforeach
						</ul>
					</li>
					<li class="has-dropdown">
						<a href="#">Language: {{ Config::get('language.'.Session::get('language')) }}</a>
						<ul class="dropdown">
						@foreach(Config::get('language') as $key => $val)
							<li><a href="/language/{{ $key }}">{{ $val }}</a></li>
						@endforeach
						</ul>
					</li>
				</ul>
			</section>
			<section class="top-bar-section">
				<ul class="left">
					<li><a href="/solr/product">Products</a></li>
				</ul>
			</section>
		</nav>

		<div id="content" class="row">
			@yield('content')
		</div>

		<script src="/bower_components/jquery/dist/jquery.min.js"></script>
		<script src="/bower_components/foundation/js/foundation.min.js"></script>
		<script src="/js/dist/global.js"></script>
	</body>
</html>
