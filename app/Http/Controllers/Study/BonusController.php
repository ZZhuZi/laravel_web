<?php

namespace App\Http\Controllers\Study;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Study\BsBonus;
use App\Study\BsBonusRecord;

use Log;



class BonusController extends Controller
{
 	public function index(){
 		return view('study.index');
 	}
    //请求红包接口
    public function addBonus(Request $request){
        $params = $request->all(); //获取所有的参数
        $return = [
            'code' => 2000,
            'msg'  => '成功',
        ];
        try{
             $data = [
                'total_amount' =>$params['total_amount'],
                'left_amount' =>$params['total_amount'],
                'total_nums' =>$params['total_nums'],
                'left_nums' =>$params['total_nums']
            ];
            BsBonus::addBonus($data);
        }catch(\Exception $e){
            $return = [
                'code' => $e->getCode(),
                'msg'  => $e->getMessage(),
            ];
            return json_encode($return);
        }
        return json_encode($return);
    }

    /*
	* @ 抢红包的业务逻辑
	* 1 。判断红包id和user_id是否传递
	* 2 判断下一个红包是否存在
	* 3 判断红包是否抢完
	* 4 是否值最火一个人抢红包
    */
    public function getBonus(Request $request){
    	// 获取所有的参数
    	$params = $request->all();
    	$return = [
    		'code' => 2000,
    		'msg'  => '成功',
    		'data' =>[]
    	];

    	//用户id
    	if(!isset($params['user_id']) || empty($params['user_id'])){
    		$return = [
	    		'code' => 4001,
	    		'msg'  => '用户未登录'
	    	];
	    	return json_encode($return);
    	}

    	if(!isset($params['bonus_id']) || empty($params['bonus_id'])){
    		$return = [
	    		'code' => 4002,
	    		'msg'  => '选择红包'
	    	];
	    	return json_encode($return);
    	}

    	// 2 判断下一个红包是否存在
    	$bonus = BsBonus::getBonusInfo($params['bonus_id']);
    	// dd($bonus);
    	if(empty($bonus)){
    		$return = [
	    		'code' => 4003,
	    		'msg'  => '红包不存在'
	    	];
	    	return json_encode($return);
    	}
        // 5 判断是否抢过红包
        $record = BsBonusRecord::getRecordById($params['user_id'],$params['bonus_id']);
        // dd($record);
        if($record){
            $return = [
                'code' => 4005,
                'msg'  => '你已经抢过了'
            ];
            return json_encode($return);
        }
        // 3 判断红包是否抢完
    	if($bonus->left_amount <= 0 || $bonus->left_nums <= 0)
    	{
    		$return = [
	    		'code' => 4004,
	    		'msg'  => '红包被抢光了'
	    	];
	    	return json_encode($return);
    	}

        // 4 最后一个红包
    	if($bonus->left_nums == 1){
    		// Log::info('最后红包');
            
    		$getMoney = $bonus->left_amount;

    		$data = [
    			'user_id' =>$params['user_id'],
    			'bonus_id' =>$params['bonus_id'],
    			'money' =>$getMoney,
    			'flag' =>1
    		];
            // 红包记录表添加数据
    		BsBonusRecord::createRecord($data);

    		$data1 = [
    			'left_amount' =>0,
    			'left_nums'   =>0
    		];
    		BsBonus::updateBonusInfo($data1,$params['bonus_id']);

    		$res = BsBonusRecord::getMaxBonus($params['bonus_id']);

    		BsBonusRecord::updateBonusRecord(['flag'=>2],$res->id);

    	}else {
    		// Log::error('1');

    		$min = 0.01;  //最小获取金钱数
    		$max = $bonus->left_amount - ($bonus->left_num - 1)*0.01;
    		$getMoney = rand($min*100,$max*100)/100;  //可获取钱数

    		$data = [
    			'user_id' =>$params['user_id'],
    			'bonus_id' =>$params['bonus_id'],
    			'money' =>$getMoney,
    			'flag' =>1
    		];
    		// dd($data);

    		BsBonusRecord::createRecord($data);

    		$data1 = [
    			'left_amount' =>$bonus->left_amount - $getMoney,
    			'left_nums'   =>$bonus->left_nums - 1
    		];
    		BsBonus::updateBonusInfo($data1,$params['bonus_id']);
    	}

    	return json_encode($return);


    }
}
