<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ShopName extends Model
{
	use SoftDeletes;
    protected $table = 'shop_name';
    protected $fillable =['name'];
    public $timestamps  = false;
    protected $dates = ['deleted_at'];
    
    public function setUpdatedAt($value) {
    	return null;
	}

}
