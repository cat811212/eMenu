<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\ShopInfo;
use App\Service\ShopService;
use App\Service\GroupService;
use Illuminate\Support\Facades\Input;
use Redirect;
use Session;
use Validator;
class ShopController extends Controller
{
 	protected $shopService;
    protected $groupService;

 	 public function __construct(ShopService $shopService,GroupService $groupService )
    {
        $this->shopService = $shopService;
        $this->groupService = $groupService;
    }
    public function delShop()
    {
        $shop_id=Input::all()['shop_id'];
 //       return $this->shopService->delShop($shop_id);
        if(!is_numeric($shop_id))
            return Redirect::back()->with(array('alert'=>'fail','msg'=>'資料輸入有誤'));
        if($this->shopService->delShop($shop_id)){
            $this->groupService->stopGroupBelongShop($shop_id);
            return Redirect::back()->with(array('alert'=>'fail','msg'=>'爛店被刪掉了！'));
        }
        return Redirect::back()->with(array('alert'=>'fail','msg'=>'一個未被歸類的錯誤 :('));
    }
    public function getAllShop()
    {
    	return view('client.allshop',['data'=>$this->shopService->getAllShop()]);
    }
    public function createShopPage()
    {
    	return view('client.createshop');
    }
    public function storeShop()
    {
    	$input=Input::all();
        if($input['shop-name']==''||$input['shop-name']==null)
            return Redirect::to('shop')->with(array('alert'=>'fail','msg'=>'你忘記輸入店家名稱'));
    	if($this->shopService->createShop($input['shop-name'],$input['shop-tel'],$input['shop-memo'],$input['shop-lat'],$input['shop-lng'],Input::file('shop-image'))!=false){
    		return Redirect::to('shop')->with(array('alert'=>'scs','msg'=>'店家新增成功'));
    	}
    	return Redirect::to('shop')->with(array('alert'=>'fail','msg'=>'發生一件忘記被分類的錯誤，店家新增失敗'));
    }
    public function shopMapPage()
    {   
    	return view('client.shopmap',['shopInfo'=> $this->shopService->getAllShop()]);
    }
    public function randomShop()
    {
        $shop_id=$this->shopService->randomShop(); 
        if($shop_id==null||$shop_id=='')
            return '發生錯誤！:(';
        return Redirect::to('menu/'.$shop_id)->with(array('alert'=>'scs','msg'=>'剛剛幫你決定這家，考慮看看吧！！'));
        // $shop_info=$this->shopService->getShopInfo($shop_id)[0];
        // return ['shopName'=>$this->shopService->getShopName($shop_id),'shop_id'=>$shop_info->id,'shop_img'=>$shop_info->img];
    }  
    
}
?>