<?php

namespace App\StudyModel;

use Illuminate\Database\Eloquent\Model;

class BsBonus extends Model
{
    //数据表
    protected $table = 'bs_bonus';
    /*
    * 获取红包信息
    */
    public static function getBonusInfo($id){
    	$bonus = self::where('id',$id)->first();
    	return $bonus;
    }
    /*
    * 修改红包信息
    */
    public static function updateBonusInfo($data,$id){
    	$res = self::where('id',$id)->update($data);
    	return $res;
    }

    public static function addBonus($data){
        $res = self::insert($data);
        return $res;
    }



}
