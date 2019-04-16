<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class AdminUsers extends Model
{
    //制定数据表的名字
    protected $table = "admin_users";
    //public $timestamps = true;
    /**
     * @desc  通过用户名获取用户[状态正常的]
     * @param  $username 
     * @return array
     */
    public static function getUserByName($username)
    {
    	$userInfo = self::where('username',$username)
    					->where('status',2)
    					->first();
        
    	return $userInfo;
    }

      /**
     * @desc  通过id获取用户
     * @param  $username 
     * @return array
     */
    public static function getUserById($id)
    {
        $userInfo = self::where('id',$id)
                        ->first();
        
        return $userInfo;
    }

      /**
     * @desc  保存用户
     * @param  $username 
     * @return array
     */
    public static function addRecord($data)
    {
        $userInfo = self::insert($data);
        return $userInfo;
    }

      /**
     * @desc  修改用户信息
     * @param  $username 
     * @return array
     */
    public static function updateUser($data,$id)
    {
        $userInfo = self::where('id',$id)->update($data);
        return $userInfo;
    }


      /**
     * @desc  最新id
     * @param  $username 
     * @return array
     */
    public static function getMaxId()
    {
        $userInfo = self::select('id')
                        ->orderBy('id','desc')
                        ->first();
        
        return $userInfo;
    }

      /**
     * @desc  通过用户列表信息
     * @param  $username 
     * @return array
     */
    public static function getList()
    {
        $userInfo = self::paginate(5);
        return $userInfo;
    }

      /**
     * @desc  删除用户
     * @param  $username 
     * @return array
     */
    public static function del($id)
    {
        $userInfo = self::where('id',$id)->delete();
        
        return $userInfo;
    }

}