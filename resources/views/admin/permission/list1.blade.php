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
		                      <td>{{$value->id}}</td>
		                      <td>{{$value->name}}</td>
		                      <td>{{$value->url}}</td>
		                      <td>{{$value->is_menu==1 ? '是' : '否'}}</td>
		                      <td>{{$value->sort}}</td>
		                      <td>  </td>
		                     </tr>
		            @endforeach
            	@endif
	
				</tbody>
			</table>
		</div>
		{{$list ->links()}}
		
	</div>
	
</div>

@endsection