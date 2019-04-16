@extends('common.admin_base')

@section('title','管理后台-权限列表')

@section('pageHeader')
<div class="pageheader">
	<h2><i class="fa fa-home"></i>权限列表<span>Subtitle goes here ...</span></h2>
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
					<th>权限名字</th>
					<th>URL地址</th>
					<th>是否显示</th>
					<th>排序</th>
					<th>操作</th>
				</tr>
				<tbody>
				
				
				@if(!empty($list))
	           		 @foreach($list as $key=>$value)
		                      <tr>
		                      <td>{{$value['id']}}</td>
		                      <td>{{$value['name']}}</td>
		                      <td>{{$value['url']}}</td>
		                      <td>{{$value['is_menu'] ==1 ? '是' : '否'}}</td>
		                      <td>{{$value['sort']}}</td>

		                      <td>
									<a href="{{ route('admin.permission.edit',['id'=>$role['id'] ])}}">修改</a>
									<a href="{{ route('admin.permission.permission',['id'=>$role['id'] ])}}">权限</a>
									<a href="{{ route('admin.permission.del',['id'=>$role['id'] ])}}">删除</a>
		                      </td>
		                     </tr>
		            @endforeach
            	@endif

            	<td>
						</td>


				</tbody>
			</table>
		</div>
		<!-- <ul class="pagination">
		            上一页
		            <li v-if="page==1" class="disabled"><span>«</span></li>
		            <li v-else v-on:click="prevPage"><span>«</span></li>
		
		            <li v-for="num in total_page" v-on:click="currentPage(num)">
		                <span v-if="page == num" style="color:#ff0000;">{num}</span>
		                <span v-else >{num}</span>
		            </li>
		        
		            <li v-for v-if="page==num" ><a href="" class="active">{num}</a></li> 
		            <li  v-for="num in total_page" v-if="page!=num"><a href="">{num}</a></li> 
		            
		                   
		             下一页
		            <li v-if="page==total_page" class="disabled"><span>»</span></li>
		            <li v-else v-on:click="nextPage"><span>»</span></li>                         
		            
		        </ul> -->
		
	</div>
	
</div>


@endsection