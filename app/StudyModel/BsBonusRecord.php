<?php

namespace App\StudyModel;

use Illuminate\Database\Eloquent\Model;

class BsBonusRecord extends Model
{
    //
    protected $table = 'bs_bonus_record';
    /*
	* 创建数据
	* 传入参数 array
    */
    public static function createRecord($data){
    	$res = self::insert($data);
    	return $res;
    }

    /*
	* 获取最大金额的红包
    */
    public static function getMaxBonus($bonusId){
    	$res = self::select('id')
    	    ->where('bonus_id',$bonusId)
    		->orderBy('money','desc')
    		->first();

    	return $res;
    }

	/*
	* 修改红包记录
    */
    public static function updateBonusRecord($data,$id){
    	$res = self::where('id',$id)->update($data);
    	return $res;
    }
    
    /*
	* 获取是否抢过的记录id
    */
    public static function getRecordById($userId,$bonusId){
    	$res = self::where('user_id',$userId)
    	->where('bonus_id',$bonusId)
    	->first();
    	return $res;
    }

}
