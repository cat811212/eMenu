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
}

?>