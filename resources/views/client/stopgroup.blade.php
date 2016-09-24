@extends('layout.default')
@section('wrapper')
<section class="main clearfix">

		<section class="top">	
<div class="wrapper content_header clearfix">
			<div class="title">今天已截止的訂購明細</div>
			<div class="btn-group">
  	<div class="form-inline">
		<a class="btn btn-primary" href="{{URL::asset('group/history')}}">過去的訂單</a>
		<!-- <ul class="list-inline">
		<li>基隆</li>
		<li>晴時暴雨 ˚∆˚</li>
		<li>目前溫度：25˚</li>
		<li>降雨機率：87%</li>
	</ul> -->
	</div>
  </div>
</div>
		</section><!-- end top -->

		<section class="wrapper">

			<div class="content">
			@if(count($data)>0)
			@foreach($data as $item)
				<div class="groups">
				<div class="group-link">
					<div class="info">
						<div class="title">
						<h3><a href="{{URL::asset('order/'.$item['id'])}}">{{$item['shop']}}</a></h3>
						</div>
						<div class="meta">
							<ul class="list-inline">
								<li>於</li>
								<li>{{$item['created_at']}}</li>
								<li>由</li>
								<li>{{$item['manager']}}</li>
								<li>發起</li>
							</ul>
						</div>
					</div>

				</div>
				</div>
				@endforeach
				@else
					<h2>今天還沒有訂單成立！ XDDD</h2>
				@endif
			</div><!-- end content -->
		</section>
	</section><!-- end main -->
	@stop