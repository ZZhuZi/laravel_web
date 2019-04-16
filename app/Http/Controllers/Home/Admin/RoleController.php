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
class RoleController extends Controller
{
    //展示角色
    public function list(){
    	$roles = new Role();
    	$assign['role_list'] = $roles->getRoles();
    	// dd($assign);
    	return view('admin.roles.list',$assign);

    }

    // 角色添加
    public function create(){
    	return view('admin.roles.create');
    }
    /*
	* @desc 执行角色添加操作
    */
	public function store(Request $request){
		$params = $request->all();
		$role = new Role();

		$data = [
			'role_name' =>$params['role_name'] ?? "",
			'role_desc' =>$params['role_desc'] ?? "",
		];
		// dd($data);
		
		$res = $role->addRole($data);

		if(!$res){
			return redirect()->back();
		}
		return redirect('/admin/role/list');
	}

}
