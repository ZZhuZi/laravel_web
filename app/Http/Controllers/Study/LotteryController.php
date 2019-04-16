<?php

namespace App\Http\Controllers\Study;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class LotteryController extends Controller
{
    //
    public function index(){
 		return view('study.lottery.index');
 	}

 	 //请求红包接口
    public function doLottery(Request $request){
        $phone = $request->input('phone'); //获取所有的参数

        $start = date('Y-m-d 10:00:00',time());
        $end = date("Y-m-d 20:00:00",time());

        $return = [
            'code' => 2000,
            'msg'  => '成功',
        ];
        // 判断手机号
        if(empty($phone)){
        	$return = [
	            'code' => 4001,
	            'msg'  => '手机号不能为空',
	        ];
	        return json_encode($return);
        }
        // 检测用户信息
        $user = DB::table('study_lottery_user')->where('phone',$phone)->first();
        if(empty($phone)){
        	$return = [
	            'code' => 4002,
	            'msg'  => '用户不存在',
	        ];
	        return json_encode($return);
        }

        // 检测用户的抽奖次数
        $records = DB::table('study_lottery_record')->where('user_id',$user->id)->where('created_at',date('Y-m-d'))->count();
        if($records >= 3){
        	$return = [
	            'code' => 4003,
	            'msg'  => '今日抽奖次数已完毕',
	        ];
	        return json_encode($return);
        }
         // dd($return);

        // 判断活动时间
        if(time() > strtotime($end) || time() < strtotime($start)){
        	$return = [
	            'code' => 4004,
	            'msg'  => '请在活动时间内抽奖',
	        ];
	        return json_encode($return);
        }

        // 执行抽奖操作************************************
        // 获取奖品列表
        $lottery = DB::table('study_lottery')->get();

        //组装数据为数组模式
        $lotterys = $precents = [];

        foreach ($lottery as $key => $value) {
        	// 奖品
        	$lotterys[$value->id ] = [
        		'lottery_name' => $value->lottery_name
        	];
        	// 中奖概率
        	$precents[$value->id ] =  $value->precent;
        }

        // 奖品概率求和
        $preSum = array_sum($precents);

        // 中奖结果
        $result = "";

        // 计算中奖
        foreach ($precents as $key => $value) {
        	// 随机中奖概率.
        	$preCurrent = mt_rand(1 , $preSum);

        	// 如果设置的中奖概率小于随机值 ，中奖le
        	if($value > $preCurrent){
        		$result = $key;
        		break;
        	}else{
        		$preSum = $preSum - $value ;
        	}
        }

        $data = [
        	'user_id' => $user->id,
        	'lottery_id' => $result,
        	'created_at' => date('Y-m-d')
        ];

        DB::table('study_lottery_record')->insert($data);

        $return['msg'] = $lotterys[$result]['lottery_name'];
        // dd($return);
        return json_encode($return);

    }    
}
