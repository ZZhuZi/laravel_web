<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Tools\ToolsAdmin;

class Permissions extends Model
{
    //
    protected $table = 'permissions';
 	const 
 	    IS_MENU = 1,     //是菜单
 	    IS_NI_MENU = 2,   // 不是菜单
 	    END = true;
 	/*
	* 获取左侧菜单栏的权限数据
	* @return array
 	*/
	public static function getMenus($user=[]){
		$permissions = self::select('id','fid','name','url')

				->where('is_menu',self::IS_MENU)
				->orderBy('sort')
				->get()
				->toArray();   //转化为数组
			// dd($permissions);

		$leftMenu = ToolsAdmin::buildTree($permissions);	
			// dd($leftMenu);
		
		return $leftMenu;
	}

	/*
	* 获取权限列表
	* @return array
	*/
	public static function getListByFid($fid = 0){
		$list = self::select('id','fid','name','url','is_menu','sort')
							->where('fid',$fid)
							->orderBy('sort')
							->get()
							->toArray();
		return $list;
	}

	/*
	* 添加权限
	* @return bool
	*/
	public static function addRecord($data){
		return self::insert($data);
	} 

	/*
	* 删除权限的函数
	*/
	public static function delRecord($id){
		return self::where('id',$id)->delete();
	}

	/*
	* 通过权限的主键id获取权限的url地址集合
	* @return array
	*/
	public static function getUrlsByIds($pids){
		$list = self::select('url')
							->whereIn('id',$pids)
							->get()
							->toArray();
		$urls = [];
		foreach($permissions as $key => $value){
			$urls[] = $value['url'];
		}
		return $urls;
	}


}
