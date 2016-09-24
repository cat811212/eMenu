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
        return $this->shop_menu->find($meal_id)->name;
    }
    public function getChildMenu($meal_id)
    {
        return $this->shop_menu->where('parent',$meal_id)->get();
    }
    public function getMealInfo($meal_id)
    {
        return $this->shop_menu->find($meal_id);
    }


}

?>