<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Region;
use App\Tools\ToolsAdmin;

class RegionController extends Controller
{
    //列表页面
    public function list($fid = 1){
    	$region = new Region();
    	// dd($region);
    	$assign['region_list'] = $this->getDataList($region,['f_id'=>$fid]);

    	// dd($assign['region_list']);
    	return view('admin.region.list',$assign);
    }

    //添加页面
    public function add(){
    	$region = new Region();
    	$regions = $this->getDataList($region);

    	$assign['region_list'] = ToolsAdmin::buildTreeString($regions,0,0,'f_id');
    	return view('admin.region.add',$assign);
    }

    //执行添加操作
    public function store(Request $request){
    	$params = $request ->all();
    	// dd($params);

    	$params = $this->delToken($params);

    	$region = new Region();
    	$info = $this->getDataInfo($region,$params['f_id']);

    	$params['level'] = $info->level + 1 ;

    	$res = $this->storeData($region,$params);
    	if(!$res){
    		return redirect()->back()->with('msg','添加失败');
    	}

    	return redirect('/admin/region/list/'.$params['f_id']);
    }

    // 执行删除操作
    public function del($id){
    	$region = new Region();
    	$info = $this->getDataInfo($region,$id);
    	// dd($info);
    	$res = $this->delData($region,$id);
    	return redirect('/admin/region/list/'.$info->f_id);
    }


}
