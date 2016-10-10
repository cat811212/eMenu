<?php
namespace App\Service;
use App\Service\FileService;
use App\Repository\ShopRepository;

class ShopService{

	 protected $shopRepository;

	public function __construct(ShopRepository $shopRepository)
	{
		$this->shopRepository=$shopRepository;
	}
	public function delShop($shop_id)
	{
		return $this->shopRepository->delShop($shop_id);
	}
	public function getShopName($shop_id){
		return $this->shopRepository->getShopName($shop_id);
	}

	public function createShop($name,$tel=null,$memo=null,$lat=null,$lng=null,$input_file)
	{
		$fileService=new FileService(base_path().'/public/shops/img');
		$file_name=$fileService->storeShopImg($input_file);
		if($file_name!=false){
			return $this->shopRepository->createShop($name,$tel,$memo,$lat,$lng,$file_name);
		}
		return false;
	}
	public function checkShop($shop_id)
	{
		if($this->shopRepository->checkShop($shop_id))
			return true;
		return false;
	}
	public function getAllShop()
	{
		return $this->shopRepository->getAllShop();
	}
	public function getShopInfo($shop_id)
	{
		return $this->shopRepository->getShopInfo($shop_id);
	}
	public function randomShop()
	{
		$max=$this->shopRepository->getLastShopId();
		
		for ($i=0; $i < 10; $i++) { 
			$shop_id=rand(0,$max);
			if($this->checkShop($shop_id))
				return $shop_id;
		}
		return null;
		
	}
}

?>