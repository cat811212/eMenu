@extends('layout.default')
@section('wrapper')
<section class="main clearfix">
  <section class="top"> 
    <div class="wrapper content_header clearfix">
      <div class="title">更新辛酸史</div>
      <div class="btn-group">
    <div class="form-inline">
  </div>
  </div>
</div>
    </section><!-- end top -->

    <section class="wrapper">

      <div class="content">
      <dl>
        <dt><h3>2016/10/11 問題修正</h3></dt>
        <dd>資料庫結構修改</dd>
        <dd>修正匯入菜單後導致找不到之前菜單的問題(non-object)</dd>
        <dd>修正團購截止、刪除時會提示選擇使用者</dd>
        <dd>新增確認視窗以免有人手殘按錯</dd>
        <dd>本週懶得做付款功能！</dd>
        <dt><h3>2016/10/3 功能新增</h3></dt>
        <dd>多了懶人訂單明細</dd>
        <dd>跑腿去列表順序調整</dd>
        <dd>以後記得選你是誰！！</dd>
        <dt><h3>2016/09/26 錯誤修正</h3></dt>
        <dd>地圖店家點擊錯誤修正</dd>
        <dd>匯入菜單格式檢查改善</dd>
        <dd>匯入菜單格式錯誤修正</dd>
        <dd>回傳訊息字體改善</dd>
        <dd>新增店家頁面多了警告訊息</dd>
        <dt><h3>2016/09/24 GitHub導入</h3></dt>
        <dt><h3>2016/09/23 系統正式上線</h3></dt>
        <dd>感謝博班彭學長IP資訊協助</dd>
        <dt><h3>2016/08/23 確認網頁版型後正式開工</h3></dt>
        <dd>一條不歸路的開始</dd>
      </dl>

      </div><!-- end content -->
    </section>
  </section><!-- end main -->
  @stop