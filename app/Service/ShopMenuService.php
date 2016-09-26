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
    private function removeAllMenu($shop_id)
    {
        return $this->shopMenuRepository->removeAllMenu($shop_id);
    }
    /**
     * 建立店家菜單
     * @param (int) shop_id 店家ID
     * @param (string) $menu_file 檔案名稱
     * @return NULL表示店家完成新增 (string)表示錯誤訊息
     */
    public function storeShopMenu($shop_id,$menu_file)
    {
        $path=base_path().'/public/shops/menu';
        $fileService=new FileService($path);
        $file_name=$fileService->storeMenuFile($menu_file);
        $menu=array();
        if($file_name!=false){
            $this->shopRepository->updateMenu($shop_id,$file_name);
            try {
                $menu=$this->checkMenuFile($shop_id,$path.'/'.$file_name);
                $this->removeAllMenu($shop_id); //刪除所有該店家菜單
                $this->createMenu($shop_id,$menu);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }else{
            return '請上傳csv檔案！！';
        }
        return NULL;
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

    /**
     * 檢查CSV菜單
     * @param (int) shop_id 店家ID
     * @param (string) $file_path 檔案路徑
     * @return (array) [(string)name 主菜單名稱,(int)價格或(array)子菜單[(string)childname 子菜單名稱,(int)子菜單價格]]
     */
    private function checkMenuFile($shop_id,$file_path)
    {
        $row=0;
        $childList=array();
        $menuList=array();
        if (($handle = fopen($file_path, "r")) !== FALSE) {
            //做檔案檢查，不新增至資料庫
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row++;
                $num = count($data);
                $haveChild=false;
                $haveInsert=false;
                $parentId=-1;
                if($num>1&&$num<10){
                    $haveInsert=false;
                    for ($c=0; $c < $num; $c++) {
                        if($c==0){
                            if(!is_string($data[0])||strcmp($data[0],'')===0||$data[0]===null||ctype_space($data[0])){              //檢查父菜單名稱是否為字串，不能為空資料
                                fclose($handle);
                                throw new \Exception("在第{$row}行，第".($c+1)."列該名稱有錯誤，菜名不能都是空白或該欄位格式錯誤？？");
                            }

                        }else{
                            if(is_numeric($data[1])){ //第二筆資料如果只有數字，表示沒有子菜單
                                $menuList[]=array('name'=>$data[0],'price'=>$data[1]);
                                $haveInsert=true;
                                break;
                            }else{
                                $childMenu=explode(' ',$data[$c]);
                                if(count($childMenu)!=2){ //檢查子菜單格式是否正確 應以空格隔出菜名與價格
                                    fclose($handle);
                                    throw new \Exception("在第{$row}行，第".($c+1)."行少了空白還是多了逗號？？"); //0指菜單名稱錯誤                     
                                }
                                if(!is_string($childMenu[0])||strcmp($childMenu[0],'')===0||$childMenu[0]===null||ctype_space($childMenu[0])){  //應為子菜名 (字串)
                                    fclose($handle);
                                    throw new \Exception("在第{$row}行，第".($c+1)."列該名稱有錯誤，菜名不能都是空白或該欄位格式錯誤？？");  //0指菜單名稱錯誤
                                }
                                if(!is_numeric($childMenu[1])){   //應為價格 (數字)
                                    fclose($handle);
                                    throw new \Exception("在第{$row}行，第".($c+1)."列 '{$childMenu[1]}' 該項金額有錯誤，數字裡面夾雜其他非數字字元！！");//1指菜單金額錯誤
                                }
                                $childList[]=array('childname'=>$childMenu[0],'childprice'=>$childMenu[1]);
                            }
                        }
                }    
                if(!$haveInsert){
                    $menuList[]=array('name'=>$data[0],'price'=>$childList);
                    $childList=array(); //子菜單陣列清空
                }
                
            }else{
                fclose($handle);
                throw new \Exception("在第{$row}行有超出或少於欄位！！");//上傳檔案列數錯誤
            }
    }
    }else{
        fclose($handle);
        throw new \Exception("伺服器檔案錯誤，請通知管理員！@_@");//cannot open file
    }//檔案開啟錯誤else程式結束
        fclose($handle);
        return $menuList;
    }
    /**
     * 透過傳入陣列建立菜單
     * @param (int) shop_id 店家ID
     * @param (array) $menuList 菜單陣列
     * @return throw expection 錯誤訊息 
     */
    private function createMenu($shop_id,$menuList)
    {
        $row=0;
        foreach ($menuList as $key => $value) {
            $row++;
            if(count($value['price'])>1&&count($value['price'])<10){
                $parentId=$this->shopMenuRepository->createMeal($shop_id,$value['name'],0,null);
                if($parentId>0){
                    foreach ($value['price'] as $priceKey => $priceValue) {
                        if(!$this->shopMenuRepository->createMeal($shop_id,$priceValue['childname'],$priceValue['childprice'],$parentId))
                                throw new \Exception("資料庫在第{$row}行建立資料時發生錯誤 @_@");//資料庫處理時發生錯誤              
                    }
                } 
            }else if(count($value['price'])==1){
                if(!$this->shopMenuRepository->createMeal($shop_id,$value['name'],$value['price'],null))
                        throw new \Exception("資料庫在第{$row}行建立資料時發生錯誤 @_@");//資料庫處理時發生錯誤    
            }else{
                throw new \Exception("資料庫在第{$row}行計算列數時發生錯誤 @_@");//上傳檔案列數錯誤
            }   
        }
        }
}

?>