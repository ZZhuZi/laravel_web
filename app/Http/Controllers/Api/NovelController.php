<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use APP\Model\Novel;
class NovelController extends Controller
{
    //小说书单接口
    public function bookList(Request $request){
        $novel = new Novel();
        $list = $novel->getLists()->toArray();
        
        $return = [
            'code' =>2000,
            'msg'  =>"获取小说书单成功",
            'data' =>[
            	'page' =>$list['current_page'], //当前页
            	'total_page' =>$list['last_page'], //当前页
            	'list' =>$list['data'], //当前页

            ]
        ];
        return json_encode($return);
    }

     //获取小说的阅读榜单
    public function bookRank(Request $request){
        $num = $request->input('num',8);
        $novel = new Novel();
        $list = $novel->getReadRank($num);
        
        $return = [
            'code' =>2000,
            'msg'  =>"获取获取小说的阅读榜单成功",
            'data' =>$list
        ];
        return json_encode($return);
    }
    //获取小说的详情接口
    public function detail($id){
        $novel = new Novel();
        $detail = $novel ->getApiNovelDetail($id);
        $return = [
            'code' =>2000,
            'msg'  =>"获取获取小说的详情接口成功",
            'data' =>$list
        ];
        return json_encode($return);
        
    }
}
