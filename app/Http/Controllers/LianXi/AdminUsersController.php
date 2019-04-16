<?php

namespace App\Http\Controllers\LianXi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AdminUsers;
use App\Tools\ToolsAdmin;
use Illuminate\Support\Facades\DB;

class AdminUsersController extends Controller
{
/*****************************************************************************8*/
	//用户展示页面
	public function list(){
		return view('admin/users/list1');
		// dd(1);
		// return view('admin/users/list1',['list'=>$list]);
		// return redirect('/admin/users/list');   //区别   路由 重定向即跳转
	}

	public function getList(Request $request){
		// $list = AdminUsers::getList();
		
		// dd($list);
		// return json_encode($list);

		$return = [
			'code'=>2000,
			'msg' =>"获取列表成功",
			'data'=>[]
		];
		$list = AdminUsers::getList();
							// ->toArray();
		$return['data'] = $list;
		// dd($return);
		return json_encode($return);

	}
/*****************************************************************************8*/
    //用户添加页面
	public function create(){
		return view('admin/users/list');
	}

    //用户执行添加操作
	public function store(Request $reqeust){
		$params = $request->all();
		// return redirect('/admin/user/list1'); 
		// return json_encode($return);
	}
	 //用户执行添加操作1    用接口方式
	public function store1(Request $reqeust){
		

	}
/*****************************************************************************8*/
    //用户修改页面
    public function edit(){
		return view('admin/users/list');
	}
    //用户执行修改操作
/*****************************************************************************8*/
    //用户删除操作
}
