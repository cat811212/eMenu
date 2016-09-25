<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/','ShopController@getAllShop');
Route::get('group','GroupController@getAllGroup');
Route::get('group/history','GroupController@getHistoryGroup');
Route::get('stopgroup','GroupController@getAllStopGroup');
Route::get('todaygroup','GroupController@getTodayStopGroup');
Route::get('lucky','ShopController@randomShop');

Route::get('group/{groupId}','GroupController@showGroupDetail');
Route::post('order/removeorder','BuyListController@removeOrder');
Route::post('order/removegroup','GroupController@removeGroup');
Route::post('order/stopgroup','GroupController@stopGroup');
Route::post('creategroup','GroupController@creategroup');
Route::post('addorder','BuyListController@addOrder');
Route::post('menu/delshop','ShopController@delShop');
Route::post('importmenu','ShopMenuController@createShopMenu');

Route::get('menu/{shopId}','ShopMenuController@getShopMenuPage');

Route::get('order/{groupId}','BuyListController@getGroupOrderPage');
Route::get('shop','ShopController@getAllShop');
Route::get('log','PageController@logPage');
Route::get('shopmap','ShopController@shopMapPage');
Route::get('createshop','ShopController@createShopPage');
Route::post('createshop','ShopController@storeShop');