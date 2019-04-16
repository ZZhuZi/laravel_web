<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    //
    protected $table = 'admin_users';
    /*
	* @desc 通过用户名获取用户
	* @param $username 
	* @return array
    */
	public static function getUserByName($username){
		$userInfo = self::where('username',$username)
					->where('status',2)
					->first();
			
			// dump($userInfo);exit;		
		// DB::connection()->enableQueryLog();  // 开启QueryLog
		// \App\User::find(1);
		// dump(DB::getQueryLog());
		return $userInfo;
	}

}
