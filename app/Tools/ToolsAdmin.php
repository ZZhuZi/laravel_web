<?php 
namespace App\Tools;
// use App\Model\UserRole;
// use App\Model\PolePermission;

/*
* 公共方法
*/
class ToolsAdmin
{
	/*
	* 无限极分类的数据组装函数
	* @param $array $data
	* @param $fid 父类id
	*/
	public static function buildTree($data,$fid=0){
		if(empty($data)){
			return [];
		}
		static $menus = []; // 定义一个静态变量，用来储存无限级分类的数据

		foreach ($data as $key => $value) {
			if($value['fid'] == $fid){       // 当前循环的内容中fid是否等于函数fid参数
				if(!isset($menus[$fid])){   // 如果数据没有fid的key
					$menus[$value['id']] = $value;
				}else{
					$menus[$fid]['son'][$value['id']] = $value;
				}
				unset($data[$key]);
				self::buildTree($data,$value['id']); //执行递归调用
			}
		}
		return $menus;

	}

	//创建无限级分类树的结构
	public static function buildTreeString($data,$fid=0, $level=0,$fKey="fid")
	{
		if(empty($data)){
			return [];
		}
		static $tree = [];
		foreach ($data as $key => $value) {
				
			//判断当前的父类id是否递归调用传过来的id
			if($value[$fKey] == $fid){
				$value['level'] = $level;
				$tree[] = $value;
				unset($data[$key]);
				self::buildTreeString($data, $value['id'],$level+1, $fKey);
			}
		}
		return $tree;
	}


	/*
	* 文件上传函数
	* @param $files $object
	* #return string url
	*/
	public static function uploadFile($files){
		//参数为空
		if(empty($files)){
			return '';
		}
		// 文件上传目录
		$basePath  = 'uploads/'.date('Y-m-d',time());
		if(!file_exists($basePath)){
			@mkdir($basePath,755,true);  //@错误抑制付  true 循环创建  
		}

		// 文件名字
		$filename = "/".date('YmdHis',time()).rand(0,10000).'.'.$files->extension();

		@move_uploaded_file($files->path(), $basePath.$filename);  // 执行文件上传

		return '/'.$basePath.$filename;
	} 

	/*
	* 获取用户所有权限的主键id
	* 1 根据用户userId查询角色ID
	* 2 根据角色id查询权限id
	*/
	public static function getUserPermissionIds($userId){
		if(!isset($userId) || empty($userId)){
			return [];
		}

		$userRole = new \APP\Model\UserRole(); //
		// $userRole = new UserRole();

		$roles = $userRole->getByUserId($userId); //根据用户id去查询角色id
		if(empty($roles)){
			return [];
		}

		$roleP = new \App\Model\RolePermission();
		// $roleP = new  RolePermission();
		$pids = $roleP->getPermissionByRoleId($roles->role_id);
		return $pids;
	}

	/*
	* 获取当前登录用户的所有权限的url地址
	*/
	public static function getUrlsByUserId($userId){
		$pids = self::getUserPermissionIds($userId); //获取所有权限节点id

		$urls = \App\Model\Permissions::getUrlsByIds($pids);
		return $urls;
	}

	public static function buildGoodsSn($string = 16){
		return "JY".date('YmdHis',$string);
	}
}



