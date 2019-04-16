<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>学生表</title>
	<link rel="stylesheet" href="/css/app.css" type="text/css">
	
</head>
<body>
	<table border="1" cellspacing="0" width="500">
	<thead>
		<th>ID</th>
		<th>学号</th>
		<th>姓名</th>
		<th>课程</th>
		<th>分数</th>
	</thead>
	@foreach($list as $k => $v)
	<tr>
		<td>{{$v->id}}</td>
		<td>{{$v->stu_no}}</td>
		<td>{{$v->name}}</td>
		<td>{{$v->course}}</td>
		<td>{{$v->score}}</td>
	</tr>
	@endforeach
</table>
{{$list->links()}}
</body>
</html>