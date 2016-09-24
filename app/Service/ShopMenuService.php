<?php
namespace App\Service;

use App\Repository\ShopMenuRepository;
use App\Repository\ShopRepository;
use App\Service\FileService;
class ShopMenuService{
	
    protected $shopMenuRepository;
    protected $shopRepository;

    public function __construct(ShopMenuRepository $shopMenuRepository,ShopRepository $shopRepository)
    {
        $this->shopMenuRepository=$shopMenuRepository;
        $this->shopRepository=$shopRepository;
    }
    /**
     * 刪除所有店家菜單
     * @param (int)店家id
     * @return
     */
    public function removeAllMenu($shop_id)
    {
        return $this->shopMenuRepository->removeAllMenu($shop_id);
    }
    /**
     * 建立店家菜單
     * @param (int)店家id
     * @param (object)菜單檔案
     * @return
     */
    public function storeShopMenu($shop_id,$menu_file)
    {
        $path=base_path().'/public/shops/menu';
        $fileService=new FileService($path);
        $file_name=$fileService->storeMenuFile($menu_file);
        if($file_name!=false){
            $this->shopRepository->updateMenu($shop_id,$file_name);
            $this->createMenu($shop_id,$path.'/'.$file_name);
            return true;
          //  return $this->shopRepository->createShop($name,$tel,$memo,$lat,$lng,$file_name);
        }
        return false;
    }
    /**
     *  @param int shop_id 店家ID 
     *  @return array ('shop' , 'menu')
     */
    public function getShopMenu($shop_id)
    {
        $menuArr=array();
        $parentMenuArr=$this->shopMenuRepository->getParentMenu($shop_id);
        if($parentMenuArr==null||$parentMenuArr=='')
            return null;
        foreach ($parentMenuArr as $parentMeal) {
            $childMenuArr=$this->shopMenuRepository->getChildMenu($parentMeal['id']);
            $menuArr[]=array(   'id' => $parentMeal['id'],
                                'shop_id' => $parentMeal['shop_id'],
                                'name' => $parentMeal['name'],
                                'price' => $parentMeal['price'],
                                'child' => $childMenuArr
                            );
        }
        return $menuArr;
    //    echo(array('shop'=>$this->shopRepository->getShopInfo($shop_id),'menu'=>$this->shopMenuRepository->getShopMenu($shop_id)));
    //    return ['shop' => $this->shopRepository->getShopInfo($shop_id),'menu'=>$menuArr];
    }
    private function createMenu($shop_id,$file_path)
    {
        if (($handle = fopen($file_path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                $haveChild=false;
                $parentId=-1;
                 for ($c=0; $c < $num; $c++) {
                    if(!strcmp($data[$c],'')||$data[$c]===null)
                        break;

                     if($c==0){
                        if(!is_string($data[$c]))
                            return false; 
                      
                    }else{
                        $childMenu=explode(' ',$data[$c]);
                        if(count($childMenu)==2){
                            $haveChild=true;
                            if($parentId<0){
                                $parentId=$this->shopMenuRepository->createMeal($shop_id,$data[0],0,null);
                            }
                            
                        }
                        if($haveChild){
                            if(!is_string($childMenu[0]))  //應為子菜名 (字串)
                                return false; 
                            if(is_numeric($childMenu[1])){   //應為價格 (數字)
                                echo "價格:$childMenu[1]<br />";
                                if($parentId>0){
                                    $this->shopMenuRepository->createMeal($shop_id,$childMenu[0],$childMenu[1],$parentId);
                                }
                            }else{
                            //    var_dump('價格應為數字');
                                return false; 
                            }
                        }else{
                            if(is_numeric($data[$c])){
                                $this->shopMenuRepository->createMeal($shop_id,$data[0],$data[$c],null);
                            }else{
                            //    var_dump('價格應為數字');
                                return false;
                            }
                        }
                        
                    }
                
         }
    }
    }else{
        return false;//cannot open file
    }
        fclose($handle);
        return true;
    
    }
}

?>