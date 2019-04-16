@extends('common.admin_base')

@section('title','管理后台-用户列表')

@section('pageHeader')
<div class="pageheader">
	<h2><i class="fa fa-home"></i>用户列表<span>Subtitle goes here ...</span></h2>
	<div class="breadcrumb-wrapper"></div>
</div>
@endsection

@section('content')
 {{csrf_field()}}
<div class="row" id="list">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-primary mb30">
				<tr>
					<th>ID</th>
					<th>头像</th>
					<th>用户名</th>
					<th>是否超管</th>
					<th>状态</th>
					<th>操作</th>
				</tr>
				<tbody>
			
					<tr v-for="user in list">
						<td>{user.id} </td>
						<td><img src="{user.image_url}" style="width: 60px;"></td>
						<td>{user.username}</td>	
						<td>{user.username == 1 ? "否" : "是"}</td>	
						<td>{user.status == 1 ? "正常" : "禁用"}</td>	
							
                      	<td><a class="btn btn-sm btn-success" href="{route('admin.user.edit',['id'=>user.id])}">修改</a>&nbsp;&nbsp;
                      	<a class="btn btn-sm btn-danger" href="{'/admin/user/del/'.user.id}">删除</a></td>
                      </tr>
							


					
					</tr>
				</tbody>
			</table>
		</div>
		
	</div>
	
</div>
<script type="text/javascript" src="/RBAC/js/vue.js"></script>
<script type="text/javascript" >
	var list = new Vue({
		el:"#list",
		delimiters:['{','}'],
		data:{
			list:[]
		},
		created:function(){
			this.getUserList();
		},
		methods:{
			//获取权限列表
			getUserList:function(){
				var that = this;
				var token = $("input[name=_token]").val();
				$.ajax({
					url:'/admin/users/getList',
					type:'post',
					data:{_token:token},
					dataType:'json',
					success:function(res){
						if(res.code == 2000){
							that.list = res.data.data;
						}

					},
					error:function(res){
							// alert(res.data);


					}
				})
			},

		}

	})
</script>


@endsection