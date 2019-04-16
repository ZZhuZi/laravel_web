<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Sign;
use Log;

class SignController extends Controller
{
    //
    public function index(Request $request){
    	           // 对象可以使用->调用
    	// $bqUser = DB::select('select * from sign_info');  // update delete insert 
    	// $bqUser = DB::table('sign_info')->get();
    	// $bqUser = DB::table('sign_info')->where('id',1)->get(); 
    	// $bqUser = DB::table('sign_info')->where('id',1)->first();  
    	// $bqUser = DB::table('sign_info')->select('user_id','total_days')->get(); 
    	$bqUser = DB::table('sign_info')->select('user_id','total_days')->where('c_days','>','1')->get(); 

    	// dd($bqUser);    // dd 打印对象 数组

    	$goods = DB::table('bp_goods')->join('bp_goods_img','bp_goods.id','=','bp_goods_img.goods_id')->get(); 

    	dd($goods);
    	// foreach ($bqUser as $key => $value) {  // 循环
    	// 	echo $value->id;
    	// }

    	
    	// $assign= ['message'=>'hello word'];
    	// return view('sign/sign',$assign);   //return view('sign.sign',['message'=>'hello word']); 

    }

    public function sign(Request $request){
        // Log::info('测试');
        Log::error('测试');


    	           // 对象可以使用->调用
    	$data = DB::select('select * from sign_info');  // update delete insert 
    	// $data = DB::table('sign_info')->get();
    	// dd($data);    // dd 打印对象 数组
    	$return = ['list'=>$data];

    	return view('sign/sign',$return);  

    }

     public function doSign(Request $request){
                   // 对象可以使用->调用
        // $data = DB::select('select * from sign_info where id = ？',[$]);  // update delete insert 
        // // $data = DB::table('sign_info')->get();
        // // dd($data);    // dd 打印对象 数组
        // $return = ['list'=>$data];
        // return view('sign/sign',$return);  

    }


}
