<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Activity;

class ActivityController extends Controller
{
    //活动列表
    public function list(){
    	$activity = new Activity();
    	$assign['activites'] = $this->getDataList($activity);
    	return view('admin.activity.list',$assign);
    }

    public function add(){
    	return view('admin.activity.add');
    }

    public function store(Request $request){
    	$params = $request ->all();
    	$params = $this->delToken($params);

    	if(!empty($params['activity_config'])){
    		$activity_config = [];

    		$arr = explode('|', $params['activity_config']);

    		foreach ($arr as $key => $value) {
    			$arr1 = explode('=>',$value);
    			$activity_config[$arr][0] = $arr1[1];
    		}
    		$params['activity_config'] = serialize($activity_config);
    	}

    	$activity = new Activity();

    	$res = $this->storeDate($activity,$params);

    	if(!$res){
    		return redirect('/admin/activity/list');
    	}

    	return redirect()->back()->with('msg','活动添加失败');
    }

     public function edit(){
    	return view('admin.activity.edit');
    }

    public function doEdit(Request $request){
    	return redirect('/admin/activity/list');
    }

    public function del($id){
    	$activity = new Activity();

    	$this->delData($activity,$id);

    	return redirect('/admin/activity/list');
    }

}
