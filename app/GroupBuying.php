<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class GroupBuying extends Model
{
	use SoftDeletes;

    protected $table = 'groupbuying';
    protected $fillable =['shop_id','manager','state'];
    protected $dates = ['deleted_at'];
    
    public function setUpdatedAt($value) {
    	return null;
	}

}
