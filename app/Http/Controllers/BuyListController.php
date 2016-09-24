<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Service\BuyListService;
use App\Service\GroupService;
use App\Service\ShopService;
use App\Service\ShopMenuService;
use App\Service\MemberService;

use Illuminate\Support\Facades\Input;
use Redirect;

use Validator;
class BuyListController extends Controller
{
 	protected $buyListService;
    protected $shopService;
    protected $shopMenuService;
    protected $groupService;
    protected $memberService;

 	 public function __construct(BuyListService $buyListService,ShopService $shopService,GroupService $groupService,ShopMenuService $shopMenuService,MemberService $memberService)
    {
        $this->buyListService = $buyListService;   
        $this->shopService = $shopService;
        $this->groupService = $groupService;
        $this->shopMenuService=$shopMenuService;
        $this->memberService=$memberService;


    }
    public function removeOrder()
    {
        $order_id=Input::all()['order_id'];

        if(!is_numeric($order_id)){
            return Redirect::back()->with(array('alert'=>'fail','msg'=>'資料錯誤'));
        }
        $group_id=$this->buyListService->getOrderGroup($order_id);

        //get Group state
        $groupState=$this->groupService->getGroupState($group_id);
        if($groupState>0||$groupState<0)
            return Redirect::back()->with(array('alert'=>'fail','msg'=>'團購已經結束了，你無法再修改！'));
        if($this->buyListService->removeOrder($order_id)){
            return Redirect::back()->with(array('alert'=>'scs','msg'=>'餐點已移除了！'));
        }
        return Redirect::back()->with(array('alert'=>'fail','msg'=>'資料庫錯誤'));
    }
    public function addOrder()
    {
        $input=Input::all();
        if(!is_numeric($input['group_id']))
            return Redirect::to('group')->with(array('alert'=>'fail','msg'=>'資料輸入有誤'));
        $groupState=$this->groupService->getGroupState($input['group_id']);
        if($groupState>0)
            return Redirect::to('group')->with(array('alert'=>'fail','msg'=>'團購已經結束了，你沒跟到！'));
        if(!$this->groupService->checkGroup($input['group_id']))
            return Redirect::to('group')->with(array('alert'=>'fail','msg'=>'該訂購不存在！'));
       if($this->buyListService->addOrder($input['group_id'],$input['order-meal'],$input['amount'],$input['user'],$input['memo'])){
            return Redirect::back()->with(array('alert'=>'scs','msg'=>'餐點送出了！ :-)'));
       }
        return Redirect::back()->with(array('alert'=>'fail','msg'=>'資料庫錯誤'));
    }
    public function getGroupOrderPage($group_id)
    {
   //     echo($this->buyListService->getGroupOrderPage($group_id)['']);
        if(!is_numeric($group_id))
            return Redirect::to('group')->with(array('alert'=>'fail','msg'=>'資料輸入有誤'));
        $shop_id=$this->groupService->getGroupShop($group_id);
        if($shop_id==null||$shop_id=='')
            return Redirect::to('group')->with(array('alert'=>'fail','msg'=>'該訂購不存在!'));
        $shopName=$this->shopService->getShopName($shop_id);
        if($shop_id==null||$shop_id=='')
            return Redirect::to('group')->with(array('alert'=>'fail','msg'=>'資料建構錯誤'));
        if(!$this->groupService->checkGroup($group_id))
            return Redirect::back()->with(array('alert'=>'fail','msg'=>'該訂購不存在！'));
        $groupState=$this->groupService->getGroupState($group_id);
        if($groupState==0)
            return view('client.buylist',['shopName'=>$this->shopService->getShopName($shop_id),'shopInfo'=>$this->shopService->getShopInfo($shop_id),'group_id' =>$group_id,'order' => $this->buyListService->getGroupOrder($group_id),'menu' => $this->shopMenuService->getShopMenu($shop_id),'member' => $this->memberService->getAllMember()]);
        else if($groupState==1)
            return view('client.historybuylist',['shopName'=>$this->shopService->getShopName($shop_id),'shopInfo'=>$this->shopService->getShopInfo($shop_id),'group_id' =>$group_id,'order' => $this->buyListService->getGroupOrder($group_id),'menu' => $this->shopMenuService->getShopMenu($shop_id),'member' => $this->memberService->getAllMember()]);
        return Redirect::back()->with(array('alert'=>'fail','msg'=>'未知錯誤'));
    //    return $this->buyListService->getGroupOrder($group_id);
     //   var_dump (['shop' => $shopName]);
      //  return ['shop' => $shopName,'order' => $this->buyListService->getGroupOrder($group_id),'menu' => $this->shopMenuService->getShopMenu($shop_id)];
    	
    }
    
}
?>