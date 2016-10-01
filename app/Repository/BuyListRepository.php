<?php
namespace App\Repository;

use App\BuyList;
class BuyListRepository{
	protected $buy_list;

    public function __construct(BuyList $buy_list)
    {
        $this->buy_list = $buy_list;
    }
    /**
     * 依照指定團回傳訂餐餐點
     * @param (int)團編號 group_id
     * @return (obj)訂餐資料 [(int)group_id,(int)user_id,(int)meal_id,(int)amount,(string)memo]
     */
    public function getGroupOrder($group_id)
    {
         return $this->buy_list->where('group_id',$group_id)->get();
    }
    /**
     * 依照指定團回傳訂餐餐點，依照餐點序號排序
     * @param (int)團編號 group_id
     * @return (obj)訂餐資料 [(int)group_id,(int)user_id,(int)meal_id,(int)amount,(string)memo]
     */
    public function getGroupOrderSortByMeal($group_id)
    {
        return $this->buy_list->where('group_id',$group_id)->orderBy('meal_id','desc')->get();

    }
    public function removeOrder($order_id)
    {
        return $this->buy_list->find($order_id)->delete();
    }
    public function addOrder($group_id,$meal_id,$amount,$user_id,$memo=null)
    {
        return $this->buy_list->create(['group_id' => $group_id,'user_id' => $user_id,'meal_id' => $meal_id,'amount'=>$amount,'memo' => $memo]);
    }

    public function getOrderGroup($order_id)
    {
        return $this->buy_list->find($order_id)->group_id;
    }
}

?>