@extends('layout.default')
@section('wrapper')

<section class="main clearfix">
		<section class="top">	
			<div class="wrapper content_header clearfix">
  <div class="title">{{$shopName}}</div>
  <div class="btn-group">
  <div class="form-inline">
  <?php $total=0;$items=0;
  foreach($order as $list){
  	$items=1+$items;
  	$total=$list['meal'][1]['price']*$list['meal'][3]+$total;
  }


  ?>
      總共有 <div id="selected" style="display:inline-block;">{{$items}}</div> 項 總計：<div id="total" style="display:inline-block;">{{$total}}</div>元
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
</div>
				<table class="table table-hover">
					<thead>
						<tr>
							<th class="col-md-2">名稱</th>
							<th class="col-md-4">訂購內容</th>
							<th class="col-md-1">數量</th>
							<th class="col-md-1">總額</th>
							<th class="col-md-3">備註</th>

						</tr>
					</thead>
					<tbody>
					@foreach($order as $list)

						<tr>
							<th>{{$list['member']}}</th>
							<th>
								@if($list['parent']==null)

								<label>{{$list['meal'][0]}} ${{$list['meal'][1]['price']}}</label>
								@else
									<label>{{$list['parent']}} {{$list['meal'][0]}} ${{$list['meal'][1]['price']}}</label>
								@endif
							</th>
							<th>{{$list['meal'][3]}}</th>
							<th>{{$list['meal'][1]['price']*$list['meal'][3]}}</th>
							<th>{{$list['meal'][2]}}</th>
						</tr>
					@endforeach


					</tbody>
				</table>
			</div><!-- end content -->
		</section>
		</section><!-- end main -->
		@stop
	