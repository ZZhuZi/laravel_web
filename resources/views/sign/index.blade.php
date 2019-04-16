<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>签到页面</title>
	 <script type="text/javascript" src="jquery-2.1.1.min.js" ></script>
	<script type="text/javascript" src="Vue.js"></script>
    <script type="text/javascript" src="md5.js"></script>
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
		<tr>
		<!-- 	<td>{{list.total_days}}</td>
			<td>{{list.c_days}}</td>
			<td>{{list.total_score}}</td> -->
		</tr>
	</table>
	
</div>	
<script type="text/javascript">
	// var app = new Vue({
	// 	el : "#app",
	// 	data:{
	// 		show :false,
	// 		score:0,
	// 		list :[]
	// 	},
	// 	created:function(){
	// 		this.userList();
	// 	},
	// 	methods:{
	// 		userList:function(){
	// 			var that = this;
	// 			// var params= window.location.href.split('?')[0];
	// 			// if(params){
	// 			// 	var id = params.split('=')[0];
	// 			// }else{
	// 			// 	var id = 1;
	// 			// }

	// 			$.ajax({
	// 				url:'http://www.tp55.com/back/sign/lists',
	// 				type:"post",
	// 				dataType:'json',
	// 				data:{id:1},
	// 				success:function(res){
	// 					that.list = res.data;
	// 				},
	// 				error:function(res){

	// 				}
	// 			})
	// 		},
	// 		doSign:function(res){
	// 			var that = this;
	// 			$.ajax({
	// 				url:'http://www.tp55.com/back/sign/doSign',
	// 				type:"post",
	// 				dataType:'json',
	// 				data:{user_id:1},
	// 				success:function(res){
	// 					if(res.code == 2000){
	// 						that.score = res.data.score;
	// 						that.show = true;
	// 						that.userList();
	// 					}else{
	// 						alert(res.msg);
	// 						return false;
	// 					}
					
	// 				},
	// 				error:function(res){
	// 					alert(res.msg);
	// 					return false;

	// 				}
	// 			})
	// 		}
	// 	}

	// })
	
</script>
</body>
</html>