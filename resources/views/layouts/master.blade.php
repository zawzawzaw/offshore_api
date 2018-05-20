<html>
<head>
	@include('includes.head')
</head>
<body>

<header id="header">
  @include('includes.header')
</header>

@if(Auth::check())
	
@endif

@yield('banner')

<section id="main-content">	 
  @yield('content')
</section>

<footer id="footer">
  @include('includes.footer')
</footer>

</body>
</html>
