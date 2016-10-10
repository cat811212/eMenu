<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Service\ShopMenuService;
use App\Service\ShopService;
use App\Service\GroupService;
use Illuminate\Support\Facades\Input;
use Redirect;
use Session;

use Validator;
class ShopMenuController extends Controller
{
 	 protected $shopMenuService;
   protected $shopService;
   protected $groupService;

 	 public function __construct(ShopMenuService $shopMenuService,ShopService $shopService,GroupService $groupService)
    {
        $this->shopMenuService = $shopMenuService;
        $this->shopService=$shopService;
        $this->groupService=$groupService;
    }

    /**
     *  @param int shop_id 店家ID 
     *  @return array array['shopInfo'] for shop array, array[menu] for menu array
     */
    public function getShopMenuPage($shop_id)
    {
      if($this->shopService->checkShop($shop_id))
        return view('client.menulist',['shopName'=>$this->shopService->getShopName($shop_id),'shopInfo'=>$this->shopService->getShopInfo($shop_id),'menu'=>$this->shopMenuService->getShopMenu($shop_id)]);
     return Redirect::to('shop')->with(array('alert'=>'fail','msg'=>'查無店家'));
    }
    public function createShopMenu()
    {
        $input=Input::all();
        $result=null;
        if(!is_numeric($input['shop-id'])||!($this->shopService->checkShop($input['shop-id'])))
          return Redirect::back()->with(array('alert'=>'fail','msg'=>'資料輸入有誤'));
        if($this->groupService->checkShopInGroup($input['shop-id']))//檢查該店是否再開團列表中
          return Redirect::back()->with(array('alert'=>'fail','msg'=>'目前該店正在開團列表中，請先刪除進行中的團再匯入菜單！'));
        $result=$this->shopMenuService->storeShopMenu($input['shop-id'],$input['shop-menu']);
        if($result==NULL)
            return Redirect::back()->with(array('alert'=>'scs','msg'=>'菜單匯入完成 ｡:.ﾟヽ(*´∀`)ﾉﾟ.:｡'));
        return Redirect::back()->with(array('alert'=>'fail','msg'=>$result));
    }

}
