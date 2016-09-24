@extends('layout.default')
@section('wrapper')
<section class="main clearfix">
	<section class="top">	
		<div class="wrapper content_header clearfix">
			<div class="title">進行中的訂單</div>
			<div class="btn-group">
  	<div class="form-inline">
		<a class="btn btn-primary" href="{{URL::asset('group/history')}}">過去的訂單</a>
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
						<h3>
							<a href="order/{{$item['id']}}">{{$item['shop']}}</a>
							<small>&nbsp於&nbsp{{$item['created_at']}}&nbsp由&nbsp{{$item['manager']}}&nbsp發起</small>
						</h3>
						</div>
					</div>

				</div>
				</div>
				@endforeach
			@else
				<h2>沒有人開團，當然沒有團可以訂~</h2>
			@endif
			</div><!-- end content -->
		</section>
	</section><!-- end main -->
	@stop