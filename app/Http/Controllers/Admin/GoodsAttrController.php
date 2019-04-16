<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\GoodsType;
use App\Model\GoodsAttr;
use Illuminate\Support\Facades\DB;

class GoodsAttrController extends Controller
{
    //
       //展示页面
    public function list($typeId){
    	$attr = new GoodsAttr();
    	$where['cate_id'] = $typeId;

    	$assign['attr_list'] = $attr->getList($where);
    	return view('admin.goodsAttr.list',$assign);
    }

    public function add(){
    	$type = new GoodsType();
    	$assign['type_list'] = $this->getDataList($type);

    	return view('admin.goodsAttr.add',$assign);
    }

    public function store(Request $request){
    	$params = $request->all();
    	// dd($params);
    	if(!isset($params['attr_name']) || empty($params['attr_name'])){
    		return redirect()->back()->with('msg','属性名不能为空');
    	}

    	$params = $this->delToken($params);
    	$attr = new GoodsAttr();
    	$res = $this->storeData($attr,$params);

    	if(!$res){
    		return redirect()->back()->with('msg','属性添加失败');
    	}

    	return redirect('/admin/goods/attr/list/'.$params['cate_id']);
    }

    public function del($id){
    	$attr = new GoodsAttr();

    	$data =$this->getDataInfo($attr,$id);

    	$this->delData($attr,$id);

    	return redirect('/admin/goods/attr/list/'.$data->cate_id);
    }

    public function edit($id){
    	$type = new GoodsType();
    	$assign['type_list'] = $this->getDataList($type);
    	$attr = new GoodsAttr();
    	$assign['info'] = $this->getDataInfo($attr,$id);

    	return view('admin.goodsAttr.edit',$assign);
    }


    public function doEdit(Request $request){
    	$params = $request->all();
		if(!isset($params['attr_name']) || empty($params['attr_name'])){
    		return redirect()->back()->with('msg','属性名不能为空');
    	}

    	$params = $this->delToken($params);

    	$attr = GoodsAttr::find($params['id']);

    	$res = $this->storeData($attr,$params);

    	if(!$res){
    		return redirect()->back()->with('msg','商品属性修改失败');
    	}

    	return redirect('/admin/goods/attr/list/'.$params['cate_id']);
    }

}
