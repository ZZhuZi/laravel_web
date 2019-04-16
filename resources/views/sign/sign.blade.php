<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>签到页面</title>
	<link rel="stylesheet" href="/css/app.css">
	<script type="text/javascript" src="/js/app.js" ></script>
</head>
<body>
<div id="app">
	<button v-on:click="doSign">今日签到</button><span v-if="show">今日签到获取积分</span>
	<br><br>
	<table cellspacing="0" width="500" border="1">
		<tr>
			<th>总计签到</th>
			<th>最近连续签到</th>
			<th>获取积分</th>
		</tr>
		@foreach($list as $k =>$v)
		<tr>
			<td>{{$v->total_days}}</td>
			<td>{{$v->c_days}}</td>
			<td>{{$v->total_score}}</td>
		</tr>
		@endforeach
	</table>
	
</div>	
<script type="text/javascript">
	var app = new Vue({
		
	})
	
</script>
</body>
</html>

-------------------------------------------------------------
   jy_ad

  			 $table->increments('id');
            $table->integer('position_id')->default(0)->comment('广告位置');
            $table->string('ad_name',60)->default('')->comment('该条广告记录的广告名称');
            $table->string('image_url',150)->default('')->comment('广告图片地址');
            $table->string('ad_link')->default('')->comment('广告链接地址');
            $table->timestamp('start_time')->comment('广告开始时间');
            $table->timestamp('end_time')->comment('广告开始时间');

            $table->integer('clicks')->default(rand(1,100))->comment('点击量');

            $table->enum('status',[1,2])->default('1')->comment('广告是否关闭 1 开启 2 关闭 关闭或不显示');
            // $table->timestamps();
-----------------------------------------------
 Schema::create('jy_ad_position', function (Blueprint $table) {
            $table->increments('id');
            $table->string('position_name',60)->default('')->comment('广告位名称');
            $table->string('position_desc')->default('')->comment('广告位描述');
            // $table->timestamps();
        });


          Schema::create('jy_article', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('admin_id')->default(0)->comment('文章发布者id');
            $table->integer('cate_id')->default(0)->comment('文章分类id');
            $table->string('title',60)->default(0)->comment('文章标题');
            $table->timestamp('publish_at')->comment('文章发布时间');
            $table->integer('clicks')->default(rand(1,100))->comment('点击量');
            $table->enum('status',['1','2','3'])->default('1')->comment('文章状态 1、待审核 2、审核 3、发布');
            $table->string('description',255)->default('')->comment('文章简单描述');
             
            $table->timestamps();
        });