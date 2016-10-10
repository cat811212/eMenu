@extends('layout.default')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('script')
<script src="{{URL::asset('js/action.js')}}"></script>
<script>

	$(document).ready(function() {
		
		function getTotal() {
			var total=0;
			$("input[name='amount[]']").each(function() {
				if(($.isNumeric($(this).attr('price'))&&($.isNumeric($(this).val())))){
					var price=parseFloat($(this).attr('price'));
					var amount=parseInt($(this).val());
					total=price*amount+total;
			}
			});
			return total;
		}
		function getNumOfItems() {
				var items=0;
			$("input[name='amount[]']").each(function() {
				if(($.isNumeric($(this).attr('price'))&&($.isNumeric($(this).val())))){
					if($(this).val()>0)
						items++;
			}
			});
			return items;
		}	
		$("button[target='increase']").click(function(event) {
			var amountBox=$(this).parent().parent().find("div[name='amount']");
			var amountText=amountBox.text();
			var amount=0;
			if($.isNumeric(amountText)){
				amount=parseInt(amountText);
				if(amount>-1&&amount<35){
					var input=$(this).parent().parent().find("input[name='amount[]']");
					amount=amount+1;
					$(amountBox).html(amount);
					input.val(amount);
					document.getElementById("total").innerHTML=getTotal();
					document.getElementById("selected").innerHTML=getNumOfItems();
					return true;
				}	
			}
			$(amountBox).html('0');
			return false;
		});
		$("form[name='meal_list']").submit(function() {
	      if($("select[name='user']").val()==null){
	        alert("你忘記選是誰了！！");
	        return false;
	      }
	      return true;
    });
		
		$("button[target='decrease']").click(function(event) {
			var amountBox=$(this).parent().parent().find("div[name='amount']");
			var amountText=amountBox.text();
			var amount=0;
			if($.isNumeric(amountText)){
				amount=parseInt(amountText);
				if(amount>0&&amount<35){
					amount=amount-1;
					$(amountBox).html(amount);
					$(this).parent().parent().find("input[name='amount[]']").val(amount);
					document.getElementById("total").innerHTML=getTotal();
					document.getElementById("selected").innerHTML=getNumOfItems();

					return true;
				}	
			}
			$(amountBox).html('0');
			return false;
		});
	})
</script>
@stop
@section('wrapper')

{!!Form::open(['url'=>URL::asset('addorder'),'method'=>'post','name'=>'meal_list','autocomplete'=>'off'])!!}
{!!Form::hidden('group_id',$group_id)!!}
    
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{$shopName}}</h4>
      </div>
      <div class="modal-body">
      <p>你是誰？</p>
      <select name="user" class="form-control">
      <option disabled selected>選一下你是誰吧！</option>
      	@foreach($member as $data)
      	<option value="{{$data['id']}}">{{$data['name']}}</option>	
      	@endforeach
      	

      </select>
         <table class="table table-hover">
					<thead>
						<tr>
							<th class="col-md-3">名稱</th>
							<th class="col-md-9">選項</th>
						</tr>
					</thead>
					<tbody>
						@foreach($menu as $data)	
						<tr>
							<th>{{$data['name']}}</th>
							<th>
								@if(count($data['child'])==0)
									<div class="row">
										<div class="col-sm-offset-2 col-sm-2">
											<!-- <input name="order-meal[]" value="{{$data['id']}}" type="checkbox" price="{{$data['price']}}"> -->	
											 <input type="hidden" name="order-meal[]" value="{{$data['id']}}">
											<span>
											 {!!Form::label($data['id'], $data['price'].'元')!!}
											</span>
										</div>
										<div class="col-sm-3">	
											 <div class = "input-group">
								               <span class = "input-group-btn">
								                  <button class = "btn btn-default" type = "button" target="increase">+
								                  </button>
								               </span>
								               <div name="amount" class = "form-control">0</div>
								                <input price="{{$data['price']}}" type="hidden" name="amount[]" value="0">
								               <span class = "input-group-btn">
								                  <button class ="btn btn-default" type = "button" target="decrease">-
								                  </button>
								               </span>
								            </div><!-- /input-group -->
										</div>
										<div class="col-sm-5">
											<input name="memo[]" type = "text" class = "form-control" placeholder="要提醒什麼？">
										</div>
									</div>								
								@else
									@foreach($data['child'] as $childMenu)
									<div class="row">
									<div class="col-sm-2">
										{!!Form::label($childMenu['id'], $childMenu['name'])!!}
									</div>
											<div class="col-sm-2">
												<input name="order-meal[]" value="{{$childMenu['id']}}" type="hidden">
												<span> {{$childMenu['price'].'元'}}</span>
											
											</div>
											<div class="col-sm-3">
											<div class = "input-group">
								               <span class = "input-group-btn">
								                  <button class = "btn btn-default" type = "button" target="increase">+
								                  </button>
								               </span>
								               <div name="amount" class = "form-control">0</div>
								               <input price="{{$childMenu['price']}}" type="hidden" name="amount[]" value="0">
								               <span class = "input-group-btn">
								                  <button class ="btn btn-default" type = "button" target="decrease">-
								                  </button>
								               </span>
								               </div>
								            </div><!-- /input-group -->
								            <div class="col-sm-5">
											<input name="memo[]" type = "text" class = "form-control" placeholder="要提醒什麼？">
										</div>
										</div>
								@endforeach
								@endif	
								</th>	
						</tr>
						@endforeach
					</tbody>
				</table>
      </div>
      <div class="modal-footer">
      <div class="well well-sm">
      	你共選了 <div id="selected" style="display:inline-block;">0</div> 項 總計：<div id="total" style="display:inline-block;">0</div>元
      </div>
        {!!Form::submit('我訂好了',array('class' => 'btn btn-primary btn-block'))!!}   
      </div>
    </div>
  </div>
</div>
{!!Form::close()!!}


<section class="main clearfix">
		<section class="top">	
			<div class="wrapper content_header clearfix">
  <div class="title">{{$shopName}}</div>
  <div class="right-group">
  	<div class="form-inline">
		<a class="btn btn-primary" data-toggle="modal" data-target="#myModal">我要訂餐</a>
		<a action="removegroup" data="{{$group_id}}" class="btn btn-danger">不爽爛團</a>
		<a action="stopgroup" data="{{$group_id}}" class="btn btn-warning">訂餐截止</a>
	</div>
  </div>
  
  
  
</div>
		</section><!-- end top -->
		<section class="wrapper">

			<div class="content">
			<div class="form-inline">
</div>
				<table class="table table-hover">
					<thead>
						<tr>
							<th class="col-md-2">名稱</th>
							<th class="col-md-4">訂購內容</th>
							<th class="col-md-1">數量</th>
							<th class="col-md-1">總額</th>
							<th class="col-md-2">備註</th>
							<th class="col-md-2">操作</th>

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
							<th>
								<a action="removeorder" data="{{$list['meal'][4]}}" class="btn btn-danger">刪除</a><!-- 刪除 -->
							</th>
						</tr>
					@endforeach


					</tbody>
				</table>
			</div><!-- end content -->
		</section>
		</section><!-- end main -->
		@stop
	