@extends('layout.default')

@section('wrapper')
<section class="main clearfix">
<section class="top">	

	<div class="wrapper content_header clearfix">
  <div class="title">所有店家</div>
  <div class="btn-group">
  	<div class="form-inline">
		<a class="btn btn-primary" href="{{URL::asset('createshop')}}">新增店家</a>
	</div>
  </div>
  
</div>
		</section><!-- end top -->

		@foreach($data as $data)
			<div class="work">
			<a href="{{URL::asset('menu/'.$data['id'])}}">
				<img src="{{URL::asset('shops/img/'.$data['img'])}}" class="media" alt=""/>
				<div class="caption">
					<div class="work_title">
						<h1>{{$data['name']}}</h1>
						<p>TEL:{{$data['tel']}}</p>
						<p>{{$data['memo']}}</p>
					</div>
				</div>
			</a>
		</div>
		@endforeach
</section><!-- end main -->
@stop