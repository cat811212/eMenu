<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ShopMenu extends Model
{
	use SoftDeletes;
    protected $table = 'shop_menu';
    protected $fillable =['shop_id','name','price','parent'];
}
