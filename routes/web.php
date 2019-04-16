<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('index{id}', function ($id) {
//     return $id;
// });


// Route::get('login','SignController@login');

// 学习类 签到
Route::prefix("study")->group(function(){

	Route::get('student','StudentController@index');

	Route::get('bonus/get','Study\BonusController@getBonus');    // 获取红包路由
	Route::get('bonus/index','Study\BonusController@index');       // 获取红包路由
	Route::get('bonus/add','Study\BonusController@addBonus'); // 获取红包路由

	Route::get('index','Study\SignController@index');    // 签到
	Route::get('doSign','Study\SignController@doSign');  // 签到
	Route::get('sign','Study\SignController@sign');      // 签到

    Route::get('guess/add','Study\GuessController@add');      // 竞猜添加页面
    Route::get('guess/doAdd','Study\GuessController@doAdd');      // 竞猜添加操作页面
    Route::get('guess/list','Study\GuessController@list');      // 竞猜添加页面

    Route::get('guess/guess','Study\GuessController@guess');      // 竞猜添加页面
    Route::get('guess/result','Study\GuessController@checkResult');      // 竞猜结果页面
    Route::get('guess/doGuess','Study\GuessController@doGuess');      // 竞猜竞猜页面

    Route::get('lottery/index','Study\LotteryController@index'); //抽奖页面
    Route::get('lottery/do','Study\LotteryController@doLottery'); //抽奖执行页面



});


#---------------------------------------------------------------------------------
// 后台管理

Route::get('admin/login','Admin\LoginController@index');    //登录页面
Route::get('admin/doLogin','Admin\LoginController@doLogin'); //执行登录
Route::get('admin/loginout','Admin\LoginController@loginout'); //用户退出

Route::get('403',function(){
	return view('403');
});


// 管理后台的路由分组
Route::middleware(['admin_auth','permission_auth'])->prefix('admin')->group(function(){
	
	//中间件 admin_auth permission_auth             

	// Route::get('login',function(){
	// 	return "登录成功";
	// })->middleware('admin_auth');
	Route::any('index','Admin\HomeController@index')->name('admin.index');     //后台首页
    // Route::get('home','Admin\HomeController@home')->name('admin.home');

	##################################[权限相关]#################################################33
	// 权限列表
	Route::any('/permission/list','Admin\PermissionController@list')->name('admin.permission.list');
	// 获取权限的数据
	Route::any('/get/permission/list/{fid?}','Admin\PermissionController@getPermissionList')->name('admin.get.permission.list');
	// 权限添加
	Route::any('/permission/create','Admin\PermissionController@create')->name('admin.permission.create');
	// 执行权限添加
	Route::any('/permission/doCreate','Admin\PermissionController@doCreate')->name('admin.permission.doCreate');
	//删除权限的操作
	Route::any('/permission/del/{id}','Admin\PermissionController@del')->name('admin.permission.del');
    ##################################[权限相关]#################################################33


	##################################[用户相关]#################################################33
	// 用户添加页面
	Route::any('/user/create','Admin\AdminUsersController@create')->name('admin.user.create');
	// 执行用户添加
	Route::any('/user/store','Admin\AdminUsersController@store')->name('admin.user.store');
	// 用户列表页面
	Route::any('/user/list','Admin\AdminUsersController@list')->name('admin.user.list');
	//用户删除操作
	Route::any('/user/del/{id}','Admin\AdminUsersController@delUser')->name('admin.user.del');
	//用户编辑页面
	Route::any('/user/edit/{id}','Admin\AdminUsersController@edit')->name('admin.user.edit');
	//用户执行编辑页面
	Route::post('/user/doEdit','Admin\AdminUsersController@doEdit')->name('admin.user.doEdit');
    ##################################[用户相关]#################################################33


	##################################[角色相关]#################################################33
     //角色列表
     Route::any('/role/list','Admin\RoleController@list')->name('admin.role.list');
     //角色删除
     Route::any('/role/del/{id}','Admin\RoleController@delRole')->name('admin.role.del');
     //角色添加
     Route::any('/role/create','Admin\RoleController@create')->name('admin.role.create');
     //角色执行添加
     Route::any('/role/store','Admin\RoleController@store')->name('admin.role.store');
     //角色编辑
     Route::any('/role/edit/{id}','Admin\RoleController@edit')->name('admin.role.edit');
     //角色执行编辑
     Route::any('/role/doEdit','Admin\RoleController@doEdit')->name('admin.role.doEdit');
     //角色权限编辑
     Route::any('/role/permission/{id}','Admin\RoleController@rolePermission')->name('admin.role.permission');
     //角色权限执行编辑
     Route::post('/role/permission/save','Admin\RoleController@saveRolePermission')->name('admin.role.permission.save');
    ##################################[角色相关]#################################################33

	##################################[小说相关]#################################################33
    //作者列表
    Route::get('/author/list','Admin\AuthorController@list')->name('admin.author.list');
    //作者添加
    Route::get('/author/create','Admin\AuthorController@create')->name('admin.author.create');
     //作者执行添加
    Route::post('/author/store','Admin\AuthorController@store')->name('admin.author.store');
    //作者执行删除
    Route::any('/author/del/{id}','Admin\AuthorController@del')->name('admin.author.del');

     //小说列表
    Route::any('/novel/list','Admin\NovelController@list')->name('admin.novel.list');
    //小说添加
    Route::any('/novel/create','Admin\NovelController@create')->name('admin.novel.create');
     //小说执行添加
    Route::any('/novel/store','Admin\NovelController@store')->name('admin.novel.store');
    //小说执行删除
    Route::any('/novel/del/{id}','Admin\NovelController@del')->name('admin.novel.del');
    //小说编辑
    Route::any('/novel/edit/{id}','Admin\NovelController@edit')->name('admin.novel.edit');
    //小说执行编辑
    Route::any('/novel/doEdit','Admin\NovelController@doEdit')->name('admin.novel.doEdit');

     //小说章节列表
    Route::post('/novel/chapter/list/{novel_id?}','Admin\NovelChapterController@list')->name('admin.novel.chapter.list');
    //小说章节添加
    Route::any('/novel/chapter/create/{novel_id}','Admin\NovelChapterController@create')->name('admin.novel.chapter.create');
     //小说章节执行添加
    Route::post('/novel/chapter/store','Admin\NovelChapterController@store')->name('admin.novel.chapter.store');
    //小说章节执行删除
    Route::any('/novel/chapter/del/{id}','Admin\NovelChapterController@del')->name('admin.novel.chapter.del');
    //小说章节编辑
    Route::any('/novel/chapter/edit/{id}','Admin\NovelChapterController@edit')->name('admin.novel.chapter.edit');
    //小说章节执行编辑
    Route::post('/novel/chapter/doEdit','Admin\NovelChapterController@doEdit')->name('admin.novel.chapter.doEdit');
//+++++++++++++++++++++++++++++++++++++++++小说评论和商品评论相撞+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  //小说评论列表
  Route::post('/novel/comment/list','Admin\NovelCommentController@list')->name('admin.novel.comment.list');
  //小说数据
  Route::any('/novel/comment/data','Admin\NovelCommentController@getComment')->name('admin.novel.comment.data');
  //小说评论审核
  Route::any('/novel/comment/check/{id}','Admin\NovelCommentController@check')->name('admin.novel.comment.check');
  //小说评论执行删除
  Route::any('/novel/comment/del/{id}','Admin\NovelCommentController@del')->name('admin.novel.comment.del');
    ##################################[小说相关]#################################################33



	##################################[练习相关]#################################################33

 	Route::get('/users/create','LianXi\AdminUsersController@create')->name('admin.users.create');
	// 执行用户添加
	Route::get('/users/store','LianXi\AdminUsersController@store')->name('admin.users.store');
	// 用户列表页面
	Route::get('/users/list','LianXi\AdminUsersController@list')->name('admin.users.list');
	Route::get('/users/getList','LianXi\AdminUsersController@getList')->name('admin.users.getList');

	//用户删除操作
	Route::get('/users/del/{id}','LianXi\AdminUsersController@delUser')->name('admin.users.del');
	//用户编辑页面
	Route::get('/users/edit/{id}','LianXi\AdminUsersController@edit')->name('admin.users.edit');
	//用户执行编辑页面
	Route::get('/users/doEdit','LianXi\AdminUsersController@doEdit')->name('admin.users.doEdit');
    ##################################[练习相关]#################################################33



     /*#############################[商品品牌相关]##############################################*/
     Route::get('brand/list','Admin\BrandController@list')->name('admin.brand.list'); //品牌列表页面
     Route::any('brand/data/list','Admin\BrandController@getListData')->name('admin.brand.data.list'); //品牌列表数据

     Route::any('brand/add','Admin\BrandController@add')->name('admin.brand.add'); //品牌添加页面
     Route::any('brand/doAdd','Admin\BrandController@doAdd')->name('admin.brand.doAdd'); //品牌执行添加操作

     Route::any('brand/del/{id}','Admin\BrandController@del')->name('admin.brand.del'); //品牌执行删除操作

     /*#############################[商品品牌相关]################################################*/

    /*#############################[商品分类相关]#############################*/
     //商品分类列表页面
     Route::get('category/list', 'Admin\CategoryController@list')->name('admin.category.list');
     //获取商品接口分类的数据
     Route::get('category/get/data/{fid?}','Admin\CategoryController@getListData')->name('admin.category.get.data');
     //商品添加页面
     Route::get('category/add','Admin\CategoryController@add')->name('admin.category.add');
     //商品执行添加操作
     Route::post('category/doAdd','Admin\CategoryController@doAdd')->name('admin.category.doAdd');
     //商品编辑页面
     Route::get('category/edit/{id}','Admin\CategoryController@edit')->name('admin.category.edit');
     //商品执行编辑操作
     Route::post('category/doEdit','Admin\CategoryController@doEdit')->name('admin.category.doEdit');
     //商品执行删除操作
     Route::get('category/del/{id}','Admin\CategoryController@del')->name('admin.category.del');
     /*#############################[商品分类相关]#############################*/

     /*#############################[文章相关]################################################*/
     // Route::get('')

     /*#############################[文章相关]################################################*/

    /*#############################[广告位相关]################################################*/
    // 广告位列表页面
     Route::any('position/list','Admin\AdPositionController@list')->name('admin.position.list');

     //广告位添加页面
     Route::get('position/add','Admin\AdPositionController@add')->name('admin.position.add');
     // 执行添加广告位操作
     Route::post('position/store','Admin\AdPositionController@store')->name('admin.position.store');
      //广告位修改页面
     Route::get('position/edit/{id}','Admin\AdPositionController@edit')->name('admin.position.edit');
     // 执行修改广告位操作
     Route::post('position/doEdit','Admin\AdPositionController@doEdit')->name('admin.position.doEdit');
      //广告位删除操作
     Route::get('position/del/{id}','Admin\AdPositionController@del')->name('admin.position.del');

     // -----------------------------
     // 广告列表页面
     Route::any('ad/list','Admin\AdController@list')->name('admin.ad.list');
     //广告添加页面
     Route::get('ad/add','Admin\AdController@add')->name('admin.ad.add');
     // 执行添加广告操作
     Route::post('ad/store','Admin\AdController@store')->name('admin.ad.store');
      //广告修改页面
     Route::get('ad/edit/{id}','Admin\AdController@edit')->name('admin.ad.edit');
     // 执行修改广告操作
     Route::post('ad/doEdit','Admin\AdController@doEdit')->name('admin.ad.doEdit');
      //广告删除操作
     Route::get('ad/del/{id}','Admin\AdController@del')->name('admin.ad.del');


     /*#############################[广告位相关]################################################*/

     /*#############################[商品相关]################################################*/
     // ---------------------------------商品类型相关----------------------------------------------
    // 商品类型列表页面
     Route::any('goods/type/list','Admin\GoodsTypeController@list')->name('admin.goods.type.list');
     //商品类型添加页面
     Route::get('goods/type/add','Admin\GoodsTypeController@add')->name('admin.goods.type.add');
     // 执行添加商品类型操作
     Route::post('goods/type/store','Admin\GoodsTypeController@store')->name('admin.goods.type.store');
      //商品类型修改页面
     Route::get('goods/type/edit/{id}','Admin\GoodsTypeController@edit')->name('admin.goods.type.edit');
     // 执行修改商品类型位操作
     Route::post('goods/type/doEdit','Admin\GoodsTypeController@doEdit')->name('admin.goods.type.doEdit');
      //商品类型删除操作
     Route::get('goods/type/del/{id}','Admin\GoodsTypeController@del')->name('admin.goods.type.del');
     // ---------------------------------商品属性相关----------------------------------------------
      // 商品类型列表页面
     Route::any('goods/attr/list/{type_id}','Admin\GoodsAttrController@list')->name('admin.goods.attr.list');
     //商品属性添加页面
     Route::get('goods/attr/add','Admin\GoodsAttrController@add')->name('admin.goods.attr.add');
     // 执行添加商品属性操作
     Route::post('goods/attr/store','Admin\GoodsAttrController@store')->name('admin.goods.attr.store');
      //商品属性修改页面
     Route::get('goods/attr/edit/{id}','Admin\GoodsAttrController@edit')->name('admin.goods.attr.edit');
     // 执行修改商品属性位操作
     Route::post('goods/attr/doEdit','Admin\GoodsAttrController@doEdit')->name('admin.goods.attr.doEdit');
      //商品属性删除操作
     Route::get('goods/attr/del/{id}','Admin\GoodsAttrController@del')->name('admin.goods.attr.del');
     // ---------------------------------商品相关----------------------------------------------
     //商品列表
     Route::any('goods/list','Admin\GoodsController@list')->name('admin.goods.list');
     //商品列表接口数据
     Route::any('goods/data/list','Admin\GoodsController@getGoodsData')->name('admin.goods.data.list');
     //商品添加页面
     Route::get('goods/add','Admin\GoodsController@add')->name('admin.goods.add');
     // 执行添加商品操作
     Route::post('goods/store','Admin\GoodsController@store')->name('admin.goods.store');

      //商品修改属性页面
     Route::get('goods/change/attr','Admin\GoodsController@changeAttr')->name('admin.goods.change.attr');
       //商品修改页面
     Route::get('goods/edit/{id}','Admin\GoodsController@edit')->name('admin.goods.edit');
     // 执行修改商品位操作
     Route::post('goods/doEdit','Admin\GoodsController@doEdit')->name('admin.goods.doEdit');
      //商品删除操作
     Route::get('goods/del/{id}','Admin\GoodsController@del')->name('admin.goods.del');


     // ---------------------------------商品相册相关----------------------------------------------

    //商品相册数据
     Route::post('goods/gallery/list/{goods_id}','Admin\GoodsGalleryController@getGallery')->name('admin.goods.gallery.list');
      //商品相册删除操作
     Route::get('goods/gallery/del/{id}','Admin\GoodsGalleryController@del')->name('admin.goods.gallery.del');

   
     // ---------------------------------商品库存相关----------------------------------------------

     //商品sku和属性页面
     Route::get('goods/sku/edit/{goods_id}','Admin\GoodsSkuController@edit')->name('admin.goods.sku.edit');
      //商品添加操作
     Route::post('goods/sku/save','Admin\GoodsSkuController@doEdit')->name('admin.goods.sku.save');
     //商品sku属性列表接口
     Route::any('goods/sku/attr/{goods_id}','Admin\GoodsSkuController@getSkuAttr')->name('admin.goods.sku.attr');
     //商品属性值
     Route::any('goods/attr/value/{id}','Admin\GoodsSkuController@getAttrValues')->name('admin.goods.attr.value');
     Route::any('goods/sku/list/bind/{goods_id}','Admin\GoodsSkuController@getSkuList')->name('admin.goods.sku.list.bind');

     // ---------------------------------商品评论相关----------------------------------------------
     Route::get('goods/comment/list','Admin\CommentController@list')->name('admin.goods.comment.list');
     Route::get('goods/comment/del/{id}','Admin\CommentController@del')->name('admin.goods.comment.del');

     // ---------------------------------商品导入导出相关----------------------------------------------

     // 商品导入
     Route::get('goods/import','Admin\GoodsController@import')->name('admin.goods.import');
     Route::post('goods/doImport','Admin\GoodsController@doImport')->name('admin.goods.doImport');

     // 商品导出
     Route::any('goods/export','Admin\GoodsController@export')->name('admin.goods.export');

     /*#############################[商品相关]################################################*/


     /*#############################[系统相关]################################################*/
    // ---------------------------------支付管理----------------------------------------------
     //支付管理列表
     Route::any('payment/list','Admin\PaymentController@list')->name('admin.payment.list');
    
     //支付添加页面
     Route::get('payment/add','Admin\PaymentController@add')->name('admin.payment.add');
     // 执行添加支付操作
     Route::post('payment/store','Admin\PaymentController@store')->name('admin.payment.store');

       //支付修改页面
     Route::get('payment/edit/{id}','Admin\PaymentController@edit')->name('admin.payment.edit');
     // 执行修改支付操作
     Route::post('payment/doEdit','Admin\PaymentController@doEdit')->name('admin.payment.doEdit');
      //支付删除操作
     Route::get('payment/del/{id}','Admin\PaymentController@del')->name('admin.payment.del');
      // ---------------------------------配送方式管理----------------------------------------------
     //配送方式管理列表
     Route::any('shipping/list','Admin\ShippingController@list')->name('admin.shipping.list');
    
     //配送方式添加页面
     Route::get('shipping/add','Admin\ShippingController@add')->name('admin.shipping.add');
     // 执行添加配送方式操作
     Route::post('shipping/store','Admin\ShippingController@store')->name('admin.shipping.store');

       //配送方式修改页面
     Route::get('shipping/edit/{id}','Admin\ShippingController@edit')->name('admin.shipping.edit');
     // 执行修改配送方式操作
     Route::post('shipping/doEdit','Admin\ShippingController@doEdit')->name('admin.shipping.doEdit');
      //配送方式删除操作
     Route::get('shipping/del/{id}','Admin\ShippingController@del')->name('admin.shipping.del');
     // ---------------------------------地区管理----------------------------------------------
     //地区管理列表
     Route::any('region/list/{fid?}','Admin\RegionController@list')->name('admin.region.list');
    
     //地区添加页面
     Route::get('region/add','Admin\RegionController@add')->name('admin.region.add');
     // 执行添加地区操作
     Route::post('region/store','Admin\RegionController@store')->name('admin.region.store');

       //地区修改页面
     Route::get('region/edit/{id}','Admin\RegionController@edit')->name('admin.region.edit');
     // 执行修改地区位操作
     Route::post('region/doEdit','Admin\RegionController@doEdit')->name('admin.region.doEdit');
      //地区删除操作
     Route::get('region/del/{id}','Admin\RegionController@del')->name('admin.region.del');
      // ---------------------------------活动管理----------------------------------------------
     //活动列表
     Route::any('activity/list','Admin\ActivityController@list')->name('admin.activity.list');
     Route::get('activity/add','Admin\ActivityController@add')->name('admin.activity.add');
     Route::post('activity/store','Admin\ActivityController@store')->name('admin.activity.store');
     Route::get('activity/edit/{id}','Admin\ActivityController@edit')->name('admin.activity.edit');
     Route::post('activity/doEdit','Admin\ActivityController@doEdit')->name('admin.activity.doEdit');
     Route::get('activity/del/{id}','Admin\ActivityController@del')->name('admin.activity.del');
     /*#############################[系统相关]################################################*/

     /*#############################[会员相关]################################################*/
     // 会员列表
     Route::any('member/list','Admin\MemberController@list')->name('admin.member.list');
     // 详情
     Route::get('member/detail/{id}','Admin\MemberController@detail')->name('admin.member.detail');
     /*#############################[会员相关]################################################*/



     /*#############################[红包相关]################################################*/
       //红包列表
     Route::any('bonus/list','Admin\BonusController@list')->name('admin.bonus.list');
     //红包添加页面
     Route::get('bonus/add','Admin\BonusController@addBonus')->name('admin.bonus.add');
     // 执行添加红包操作
     Route::post('bonus/store','Admin\BonusController@doAddBonus')->name('admin.bonus.store');
       //红包修改页面
     Route::get('bonus/edit/{id}','Admin\BonusController@edit')->name('admin.bonus.edit');
     // 执行修改红包位操作
     Route::post('bonus/doEdit','Admin\BonusController@doEdit')->name('admin.bonus.doEdit');
      //红包删除操作
     Route::get('bonus/del/{id}','Admin\BonusController@del')->name('admin.bonus.del');

     // 发送红包
     Route::get('bonus/send/{bonus_id}','Admin\BonusController@sendBonus')->name('admin.bonus.send');
     Route::post('bonus/doSend','Admin\BonusController@doSendBonus')->name('admin.bonus.doSend');
     Route::get('/user/bonus/list','Admin\BonusController@userBonusList')->name('admin.user.bonus.list');
     /*#############################[红包相关]################################################*/

     /*#############################[批次相关]################################################*/
      //批次列表
     Route::any('batch/list','Admin\BatchController@list')->name('admin.batch.list');
     //批次添加页面
     Route::get('batch/add','Admin\BatchController@add')->name('admin.batch.add');
     // 执行添加批次操作
     Route::post('batch/store','Admin\BatchController@store')->name('admin.batch.store');
     //   //批次修改页面
     // Route::get('batch/edit/{id}','Admin\BatchController@edit')->name('admin.batch.edit');
     // // 执行修改批次位操作
     // Route::post('batch/doEdit','Admin\BatchController@doEdit')->name('admin.batch.doEdit');
     //  //批次删除操作
     // Route::get('batch/del/{id}','Admin\BatchController@del')->name('admin.batch.del');

     // 执行批次
     Route::get('batch/do/{id}','Admin\BatchController@doBatch')->name('admin.batch.do');
     /*#############################[批次相关]################################################*/







});

// Route::middleware('AdminAuth')->prefix('admin')->group(function(){
// 	Route::get('index','Admin\HomeController@index');
// 	Route::get('login','Admin\LoginController@login');

// });

// 测试路由组 中间件
Route::middleware("check_age")->group(function(){
	Route::get('young',function(){
		return "I'm young ";
	});
});




