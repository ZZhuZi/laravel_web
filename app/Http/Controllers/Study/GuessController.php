<?php

namespace App\Http\Controllers\Study;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

use App\StudyModel\Guess;


class GuessController extends Controller
{

	 // 竞猜添加球队页面
    public function add(){
    	return view('study/guess/add');
    }

    // 竞猜添加球队操作
    public function doAdd(Request $request){
    	$params = $request ->all();
    	$data = [
    		'team_a' => $params['team_a'],
    		'team_b' => $params['team_b'],
    		'end_at' => $params['end_at'],
    	];
        $guess = DB::table('study_guess')->insert($data);
        return redirect('/study/guess/list');
    }

    //竞猜列表页面
    public function list(Request $request){
    	$params = $request->all();
    	// $guess = new Guess();
        // $assign['list'] = $guess->list();
        // $guess = DB::table('study_guess')->get()->toArray();

        $guess = DB::table('study_guess')->get();
       
        // dd($guess);       为对象
        // 将对象转化为数组
        $data = [];
        foreach ($guess as $key => $value) {  
        	// 循环对象重新组装成数组
        	$data[$key] = [
        		"id" => $value->id,
			    "team_a" => $value->team_a,
			    "team_b" => $value->team_b,
			    "end_at" => $value->end_at,
			    "result" => $value->result,
			    "created_at" => $value->created_at,
			    "updated_at" => $value->updated_at
        	];
        }

        $assign['list'] = $data;

        $assign['user_id'] = isset($params['user_id']) ?? 1;
        
        // dd($assign);

        return view('study.guess.list',$assign);
    }

   
    public function guess(Request $request){
    	$params = $request->all();
    	// dd($params);    // id user_id
    	$id = $params['id'];
        // $guess = DB::table('study_guess')->where('id',$id)->first();
        $guess = new Guess();

        $assign['info'] = $guess->guess($id);

        $assign['user_id'] = isset($params['user_id']) ?? 1;
        // dd($assign);

    	return view('study/guess/guess',$assign);
    }

     // 
    public function doGuess(Request $request){
    	$params = $request->all();
        unset($params['_token']);
        // dd($params);
        $user_id = $params['user_id'];
        $team_id = $params['team_id'];
        $g_result = $params['g_result'];

       	$data = DB::table('study_guess_record')->where('user_id',$user_id)->where('team_id',$team_id)->first();
       	// dd($data);
       	if(empty($data)){
       		 DB::table('study_guess_record')->insert($params);
       	}else{
       		 DB::table('study_guess_record')->where('id',$data->id)->update($params);
       	}
        return redirect('/study/guess/list?user_id=1');
    }

     // 竞猜添加球队操作
    public function checkResult(Request $request){
    	$params = $request->all();
        $guess = new Guess();
        $assign['info'] = $guess->guess($params['id']);
        $assign['first'] = DB::table('study_guess_record')->where(['user_id'=>$params['user_id'], 'team_id'=>$params['id']])->first();
        return view('study.guess.result',$assign);
    }
    
}
