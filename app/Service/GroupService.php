<?php
namespace App\Service;

use App\Repository\GroupRepository;
use App\Repository\ShopRepository;

class GroupService{
	
    protected $GroupRepository;

    public function __construct(GroupRepository $groupRepository,ShopRepository $shopRepository)
    {
        $this->groupRepository=$groupRepository;
        $this->shopRepository=$shopRepository;
    }
    /**
     * 檢查該店家是否有開團進行中
     * @param (int)店家編號
     * @return (bool)存在回傳true, 不存在回傳false
     */
    public function checkShopInGroup($shop_id)
    {
        if($data=$this->groupRepository->getShopInGroups($shop_id)){
            foreach ($data as $group) {
                if($group['state']==0){
                    return true;
                }
            }
        }
        return false;
    }
    /**
     * 檢查店家是否已存在資料庫
     * @param (int)店家編號
     * @return (bool)存在回傳true, 不存在回傳false
     */
    private function shopIsDel($shop_id)
    {
        if($this->shopRepository->shopIsDel($shop_id)==null){
            return true;
        }
        return false;
    }
    public function stopGroupBelongShop($shop_id)
    {
        return $this->groupRepository->stopGroupBelongShop($shop_id);
    }
    public function getAllGroup()
    {
        $group=$this->groupRepository->getAllGroup();
        $group_arr=array();
        foreach ($group as $item) {
            $shop_name=$this->shopRepository->getShopName($item['shop_id']);
            $group_arr[]=['id' => $item['id'],
                        'shop' => $shop_name,
                        'manager' => $item['manager'],
                        'created_at' => $item['created_at']
                        ];
        }
        return $group_arr;
    }
    public function getHistoryGroup()
    {
        $group=$this->groupRepository->getHistoryGroup();
        $group_arr=array();
        foreach ($group as $item) {
            $shop_name=$this->shopRepository->getShopName($item['shop_id']);
            if(!$this->shopIsDel($item['shop_id']))
                $shop_name=$shop_name.'  (店家已被刪除)';
            $group_arr[]=['id' => $item['id'],
                        'shop' => $shop_name,
                        'manager' => $item['manager'],
                        'created_at' => $item['created_at']
                        ];
        }
        return $group_arr;
    }
    /**
     * 檢查訂購團是否存在
     * @param (int)訂購編號 $group_id
     * @return (bool)存在回傳 true, 不存在回傳false
     */
    public function checkGroup($group_id)
    {
        if($this->groupRepository->checkGroup($group_id))
            return true;
        return false;
    }
    /**
     * 取得指定日期訂餐截止的團購
     * @param (timestamp) 日期
     * @return (array)[(obj) 團購資料] or NULL
     */
    public function getDateStopGroup($time)
    {
        $group=$this->groupRepository->getDateStopGroup($time);
        $group_arr=array();
        foreach ($group as $item) {
            $shop_name=$this->shopRepository->getShopName($item['shop_id']);
            if($this->shopIsDel($item['shop_id'])){
                $group_arr[]=['id' => $item['id'],
                        'shop' => $shop_name,
                        'manager' => $item['manager'],
                        'created_at' => $item['created_at']
                        ];
            }
            
        }
        return $group_arr;
    }
    public function getGroupState($group_id)
    {
        return $this->groupRepository->getGroupState($group_id);
    }
    public function createGroup($shop_id,$manager)
    {
        return $this->groupRepository->createGroup($shop_id,$manager);
    }
    public function getGroupShop($group_id)
    {
        return $this->groupRepository->getShopId($group_id);
    }
    public function removeGroup($group_id)
    {
        return $this->groupRepository->removeGroup($group_id);
    }
    public function stopGroup($group_id)
    {
        return $this->groupRepository->stopGroup($group_id);
    }
}
?>