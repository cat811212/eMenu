@extends('layout.default')
@section('script')
<script>
  $(document).ready(function () {
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
      });
  });
  
</script>
@stop
@section('wrapper')
<section class="main clearfix">
<section class="wrapper">
<div class="content">
{!!Form::open(['url'=>URL::asset('createshop'), 'method'=>'post','files'=>true])!!}
<div class="form-group">
    {!!Form::label('shop-name', '店名')!!}
    {!!Form::text('shop-name','',array('class' => 'form-control', 'placeholder' => '店家名稱'))!!}
</div>
<div class="form-group">
    {!!Form::label('shop-tel', '店家電話')!!}
    {!!Form::text('shop-tel','',array('class' => 'form-control', 'placeholder' => '有電話的店家不代表可以外送'))!!}
</div>
<div class="form-group">
    {!!Form::label('shop-memo', '備註')!!}
    {!!Form::text('shop-memo','',array('class' => 'form-control', 'placeholder' => '營業時間、活魚只能生吃'))!!}
</div>
<div class="form-group">
  	{!!Form::label('shop-image', '上傳菜單照片(圖檔)')!!}
  	{!!Form::file('shop-image')!!}
  </div>

    {!!Form::hidden('shop-lat','121.7791801', array('id' => 'shop-lat'))!!}
    {!!Form::hidden('shop-lng','25.1499395', array('id' => 'shop-lng'))!!}
    <label for="shop-map">店家在哪裡？(請找到店家後點擊地圖建立位置)</label>
    <div class="form-group">
    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
    <div id="small-map"></div>
    </div>
  

    {!!Form::submit('上傳',array('class' => 'btn btn-primary btn-block'))!!}
    {!!Form::close()!!}
</div>
</div>
</section>
</section><!-- end main -->
    <script type="text/javascript" src="{{URL::asset('js/map.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBpD7XIePZMQ5IFX4D7PUWBPG1Yxc4T-Uo&libraries=places&callback=initAutocomplete"></script>
@stop