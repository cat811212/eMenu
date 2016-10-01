<?php
namespace App\Service;

use App\Repository\MemberRepository;

class MemberService{
	
    protected $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository=$memberRepository;
    }
    public function getMemberName($member_id)
    {
        return $this->memberRepository->getMemberName($member_id);
    }
    public function getAllMember()
    {
        return $this->memberRepository->getAllMember();
    }
    /**
     * 檢查使用者是否存在
     * @param (int)使用者編號
     * @return (bool)存在回傳true, 不存在回傳false
     */
    public function checkMember($user_id)
    {
        if($this->memberRepository->checkMember($user_id)){
            return true;
        }
        return false;
    }
}

?>