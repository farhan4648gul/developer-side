<!DOCTYPE html> 
<html>
<head>
	<title>3FDS Admnistrator Panel</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
</head>

<body>
<div data-role="page" data-theme="d" id="container" data-url="container">
	<div data-role="header" data-theme="d" data-fullscreen="true">
		<h4><small>3FDS Admnistrator Panel</small></h4>
	</div>
	<div data-role="content" data-theme="d" >
		@yield('login')
	</div>
	<div data-role="footer" data-theme="d"  data-position="fixed" ><h4><small>Copyright© 2013</small></h4></div>
</div>
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
	@yield('scripts')
</body>
</html>