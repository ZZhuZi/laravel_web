<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\Permissions;


class PermissionController extends Controller
{
    // 权限列表
    public function list(){
		// $list = DB::table('permissions')->select()->paginate(2);
		// $data = [];
  //   	foreach ($list as $key => $value) {
  //   		$data[$key] = [
  //       		"id" => $value->id,
		// 	    "fid" => $value->fid,
		// 	    "name" => $value->name,
		// 	    "url" => $value->url,
		// 	    "is_menu" => $value->is_menu,
		// 	    "sort" => $value->sort
			   
  //       	];
  //   	}
  //       // dd($list);
  //    	return view('admin.permission.list1',['permissions'=>$data]);
    	return view('admin.permission.list1');
    }

    //获取权限列表
    public function getPermissionList($fid = 0){
    	$return = [
    		'code' => 2000,
    		'msg'  => '获取列表成功',
    		'data' => []
    	];
    	$list1 =  DB::table('permissions')->select()->where('fid',$fid)->paginate(2);
    	$data = [];
    	foreach ($list1 as $key => $value) {
    		$data[$key] = [
        		"id" => $value->id,
			    "fid" => $value->fid,
			    "name" => $value->name,
			    "url" => $value->url,
			    "is_menu" => $value->is_menu,
			    "sort" => $value->sort
			   
        	];
    	}
     	// $return['list'] = $list1;  // 对象
     	// $return['list'] = $data;  // 数组



    	// dd($data);
    	// dd($list);
     	$list = Permissions::getListByFid($fid);
    	// dd($list);
     	$return['list'] = $list;  // 数组

     

    	return view('admin.permission.list1',$return);

     	// return json_encode($return);
    }

   
}
