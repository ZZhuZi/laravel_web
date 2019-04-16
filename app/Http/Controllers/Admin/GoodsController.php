<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Brand;
use App\Model\GoodsType;
use App\Model\Goods;
use App\Model\GoodsGallery;
use App\Tools\ToolsAdmin;
use Illuminate\Support\Facades\DB;

class GoodsController extends Controller
{
    //
    public function list(){
        return view('admin/goods/list');
    }
    public function getGoodsData(Request $request){
        $params = $request->all();
        $return = [
            'code' => 2000,
            'msg' => "获取商品列表接口"
        ];
        $goods = new Goods();

        $data = $this->getPageList($goods)->toArray();

        $return['data'] = [
            'list' => $data['data'],
            'current_page' => $data['current_page'],
            'total_page'   => $data['last_page']
        ];
        return json_encode($return);
    }
    public function changeAttr(Request $request)
    {
    	$params = $request->all();
        $return = [
            'code' => 2000,
            'msg' => "修改商品属性成功"
        ];
        $goods = Goods::find($params['id']);

        $res = $this->storeData($goods,$data);

        if(!$res){
            $return = [
                'code' => 4000,
                'msg'  => '修改商品属性失败'
            ];
            return json_encode($return);
        }

    }

     public function add(){
        $type = new GoodsType();

        $assign['type_list'] = $this->getDataList($type,['status' => GoodsType::USE_ABLE]);

        //商品品牌
        $brand = new Brand();
        $assign['brand_list'] = $this->getDataList($brand,['status' => Brand::USE_ABLE]);

        //商品分类
        $category = new Category();
        $assign['cate_list'] = $this->getDataList($category,['status' => Category::USE_ABLE]);
        $assign['cate_list'] = ToolsAdmin::buildTreeString($assign['cate_list'],0,0,'f_id');

        //商品货号
        $assign['goods_sn'] = ToolsAdmin::buildGoodsSn();
        // dd($assign);
        return view('admin.goods.add',$assign);
    }

    public function store(Request $request){
        $params = $request->all();
        
        //上传图片的上限
        if(isset($params['gallery']) && count($params['gallery']) > 5){
            return redirect()->back()->with('msg','已经超过相册上传的上限');
        }
        $params = $this->delToken($params);
        dd($params);
        $gallery = $params['gallery'];
        unset($params['gallery']);

        try {
            DB::beginTransaction();

            $goods = new Goods();
            $goodsId = $this->storeDataGetId($goods,$params);

            $gallery_data = [];
            foreach ($gallery as $key => $value) {
                if (array_key_exists('image_url',$value)) {
                    $value['image_url'] = ToolsAdmin::uploadFile($value['image_url']);
                    $value['goods_id'] = $params['id'];
                    $gallery_data[$key] = $value;
                }
            }

            if(!empty($gallery_data)){
                $goodsGgallery = new GoodsGallery();
                $this->storeDataMany($goodsGallery,$gallery_data);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('商品添加失败',$e->getMessage());
            return redirect()->back()->with('msg','商品添加失败');
        }
      

        return redirect('/admin/goods/list');
    }

    public function del($id){
        $return = [
            'code' => 2000,
            'msg'  =>'删除商品成功'
        ];

        $goods = new Goods();
        $gallery = new GoodsGallery();

        try {
            DB::beginTransaction();
            //删除商品
            $this->delData($gallery,$id,'goods_id');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            \Log::info("商品类型删除失败".$e->getMessage());

            $return = [
                'code' => $e->getCode(),
                'msg'  => $e->getMessage()
            ];
        }


        return json_encode($return);
    }

    public function edit($id){
        $type = new GoodsType();

        $assign['type_list'] = $this->getDataList($type,['status' => GoodsType::USE_ABLE]);

        //商品品牌
        $brand = new Brand();
        $assign['brand_list'] = $this->getDataList($type,['status' => Brand::USE_ABLE]);

        //商品分类
        $brand = new Category();
        $assign['cate_list'] = $this->getDataList($category,['status' => Category::USE_ABLE]);
        $assign['cate_list'] = ToolsAdmin::buildTreeString($assign['cate_list'],0,0,'f_id');

        $goods = new Goods();
        $assign['info'] = $this->getDataInfo($goods,$id);

        return view('admin.goods.edit',$assign);
    }


    public function doEdit(Request $request){
        $params = $request->all();
        
        //上传图片的上限
        if(isset($params['gallery']) && count($params['gallery']) > 5){
            return redirect()->back()->with('msg','已经超过相册上传的上限');
        }
        $params = $this->delToken($params);

        $gallery = $params['gallery'];
        unset($params['gallery']);

        try {
            DB::beginTransaction();

            // $goods = new Goods();
            // $goodsId = $this->storeDataGetId($goods,$params);

            $goods = Goods::find($params['id']);
            $this->storeData($goods,$params);

            $gallery_data = [];
            foreach ($gallery as $key => $value) {
                if (array_key_exists('image_url',$value)) {
                    $value['image_url'] = ToolsAdmin::uploadFile($value['image_url']);
                    $value['goods_id'] = $params['id'];
                    $gallery_data[$key] = $value;
                }
            }

            if(!empty($gallery_data)){
                $goodsGgallery = new GoodsGallery();
                $this->storeDataMany($goodsGallery,$gallery_data);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('商品添加失败',$e->getMessage());
            return redirect()->back()->with('msg','商品添加失败');
        }
      

        return redirect('/admin/goods/list');
    }    
}
