<?php
namespace App\Service;
use Validator;
class FileService{

	protected $file_path;

	public function __construct($path){
		$this->file_path=$path;
	}
	/**
	 * 店家圖片上傳
	 * @param (object) 檔案物件
	 * @return (string)檔案名稱 上傳失敗則回傳(bool) false
	 */
	public function storeShopImg($input_file)
	{
		if($this->uploadImgCheck($input_file,'shop-img')){
			return $this->uploadFile($input_file,$this->file_path);
		}
		return false;
	}
	/**
	 * 店家菜單上傳
	 * @param (object) 檔案物件
	 * @return (string)檔案名稱 上傳失敗則回傳(bool) false
	 */
	public function storeMenuFile($input_file)
	{
		if($this->uploadCSVCheck($input_file,'shop-menu')){
			return $this->uploadFile($input_file,$this->file_path);
		}
		return false;
	}
	/**
	 * 上傳檔案
	 * @param (object) 檔案物件
	 * @param (string) 上傳路徑
	 * @return (string) 上傳後建檔的檔名 上傳失敗 (bool) false
	 */
	private function uploadFile($input_file,$path)
	{
		$destinationPath = $path; // upload path
		$nameArray=array();
		$fileName=null;
		$extension = $input_file->getClientOriginalExtension();		
		$fileName = uniqid().'.'.$extension; // renameing image

		// array_push($nameArray, ['filename'=>$fileName,'origname'=>$value->getClientOriginalName()]);
		if(!$input_file->move($destinationPath, $fileName)){ // uploading file to given path
			die("Couldn't upload file");
			return false;
		}
		return $fileName;
	}
	/**
	 * 上傳csv檔案檢查
	 * @param (object) 檔案物件
	 * @param (string) 檔案欄位名稱
	 * @return 檢查通過回傳(bool) true, 未通過回傳(bool) false
	 */
	private function uploadCSVCheck($input_file,$field_name)
	{
		$file = array($field_name => $input_file);
		$rules = array($field_name =>'required|file|max:2048');
		$messages = array('file'=>'檔案超過2MB',);
		$validator = Validator::make($file, $rules,$messages);
		$extension = $input_file->getClientOriginalExtension();
		if ($validator->fails()||(strcmp($extension,'csv')!==0&&strcmp($extension,'CSV')!==0)){
		// 	$err_messages = $validator->messages();
		// 	foreach ($err_messages->all() as $err_message)
		// {
		// 	echo $err_message;
		// }
			return false;
		}else{
			// foreach ($input_file as $value) {
			// 	if(!($value->isValid())){			
			//    		return 2;
			// 	}
			// }
			return true;		
		}
		return false;
	}
	/**
	 * 上傳圖檔檢查
	 * @param (object) 檔案物件
	 * @param (string) 檔案欄位名稱
	 * @return 檢查通過回傳(bool) true, 未通過回傳(bool) false
	 */
	private function uploadImgCheck($input_file,$field_name)
	{
		$file = array($field_name => $input_file);
		$rules = array($field_name =>'required|image|file|max:2048');
		$messages = array('file'=>'檔案超過2MB',);
		$validator = Validator::make($file, $rules,$messages);
		
		if ($validator->fails()) {
		// 	$err_messages = $validator->messages();
		// 	foreach ($err_messages->all() as $err_message)
		// {
		// 	echo $err_message;
		// }
			return false;
		}else{
			// foreach ($input_file as $value) {
			// 	if(!($value->isValid())){			
			//    		return 2;
			// 	}
			// }
			return true;		
		}
		return false;
	}

}

?>