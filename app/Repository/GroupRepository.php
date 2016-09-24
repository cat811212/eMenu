<?php
namespace App\Repository;

use App\GroupBuying;
class GroupRepository{
	protected $groupbuying;
    
    
    public function __construct(GroupBuying $groupbuying)
    {
        $this->groupbuying = $groupbuying;
    }
    /**
     * 檢查是否有該訂購團編號
     * @param (int)訂購團編號 $group_id
     * @return NULL or (obj) 對應編號團購資料
     */
    public function checkGroup($group_id)
    {
        return $this->groupbuying->find($group_id);
    }
    /**
     * 取得團購訂單狀態
     * @param (int)訂購團編號 $group_id
     * @return NULL or (int)狀態編號 1為截止, 0為開放訂購
     */
    public function getGroupState($group_id)
    {
        return $this->groupbuying->find($group_id)['state'];
    }
    public function getAllGroup()
    {
          return $this->groupbuying->where('state','0')->orderBy('created_at','desc')->get();
    }
    public function createGroup($shop_id,$manager)
    {
        return $this->groupbuying->create(['shop_id' => $shop_id ,'manager' =>$manager]);
    }
    public function removeGroup($group_id)
    {
        return $this->groupbuying->find($group_id)->delete();
    }
    public function stopGroup($group_id)
    {
        return $this->groupbuying->find($group_id)->update(['state'=>1]);
    }
    /**
     * 將所有關於店家的開團全部關閉
     * @param (int)店家編號 $shop_id
     * @return (int)影響的開團資料數
     */   
    public function stopGroupBelongShop($shop_id)
    {
        return $this->groupbuying->where('shop_id',$shop_id)->update(['state'=>1]);
    }
    /**
     * 取得指定日期訂購截止列表
     * @param (string)日期 yyyy-mm-dd
     * @return (array)[(obj)團購資料]
     */
    public function getDateStopGroup($date)
    {
        return $this->groupbuying->where('state','1')->whereBetween('updated_at',[$date.' 00:00:00',$date.' 23:59:59'])->get();
    }
    /**
     * 取得歷史訂購
     * @return NULL or (Array)[(obj)歷史訂購資料]
     */
    public function getHistoryGroup()
    {
        return $this->groupbuying->where('state','1')->get();
    }
    /**
     * 復原刪除訂購團
     * @param (int)訂購團編號$group_id
     * @return NULL or (obj)更動完一筆資料
     */
    public function restoreGroup($group_id)
    {
        return $this->groupbuying->find($group_id)->restore();
    }
    /**
        *@param (int) groupId
        *@return (int) shop_id 
    */
    public function getShopId($group_id)
    {
        return $this->groupbuying->find($group_id)['shop_id'];
    }
}

?>