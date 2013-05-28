<!DOCTYPE html> 
<html>
<head>
	<title>3FDS Admnistrator Panel</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	{{ Asset::container('mobile')->styles() }}
</head>

<body>
<div data-role="page" data-theme="d" id="container" data-url="container">
	<div data-role="panel" id="sidebar" data-theme="d" data-content-theme="a"  data-display="overlay">
		{{$sidebar}}
	</div>
	<div data-role="header" data-theme="d" data-position="fixed">
		<h4><small>3FDS Admnistrator Panel</small></h4>
		<a href="#sidebar" data-icon="bars" data-iconpos="notext">Navigation</a>
	</div>
	<div data-role="content">@yield('content')</div>
	<!-- <div data-role="footer"></div> -->
</div>
	{{ Asset::container('mobile')->scripts() }}
	@yield('scripts');
</body>
</html>