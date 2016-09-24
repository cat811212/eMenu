<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuyList extends Model
{
    protected $table = 'buylist';
    protected $fillable =['group_id','user_id','meal_id','amount','memo'];

    public function setUpdatedAt($value) {
    	return null;
	}
}
