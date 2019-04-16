<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\AdminUser;
class LoginController extends Controller
{
    //
    public function login(){
 		return view('admin.login');
 	}
 	public function index(Request $request){
 		// $session = $request->session();
 		// if($session->has('user')){          // 如果存在session 信息的话可以不登录
 		// 	return redirect('/admin/login');
 		// }
 		return view('admin.login');
 	}
	public function doLogin(Request $request){
		$params = $request->all();
		// dd($params);
		$return = [
			'code' => 2000,
			'msg'  => '登录成功'
		];
		// 用户名不能为空
		if(!isset($params['username']) || empty($params['username'])){
			$return = [
				'code' => 4001,
				'msg'  => '用户名不能为空'
			];
			return json_encode($return);
		}
		// 密码不能为空
		if(!isset($params['password']) || empty($params['password'])){
			$return = [
				'code' => 4002,
				'msg'  => '密码不能为空'
			];
			return json_encode($return);
		}

		// 通过用户名获取用户的信息
		$userInfo = AdminUser::getUserByName($params['username']);
		// dd($userInfo);

		//用户不存在
		if(empty($userInfo)){
			$return = [
				'code' => 4003,
				'msg'  => '用户不存在'
			];
			return json_encode($return);
		}else{
			$postPwd = md5($params['password']);
			if($postPwd !== $userInfo->password){
				$return = [
					'code' => 4001,
					'msg'  => '密码错误',
				];
				return json_encode($return);
			}else{
				$session = $request ->session(); // 获取session的值
				// 储存用户id
				$session ->put("user.user_id",$userInfo->id);   // 用户id
				$session ->put("user.username",$userInfo->username);  // 用户名
				$session ->put("user.image_url",$userInfo->image_url); //图片信息
				$session ->put("user.is_super",$userInfo->is_super); //是否超管

				return json_encode($return);
			}
			

		}

	}

	/*
	*用户退出的页面
	*/
	public function loginout(Request $request){
		$request->session()->forget('user');
		return redirect('/admin/login');
	}
}
