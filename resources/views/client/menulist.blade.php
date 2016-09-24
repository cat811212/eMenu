@extends('layout.default')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop
@section('script')
<script src="{{URL::asset('js/action.js')}}"></script>
<script>
	$(document).ready(function() {
		$('#shop-menu').change(function() {
			document.getElementById("upload-menu").submit();
		});
	});
</script>
@stop
@section('wrapper')
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{$shopName}}</h4>
      </div>
      <div class="modal-body">
        <img src="{{URL::asset('shops/img/'.$shopInfo[0]['img'])}}">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">我看夠了</button>
      </div>
    </div>
  </div>
</div>
<section class="main clearfix">

		<section class="top">	
			<div class="wrapper content_header clearfix">
  <div class="title">{{$shopName}}</div>
  <div class="right-group">
  <div class="form-group">
  <a class="btn btn-default" data-toggle="modal" data-target="#myModal">店家菜單</a>
  	@if(count($menu)>0)
			<a target="create-group-box" href="creategroup" class="btn btn-primary">我要開團</a>
	@endif


  		{!!Form::open(['url'=>URL::asset('importmenu'), 'method'=>'post','files'=>true,'style'=>'display:inline-block', 'id'=>'upload-menu'])!!}
  		{!!Form::hidden('shop-id',$shopInfo[0]['id'], array('id' => 'shop-id'))!!}
  		{!!Form::label('shop-menu', '匯入菜單',array('class'=>'btn btn-primary'))!!}
  		{!!Form::file('shop-menu',array('style'=>'display:none'))!!}
  		{!!Form::close()!!}
			<a action="delshop" data="{{$shopInfo[0]['id']}}" class="btn btn-danger">爛店刪掉</a>
			</div>
			<div id="create-group-box" style="display:none" class="form-inline">
	{!!Form::open(['url'=>URL::asset('creategroup'), 'method'=>'post'])!!}
<div class="form-group">
	{!!Form::hidden('group-shop-id',$shopInfo[0]['id'], array('id' => 'group-shop-id'))!!}
    {!!Form::label('group-manager-name', '誰是負責人？')!!}
    {!!Form::text('group-manager-name','',array('class' => 'form-control', 'placeholder' => '是誰？'))!!}

</div>
    {!!Form::submit('揪團去！',array('class' => 'btn btn-primary'))!!}
    <a id="cancel-create-group" class="btn btn-danger" target="create-group-box">反悔</a>
    {!!Form::close()!!}
    </div>
    </div>
  
  
  
  
</div>
		</section><!-- end top -->

		<section class="wrapper">

			<div class="content">
<div class="row">
  <div class="col-md-6">
  	<h4>電話：{{$shopInfo[0]['tel']}}</h4>
  	<h4>備註：{{$shopInfo[0]['memo']}}</h4>
  </div>
  <!-- <div class="col-md-6">
  	<div class="" id="map">
	</div>end main/map
  </div> -->
</div>
				<table class="table table-hover">
					<thead>
						<tr>
							<th class="col-md-6">名稱</th>
							<th class="col-md-6">價格</th>
							<!-- <th class="col-md-2">修改</th> -->
						</tr>
					</thead>
					<tbody>
						@foreach($menu as $data)	
						<tr>
							<th>{{$data['name']}}</th>
							<th>
								@if(count($data['child'])==0)
									<label>${{$data['price']}}/個</label>
								@else
									@foreach($data['child'] as $childMenu)
										<label>{{$childMenu['name']}}  ${{$childMenu['price']}}</label>
								<br>
								
								@endforeach
								@endif
								
								<!-- <div class="radio">
								<label>三明治 $25</label>
								<label>漢堡 $25</label>
								<label>騙人華堡 $87</label>
								</div> -->
							</th>
							<!-- <th>
								<button class="btn btn-danger">修改</button>
							</th> -->
						</tr>
						<tr>
						@endforeach
						<!-- <tr>
							<th>火腿蛋</th>
							<th>
								<div class="radio">
								<label>三明治 $25</label>
								<label>漢堡 $25</label>
								<label>騙人華堡 $87</label>
								</div>
							</th>
							<th>
								<button class="btn btn-danger">修改</button>
							</th>
						</tr>
						<tr>
							<th>培根蛋</th>
							<th>
								<div class="radio">
								<label>三明治 $25</label>
								<label>漢堡 $25</label>
								</div>
							</th>
							<th>
								<button class="btn btn-danger">修改</button>
							</th>
						</tr>
						<tr>
							<th>肉鬆蛋</th>
							<th>
								<div class="radio">
								<label>三明治 $25</label>
								<label>漢堡 $25</label>
								</div>
							</th>
							<th>
							<div class="form-inline">
								<button class="btn btn-danger">刪除</button>
								<button class="btn btn-primary">確定</button>
							</div>
								
							</th>
						</tr> -->


					</tbody>
				</table>
			</div><!-- end content -->
		</section>
	</section><!-- end main -->
	@stop