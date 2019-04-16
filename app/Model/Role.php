<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected  $table = 'role';

    public function getRoles(){
    	$a = self::get();
    	// ->toArray();

    	// dd($a);

    	// return $a;

    	return self::get()->toArray();
    }
     /*
	* 角色删除
    */
    public function delRole($id){
    	return self::where('id',$id)->delete();
    }
    /*
	* 获取角色详情
    */
    public function getRoleById($id){
    	return self::where('id',$id)->first();
    }
    /*
	* 添加角色
    */
    public function addRole($data){
    	return self::insert($data);
    }
    /*
	* 角色编辑
    */
    public function updataRole($data,$id){
    	return self::where('id',$id)->updata($data);
    }
  
}
