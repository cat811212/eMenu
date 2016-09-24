@extends('layout.default')
@section('wrapper')
<section class="main clearfix">

		<section class="top">	
<div class="wrapper content_header clearfix">
			<div class="title">曾經的訂單</div>
			<div class="btn-group">
  </div>
</div>
		</section><!-- end top -->

		<section class="wrapper">

			<div class="content">
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
			</div><!-- end content -->
		</section>
	</section><!-- end main -->
	@stop