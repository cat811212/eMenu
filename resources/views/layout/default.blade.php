<!DOCTYPE html>
<html lang="en">
<head>
	<title>Magnetic - Stunning Responsive HTML5/CSS3 Photography Wensite Template</title>
	<meta charset="utf-8">
	<meta name="author" content="peng">
	<meta name="description" content="無聊的點餐網站"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
	@yield('meta')
	<link rel="stylesheet" type="text/css" href="{{URL::asset('css/bootstrap.css')}}">

	<link rel="stylesheet" type="text/css" href="{{URL::asset('css/reset.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('css/main.css')}}">

    <script type="text/javascript" src="{{URL::asset('js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/main.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    @yield('script')
</head>
<body>

	<header>

		<div class="logo">
			<a href="{{URL::asset('shop')}}">
			<!-- <img src="img/logo.png" title="Magnetic" alt="Magnetic"/> -->
			<p>你要吃啥？</p>
			</a>
		</div><!-- end logo -->

		<div id="menu_icon"></div>
		<nav>
			<ul>
				<li><a href="{{URL::asset('lucky')}}">我不知道要吃什麼</a></li>
				<li><a href="{{URL::asset('shop')}}">店家瀏覽</a></li>
				<li><a href="{{URL::asset('group')}}">我要訂餐</a></li>
				<li><a href="{{URL::asset('todaygroup')}}">跑腿去</a></li>
				<li><a href="{{URL::asset('shopmap')}}">地圖瀏覽</a></li>
				<li><a href="{{URL::asset('log')}}">更新辛酸史</a></li>
			</ul>
		</nav><!-- end navigation menu -->

		<div class="footer clearfix">
			<div class="rights">
				<p>made by Parallel Lab</p>
			</div><!-- end rights -->
		</div ><!-- end footer -->

	</header><!-- end header -->
	<?php $alert=Session::get('alert',null); ?>
	@if(($alert=='scs'))
		<div class="alert alert-success fade in">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  {{Session::get('msg',null)}}
		</div><!-- end success alerts -->
	@elseif($alert=='fail')
		<div class="alert alert-danger fade in">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  {{Session::get('msg',null)}}
		</div><!-- end danger alerts -->
	@endif


		@yield('wrapper')
	
</body>
</html>