<?php

namespace App\Http\Controllers\Study;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Sign;
use Illuminate\Support\Facades\DB;
class SignController extends Controller
{
    //
    public function index(){
  
		$data = DB::select('select * from sign_info');  // update delete insert 
    	$return = ['list'=>$data];
		// dd($return);
    	return	view('study.sign',$return); 
    }

    public function doSign(Request $request){
    	$params = $request->all();
      
        $return = [
            'code' =>2000,
            'msg'  =>'成功',
            'data' =>[]
        ];
        if(!isset($params['user_id']) || empty($params['user_id'])){
            $return = [
                'code' =>4001,
                'msg'  =>'用户id不能为空',
            ];
            return json_encode($return);
        }
        // 获取今天日期
        $today = date('Y-m-d');
        $userId =$params['user_id'];

        // 根据用户id和日期查找
        // $sign1 = Db::query('select * from sign_info where user_id = ? and last_data = ?' ,[$userId,$today]);
        // if(!empty($sign1)){
        //      $return = [
        //         'code' =>4002,
        //         'msg'  =>'已签到'
        //     ];
        //     return json($return);
        // }

         $sign2 =DB::select('select * from sign_info where user_id = ?' ,[$userId]);

        if(!empty($sign2 && $sign2[0]['last_date'] == $today)){
             $return = [
                'code' =>4002, 
                'msg'  =>'已签到'
            ];
            return json_encode($return);;
        }
        if(empty($sign2)){
            Db::query('insert into sign_info(user_id,c_days,total_days,total_score,last_date) values(?,?,?,?,?)',[$userId,1,1,1,today]);
        }else{
            $last_day = date('Y-m-d',time()-3600*24);
            if($last_day == $sign2[0]['last_date']){  //连续签到
                $c_days = $sign2[0]['c_days']+1;
            }else{
                $c_days =1;
            }
            $total_score = $sign2[0]['total_score'] + $c_days;
            $total_days = $sign2[0]['total_days'] +1;
            Db::query("update sign_info set c_days = ?,total_days=?,total_score =?,last_date =?  where user_id = ?",
                [$c_days,$total_days,$total_days,$today,$userId]);
        }


        $return['data']['score'] = $c_days;
        return json_encode($return);;
    }

   
    

   
   


}
