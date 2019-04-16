<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdPosition extends Model
{
    //
    protected $table = "jy_ad_position";
    public $timestamps = false;

    //执行添加
    public function doAdd($data){
    	return  self::insert($data);
    }

    public function getList(){
    	return self::get()->toArray();
    }

    public function del($id){
    	return self::where('id',$id)->delete();
    }

    public function edit($id){
    	return self::where('id',$id)->updata();
    }
}
