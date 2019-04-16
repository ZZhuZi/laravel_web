@extends('sign.base')
@section('title','抢红包页面')
@section('content')
<div id="bonus">
<!-- 	<form action="">
		<input type="input" name="total_amount" >
		<input type="input" name="total_amount" >
		
	</form> -->
	<form class="form-horizontal form-bordered">
            
        <div class="form-group">
            <label class="col-sm-3 control-label">红包金额</label>
            <div class="col-sm-6">
           		<input type="text" placeholder="请选择红包金额" class="form-control" name="total_amount"/>
            </div>
        </div>
        <div class="form-group">
	        <label class="col-sm-3 control-label">红包个数</label>
	        <div class="col-sm-6">
	            <input type="text" placeholder="请选择红包个数" class="form-control" name="total_nums" />
	        </div>
        </div>

	    <div class="row">
			<div class="col-sm-6 col-sm-offset-3">
			  <button class="btn btn-primary btn-danger" v-on:click="addBonus">添加红包</button>&nbsp;
			  <button class="btn btn-default">Cancel</button>
			</div>
		</div>
    </form>  

            
</div>
<script type="text/javascript" src="/js/app.js"></script>

<script type="text/javascript">
var bonus = new Vue({
	el:"#bonus",
	data:{},
	created:function(){
		 
	},
	methods:{
		addBonus:function(){
			var token = $("input[name=_token]").val();
			var total_amount = $("input[name=total_amount]").val();
			var total_nums = $("input[name=total_nums]").val();
			if(total_amount == '' || total_nums == ''){
				alert('参数不能为空');
				return false;
			}
			$.ajax({
				url:'/study/bonud/addBonus',
				type:'post',
				data:{_token:token,total_amount:total_amount,total_nums:total_nums},
				dataType:"json",
				success:function(res){
					alert(res.msg);
				},
				error:function(res){
					alert(res.msg);
				}
			})

		}
	}
})	
</script>