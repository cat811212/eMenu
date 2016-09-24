<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Service\GroupService;
use Illuminate\Support\Facades\Input;
use Redirect;

use Validator;
class GroupController extends Controller
{
 	protected $groupService;

 	 public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }
    public function recoverGroup()
    {
        # code...
    }
    
    public function getHistoryGroup()
    {
        return view('client.historygroup',['data' => $this->groupService->getHistoryGroup()]);

    }
    public function getAllGroup()
    {
   //     var_dump ($this->groupService->getAllGroup());
        return view('client.group',['data' => $this->groupService->getAllGroup()]);
    }
    public function getTodayStopGroup()
    {
        $today = getdate();
        $date=$today['year'].'-'.$today['mon'].'-'.$today['mday'];
        return view('client.stopgroup',['data' => $this->groupService->getDateStopGroup($date)]);
    }
    public function createGroup()
    {
    	$input=Input::all();
        if(!is_numeric($input['group-shop-id'])||($input['group-manager-name']==''||$input['group-manager-name']==null))
            return Redirect::back()->with(array('alert'=>'fail','msg'=>'資料輸入有誤！(忘記打團購人名稱？)'));
        if($data=$this->groupService->createGroup($input['group-shop-id'],$input['group-manager-name']))
            return Redirect::to('order/'.$data['id'])->with(array('alert'=>'scs','msg'=>'號招同學來訂餐吧！'));
        return Redirect::to('group')->with(array('alert'=>'fail','msg'=>'一個未被歸類的錯誤 :('));
    }
    public function stopGroup()
    {
        $group_id=Input::all()['group_id'];
        if(!is_numeric($group_id))
            return Redirect::to('group')->with(array('alert'=>'fail','msg'=>'資料輸入有誤'));
        if(!($this->groupService->checkGroup($group_id)))
            return Redirect::to('group')->with(array('alert'=>'fail','msg'=>'訂購團已不存在'));
        if($this->groupService->stopGroup($group_id)){
            return Redirect::to('group')->with(array('alert'=>'scs','msg'=>'你剛剛結束了一波團購，沒訂到的人叫他吃自己'));
        }
        return Redirect::to('group')->with(array('alert'=>'fail','msg'=>'一個未被歸類的錯誤 :('));
    }
    public function removeGroup()
    {
        $group_id=Input::all()['group_id'];
        if(!is_numeric($group_id))
            return Redirect::to('group')->with(array('alert'=>'fail','msg'=>'資料輸入有誤'));
        if(!($this->groupService->checkGroup($group_id)))
            return Redirect::to('group')->with(array('alert'=>'fail','msg'=>'訂購團已不存在'));
        if($this->groupService->removeGroup($group_id))
            return Redirect::to('group')->with(array('alert'=>'scs','msg'=>'已刪除指定團購'));
        return Redirect::to('group')->with(array('alert'=>'fail','msg'=>'一個未被歸類的錯誤 :('));
    }

    
}
?>