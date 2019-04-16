<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    //
    protected $table = "user_role";

    // public $timestamps = false;

    /*
	*添加用户角色记录
    */
    public function addUserRole($data){
    	return self::insert($data);
    }

    /*
	* 删除userId记录
    */
    public function delByUserId($userId){
    	return self::where('user_id',$userId)->delete();
    }

     /*
	* 删除userId记录
    */
    public function delByRoleId($roleId){
    	return self::where('role_id',$roleId)->delete();
    }

     /*
	* 删除userId记录
    */
    public function getByUserId($userId){
    	return self::where('user_id',$userId)->first();
    }

}
