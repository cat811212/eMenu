<?php
namespace App\Service;

use App\Repository\BuyListRepository;
use App\Repository\MemberRepository;
use App\Repository\ShopMenuRepository;

class BuyListService{
	
    protected $buyListRepository;
    protected $shopMenuRepository;
    protected $memberRepository;


    public function __construct(BuyListRepository $buyListRepository,MemberRepository $memberRepository,ShopMenuRepository $shopMenuRepository)
    {
        $this->buyListRepository=$buyListRepository;
        $this->memberRepository=$memberRepository;
        $this->shopMenuRepository=$shopMenuRepository;
    }
    /**
     * 取得訂單所屬的開團編號
     * @param (int)訂餐編號$order_id
     * @return NULL or (int)開團編號
     */
    public function getOrderGroup($order_id)
    {
        return $this->buyListRepository->getOrderGroup($order_id);
    }
    /** 
     * 刪除訂購
     * @param (int)訂購編號$order_id
     * @return (bool) 刪除成功回傳 true, 失敗false
     */
    public function removeOrder($order_id)
    {
        if($this->buyListRepository->removeOrder($order_id)){
            return true;
        }
            return false;

    }
    /**
     * 
     * @param (int)開團編號 $group_id
     * @param (array)訂餐編號陣列 $meal_id
     * @param (array)數量陣列 $amount
     * @param (int) 使用者ID $user_id
     * @param (string)備註 $memo
     * @return (bool) 成功儲存 true,失敗 false 
     */
    public function addOrder($group_id,$meal_id,$amount,$user_id,$memo=null)
    {
        if((count($meal_id)==count($amount))&&count($memo)==count($amount)){
            foreach ($amount as $key => $mealAmount) {
            if($mealAmount>0&&$mealAmount<35){
                if($memo[$key]==''||$memo[$key]==NULL)
                    $mealMemo=NULL;
                else
                    $mealMemo=$memo[$key];
                if(!($this->buyListRepository->addOrder($group_id,$meal_id[$key],$mealAmount,$user_id,$mealMemo)))
                    return false;
            }
        }
            return true;
        }
        return false;        
    }
    /**
     * 回傳每個人各訂什麼
     * @param (int)開團編號 $group_id
     * @return [(parent)'父餐點名稱(text)',meal=>[(0)'子餐點名稱(text)',(1)'餐點資訊細節(array)',(2)'訂餐備註(text)',(3)數量(int),(4)'訂購ID(int)'],(member)=>(string)訂餐人名稱]
     */
    public function getGroupPeopleOrder($group_id)
    {
        $order=$this->buyListRepository->getGroupOrder($group_id);
        $groupOrder=[];
        foreach ($order as $item) {
            $parent=NULL;
            $memberName=$this->memberRepository->getMemberName($item['user_id']);
            $meal=$this->shopMenuRepository->getMealInfo($item['meal_id']);
             if($meal['parent']!=null)
                $parent=$this->shopMenuRepository->getMealName($meal['parent']);
            $mealName=$this->shopMenuRepository->getMealName($item['meal_id']);
            if(isset($parent))
                $groupOrder[]=['parent'=>$parent,'meal'=>[$mealName,$meal,$item['memo'],$item['amount'],$item['id']],'member'=>$memberName];
            else
                $groupOrder[]=['parent'=>null,'meal'=>[$mealName,$meal,$item['memo'],$item['amount'],$item['id']],'member'=>$memberName];
        }
        return $groupOrder;
    }

    /**
     * 回傳訂購數量明細
     * @param (int)開團編號 $group_id
     * @return [(parent)'父餐點名稱(text)',meal=>[(0)'子餐點名稱(text)',(1)'餐點資訊細節(array)',(2)'訂餐備註(text)',(3)數量(int),(4)'訂購ID(int)'],(member)=>(string)訂餐人名稱]
     */
    public function getGroupOrder($group_id)
    {
        $order=$this->buyListRepository->getGroupOrderSortByMeal($group_id);
        $groupOrder=[];
        $mealId=-1;//當前菜單的編號
        $itemAmount=0;//該項目的數量
        $mealMemo=null;//訂餐的備註
        $repeatItem=false;//是否有重複的訂餐
        $itemMemo=null;//整合訂購的備註
        foreach ($order as $item) {
            if($mealId===$item['meal_id']){
                if($meal['price']>10){
                    if($mealMemo!=null&&strcmp($mealMemo,'')!=0)
                        $itemMemo=$mealMemo.';'.$item['memo'];
                    else
                        $itemMemo=$itemMemo.$item['memo'].';';
                    $itemAmount=$item['amount']+$itemAmount;
                    $repeatItem=true;
                    $mealMemo=null;
                    continue;
                }
                
            }
            if($mealId!=-1){//是否有上一次讀入的菜單編號
                if(!$repeatItem){ //是否有重複的訂購
                    $itemMemo=$mealMemo; //沒有重複的訂購，備註只有一項
                }
                if(isset($parent))
                    $groupOrder[]=['parent'=>$parent,'meal'=>[$mealName,$meal,$itemMemo,$itemAmount,$item['id']]];
                else
                    $groupOrder[]=['parent'=>null,'meal'=>[$mealName,$meal,$itemMemo,$itemAmount,$item['id']]];
                $mealId=-1; 
            }
            $repeatItem=false;
            $itemAmount=0;
            $parent=NULL;
            $mealId=$item['meal_id'];
            $mealMemo=$item['memo'];
            $itemAmount=$item['amount'];
            $meal=$this->shopMenuRepository->getMealInfo($item['meal_id']);
             if($meal['parent']!=null)
                $parent=$this->shopMenuRepository->getMealName($meal['parent']);
            $mealName=$this->shopMenuRepository->getMealName($item['meal_id']);

        }
        if(isset($parent)) //加入最後一個項目
            $groupOrder[]=['parent'=>$parent,'meal'=>[$mealName,$meal,$itemMemo,$itemAmount,$item['id']]];
        else
            $groupOrder[]=['parent'=>null,'meal'=>[$mealName,$meal,$itemMemo,$itemAmount,$item['id']]];
        return $groupOrder;
    }

}

?>