<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopInfo extends Model
{
    protected $table = 'shop_info';
    protected $fillable =['id','tel','memo','lat','lng','img','menu'];
    public $timestamps  = false;

    public function shopName()
    {
    	return $this->hasMany('App\ShopName');
    }
    
}
