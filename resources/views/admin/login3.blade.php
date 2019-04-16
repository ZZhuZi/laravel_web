<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>登录页面</title>
</head>
<body>

	
</body>
<script type="text/javascript">
var login = new Vue({
	el:'#login',
	delimiters:['{','}'],
	data:{error_show:false,error_msg:''},
	methods:{
		login:function(){
			var username = $['input[name=username]'].val();
			var that = this;
			if(username == '' || password == ''){
				that.error_show = true;
				that.error_msg = '用户名或密码不能为空';
				return false;
			}
			$.ajax({
				url:'admin/doLogin',
				type:'post',
				data:{}
			})
		}
	}
})
</script>
</html>