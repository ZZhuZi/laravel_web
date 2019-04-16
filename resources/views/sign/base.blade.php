<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>应用程序名称-@yield('title')</title>
	<link rel="stylesheet" type="text/css" href="/css/app.css" >
	<script type="text/javascript" src="/js/app.js" ></script>
</head>

<body>
	@section('sidebar')
		<!-- 这是组布局的侧边栏。 -->
	@show
	<div class="container"> 
		@yield('content')
	</div>
</body>
</html>