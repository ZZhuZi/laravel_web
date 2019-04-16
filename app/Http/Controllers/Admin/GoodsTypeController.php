<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\GoodsType;
use App\Model\GoodsAttr;
use Illuminate\Support\Facades\DB;


class GoodsTypeController extends Controller
{
    //
    protected $type = null;
    protected $attr = null;

    public function __construct(){
    	$this->type = new GoodsType();
    	$this->attr = new GoodsAttr();
    }

      //广告位展示页面
    public function list(){
    	$type = new GoodsType();

    	$assign['list'] = $this->getDataList($type);
    	return view('/admin/goodsType/list',$assign);
    }

    public function add(){
    	return view('/admin/goodsType/add');
    }

    public function store(Request $request){
    	$params = $request->all();
    	
    	$params = $this->delToken($params);
    	$type = new GoodsType();
    	$res = $this->storeData($type,$params);

    	if(!$res){
    		return redirect()->back()->with('msg','添加失败');
    	}

    	return redirect('/admin/goods/type/list');
    }

    public function del($id){
    	try {
    		DB::beginTransaction();
    		//删除商品类型
    		$this->delData($this->type,$id);
    		//删除类型属性
    		$this->dalData($this->attr,$id,'cate_id');

    		\Log::info('商品类型删除成功');
    		DB::commit();
    	} catch (\Exception $e) {
    		DB::rollback();

    		\Log::info("商品类型删除失败".$e->getMessage());
    	}

    	return redirect('/admin/goods/type/list');
    }

    public function edit($id){
    	$ad = new Ad();
    	$assign['info'] = $this->getDataInfo($ad,$id);
    	$assign['position'] = $this->position->getList();

    	return view('/admin/goodsType/edit',$assign);
    }


    public function doEdit(Request $request){
    	$params = $request->all();

    	$params = $this->delToken($params);

    	$type = GoodsType::find($params['id']);

    	$res = $this->storeData($type,$params);

    	if(!$res){
    		return redirect()->back()->with('msg','修改失败');
    	}

    	return redirect('/admin/goods/type/list');
    }

}
