@extends('layout.default')
@section('wrapper')

<section class="main clearfix">
		<section class="top">	
			<div class="wrapper content_header clearfix">
  <div class="title">{{$shopName}}</div>
<div class="btn-group">
  	<div class="form-inline">
		<a class="btn btn-primary" href="{{URL::asset('order/'.$group_id.'?view=people')}}">其他人訂了什麼？</a>
	</div>
  </div>
  <?php $total=0;$items=0;
  foreach($order as $list){
  	$items=1+$items;
  	$total=$list['meal'][1]['price']*$list['meal'][3]+$total;
  }


  ?>
  
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
							<th class="col-md-4">訂購內容</th>
							<th class="col-md-1">數量</th>
							<th class="col-md-1">總額</th>
							<th class="col-md-3">備註</th>

						</tr>
					</thead>
					<tbody>
					@foreach($order as $list)

						<tr>
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
				<div class="order-total" style="text-align: right;margin: 15px 0; color: #FFF;background-color: #328bca;padding: 10px;">
  	總共有&nbsp<div id="selected" style="font-size: 24px;display:inline-block;">{{$items}}</div>&nbsp項&nbsp&nbsp&nbsp總計：&nbsp<div id="total" style="font-size: 24px;display:inline-block;">{{$total}}</div>&nbsp元
  </div>
			</div><!-- end content -->
		</section>
		</section><!-- end main -->
		@stop
	