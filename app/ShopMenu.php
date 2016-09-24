<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopMenu extends Model
{
    protected $table = 'shop_menu';
    protected $fillable =['shop_id','name','price','parent'];
    public $timestamps  = false;

}
