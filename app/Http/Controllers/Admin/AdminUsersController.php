<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Role;
use App\Tools\ToolsAdmin;
use App\Model\AdminUsers;
use App\Model\UserRole;

use Illuminate\Support\Facades\DB;
use Log;
class AdminUsersController extends Controller
{
        // $user = DB::table('study_lottery_user')->where('phone',$phone)->first();
    //
    /*
	* 用户添加页面
    */
    public function create(){
    	$role = new Role();
    	$assign['roles'] = $role ->getRoles(); // 获取角色列表
        // dd($assign);
    	return view('admin.users.create',$assign);
    }

    /*
	* @desc 执行用户添加操作
	* @param  $request array
    */
    public function store(Request $request){
    	$params = $request ->all();  
        // dd($params);
    	// 文件上传
    	$image_url = ToolsAdmin::uploadFile($params['image_url']);
        // dd($image_url);

    	try{
    		DB::beginTransaction(); // 开启事物
    		$adminUser = new AdminUsers();
    		$data = [
    			'username' => $params['username'] ?? '',
    			'password' => md5($params['password']) ?? '',
    			'image_url' => $image_url ?? '',
    			'is_super' => $params['is_super'] ?? 1,
    			'status' => $params['status'] ?? 1
    		];

			$adminUser->addRecord($data);

            // dd($adminUser);
			$id = $adminUser->getMaxId(); // 获取最新添加的用户id

			// 添加用户和角色关联关系
			$userRole = new UserRole();
			$data1 = [
				'user_id' => $id->id,
				'role_id' => $params['role_id'] ?? 0
			];
			$userRole->addUserRole($data1);
			DB::commit(); // 提交事物
    	}catch(\Exception $e){
    		DB::rollBack(); // 事物回滚
    		log::error('用户添加失败'.$e->getMessage());
    		return redirect()->back();
    	}
    	return redirect('/admin/user/list');
    }

    /*
	* 用户列表页面
    */
    public function list(){
    	$list = AdminUsers::getList();
        // dd($list);
    	return view('admin.users.list',['list' =>$list]);
    }

    /*
	* 用户删除操作
    */
    public function delUser($id){
    	
    	try{
			AdminUsers::del($id);

			$userRole = new UserRole();

			$userRolel->delByUserId($id); //删除用户角色关联关系；

    	}catch(\Exception $e){
    		// DB::rollBack(); // 事物回滚
    		log::error('用户删除失败'.$e->getMessage());
    		return redirect('/admin/user/list');
    	}
    }

    /*
	* @desc 用户编辑
	* @param  $id
    */
    public function edit($id){
		$role = new Role();
    	$assign['roles'] = $role->getRoles(); //获取角色列表
    	$userRole =  new UserRole();
    	$assign['role_id'] = $userRole->getByUserId($id)->role_id ?? 0;
    	$assign['user']  =AdminUsers::getUserById($id); //获取用户的信息

    	return view('admin.users.edit',$assign);
    }

    /*
	* @desc 执行用户编辑
	* @param  $id
    */
    public function doEdit(Request $request){
    	$params = $request ->all();  

    	// 文件上传
    	$image_url = '';
    	if(!empty($params['image_url'])){
    		$image_url = ToolsAdmin::uploadFile($params['image_url']);
    	}

    	try{
    		DB::beginTransaction(); // 开启事物
    		$adminUser = new AdminUsers();
    		$data = [
    			'username' => $params['username'] ?? '',
    			'is_super' => $params['is_super'] ?? 1,
    			'status' => $params['status'] ?? 1
    		];
			if(!empty($image_url)){
				$data['image_url'] = $image_url;
			}
			$adminUser->updateUser($data,$params['id']);

			// 添加用户和角色关联关系
			$userRole = new UserRole();

			//先删除之前的关联记录
			$userRole->delByUserId($params['id']);

			$data1 = [
				'user_id' => $params['id'],
				'role_id' => $params['role_id'] ?? 0
			];
			$userRole->addUserRole($data1);
			DB::commit(); // 提交事物
    	}catch(\Exception $e){
    		DB::rollBack(); // 事物回滚
    		log::error('用户添加失败'.$e->getMessage());
    		return redirect()->back()->with('error_msg',$e->getMessage());
    	}
    	return redirect('/admin/user/list');
    }


}
