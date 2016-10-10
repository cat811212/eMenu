<?php
namespace App\Repository;

use App\ShopMenu;
class ShopMenuRepository{
	protected $shop_menu;

    public function __construct(ShopMenu $shop_menu)
    {
        $this->shop_menu = $shop_menu;
    }

    public function editMenu($meal_id)
    {
        # code...
    }
    public function removeAllMenu($shop_id)
    {
        return $this->shop_menu->where('shop_id',$shop_id)->delete();
    }
    public function createMeal($shop_id,$name,$price,$parent=null)
    {
        return $this->shop_menu->create(['shop_id' => $shop_id,'name' => $name, 'price' => $price , 'parent' => $parent])->id;
    }
    public function getParentMenu($shop_id)
    {
        return $this->shop_menu->whereNull('parent')->where('shop_id',$shop_id)->get();
    }
    public function getMealName($meal_id)
    {
        return $this->shop_menu->withTrashed()->find($meal_id)->name;
    }
    // /**
    //  * 取得已經移除的餐點名稱
    //  * @param (int)餐點編號
    //  * @return (obj)餐點資料
    //  */
    // public function getTrashedMealName($meal_id)
    // {
    //     return $this->shop_menu->onlyTrashed()->findOrFail($meal_id)->name;
    // }
    public function getChildMenu($meal_id)
    {
        return $this->shop_menu->withTrashed()->where('parent',$meal_id)->get();
    }
    public function getMealInfo($meal_id)
    {
        return $this->shop_menu->withTrashed()->find($meal_id);
    }


}

?>