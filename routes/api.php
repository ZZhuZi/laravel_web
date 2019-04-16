<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/**************************************[小程序首页]*****************************************************8*/
// Route::any('/home/banners','Api\HomeController@banners');

// Route::prefix('api')->group(function(){
// 首页banner图接口
Route::any('/home/banners','Api\HomeController@banners');
// Route::any('home/banners','Api\HomeController@banners');

//首页最新小说的接口
Route::any('/home/news','Api\HomeController@newsList');
// 首页排行最高的小说
Route::any('home/clicks','Api\HomeController@clicksList');

// 分类列表接口
Route::any('category/list','Api\CategoryController@getCategory');
// 分类小说列表接口
Route::any('category/novel','Api\CategoryController@getCategoryNovel');


// 小说搜索接口
Route::any('search/novel','Api\SearchController@getSearchList');

// 小说书单接口
Route::any('book/list','Api\NovelController@bookList');
//小说阅读榜书单接口
Route::any('read/rank','Api\NovelController@bookRank');

//小说详情接口
Route::any('novel/detail/{id}','Api\NovelController@detail');
Route::any('novel/clicks/{id}','Api\NovelController@clicks');
Route::any('novel/read/{id}','Api\NovelController@readNum');

// 小说章节列表接口
Route::any('chapter/list/{novel_id}','Api\ChapterController@chapterList');
Route::any('chapter/info/{id}','Api\ChapterController@chapterInfo');


// });


