<?php
namespace App\Repository;

use App\ShopInfo;
use App\ShopName;

class ShopRepository{
	protected $shop_info;
    protected $shop_name;

    
    public function __construct(ShopInfo $shop_info,ShopName $shop_name)
    {
        $this->shop_info = $shop_info;
        $this->shop_name = $shop_name;
    }
    public function delShop($shop_id)
    {
        return $this->shop_name->find($shop_id)->delete();
    }
    public function checkShop($shop_id)
    {
        return $this->shop_name->find($shop_id);
    }
	public function getAllShop(){
    	return $this->shop_name->join('shop_info','shop_info.id','=','shop_name.id')->get();
    }	
    public function getAllShopLocation()
    {
    	return $this->shop_name->select(array('id','tel','memo','lat','lng'))->get();
    }
    public function getShopName($shop_id)
    {
        return $this->shop_name->withTrashed()->find($shop_id)->name;
    }
    public function shopIsDel($shop_id)
    {
        return $this->shop_name->withTrashed()->find($shop_id)->deleted_at;
    }
    public function getShopInfo($shop_id)
    {
    	return $this->shop_info->where('id',$shop_id)->get();
    }
    public function createShop($name,$tel=null,$memo=null,$lat=null,$lng=null,$img=null)
    {
        $name_id=$this->shop_name->create(['name' => $name])->id;
    	return $this->shop_info->create(array('id' => $name_id,'tel' => $tel,'memo' => $memo,'img' => $img , 'lat' => $lat,'lng' => $lng));
    }
    public function updateMenu($shop_id,$file_name)
    {
        return $this->shop_info->where('id',$shop_id)->update(['menu'=>$file_name]);
    }
    public function getLastShopId()
    {
        return $this->shop_name->orderBy('id', 'desc')->first()->id;
    }
}

?>