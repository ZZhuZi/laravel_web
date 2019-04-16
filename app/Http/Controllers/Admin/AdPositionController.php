<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AdPosition;

class AdPositionController extends Controller
{
    //广告位展示页面
    public function list(){
    	$position = new AdPosition();
    	$assign['position'] = $position->getList();
    	return view('/admin/position/list',$assign);
    }

    public function add(){
    	return view('/admin/position/add');
    }

    public function store(Request $request){
    	$params = $request->all();
    	// dd($params);
   
    	// unset($params['_token']);
    	// $position = new AdPosition();
    	// $res =$position ->doAdd($params);

    	$params = $this->delToken($params);
    	$position = new AdPosition();
    	$res = $this->storeData($position,$params);

    	if(!$res){
    		return redirect()->back()->with('msg','广告位添加失败');
    	}

    	return redirect('/admin/position/list');
    }

    public function del($id){
    	$position = new AdPosition();

    	$res =$position->del($id);

    	return redirect('/admin/position/list');
    }

    public function edit($id){
    	$position = new AdPosition();
    	$assign['info'] = $this->getDataInfo($position,$id);
    	return view('/admin/position/edit',$assign);
    }


    public function doEdit(Request $request){
    	$params = $request->all();

    	// unset($params['_token']);
    	// $position = new AdPosition();
    	// $res =$position ->doAdd($params);

    	$params = $this->delToken($params);
    	// $position = new AdPosition();
    	// $positionId = $position->find($params['id']);

    	$position = AdPosition::find($params['id']);

    	// dd($positionId);

    	$res = $this->storeData($position,$params);

    	if(!$res){
    		return redirect()->back()->with('msg','广告位添加失败');
    	}

    	return redirect('/admin/position/list');
    }


}
