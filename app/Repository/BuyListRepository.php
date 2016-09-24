<?php
namespace App\Repository;

use App\BuyList;
class BuyListRepository{
	protected $buy_list;

    public function __construct(BuyList $buy_list)
    {
        $this->buy_list = $buy_list;
    }
    public function getGroupOrder($group_id)
    {
         return $this->buy_list->where('group_id',$group_id)->get();
         // return $this->buy_list->find($group_id)->join('shop_menu','buylist.meal_id','=','shop_menu.id')->join('member','buylist.user_id','=','member.id')->select('*','shop_menu.name as meal_name','member.name as member_name')->get();
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