<?php
namespace App\Repository;

use App\Member;
class MemberRepository{
	protected $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }
    public function getMemberName($member_id)
    {
        return $this->member->find($member_id)->name;
    }
   	public function getAllMember()
   	{
   		return $this->member->all();
   	}
    public function checkMember($user_id)
    {
      return $this->member->find($user_id);
    }
}

?>