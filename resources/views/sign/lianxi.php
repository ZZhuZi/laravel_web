<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>练习</title>
</head>
<body>
<div>
	简述mysql的存储引擎，myisam和innodb的区别
	mysql 的存储引擎有myisam和innodb两种
	myisam 是mysql的默认存储引擎
	myisam是支持全文索引 innodb不支持
	innodb 支持外键  myisam不支持
	innodb支持事物 myisam不支持
	innodb是行级锁结构 myisam是表级锁结构
	在没有where条件的count(*) 条件下 myisam比innodb快
	因为全表扫描myisam快

	常见的设计模式，并说明在什么情景下使用
	单例模式 工厂模式 简单工厂模式 策略模式 
	观察着模式 适配器模式
	单例模式 可以在数据库连接的时候使用
	观察者模式 ，laravel框架的里面的事件机制中使用到了观察者模式

	单例模式 工厂模式 简单工厂模式 策略模式 观察者模式 适配器模式
	单例模式 工厂模式 简单工厂模式 策略模式 观察者模式 适配器模式
	PHP5 权限控制修饰符
	public private protected 
	public 公共的 该数据成员，成员函数是对所有的用户开放的 
	private 私有的 只能自己使用 不对外任何成员使用
	protected 受保护的 只能被自己和和子类使用

	utf8编码 为防止乱码
	1， 数据库和数据表中都用utf8_general_ci 编码
	2， PHP连接mysql 指定数据库编码为utf8 mysql_query('set names utf8');
	3,  php 文件指定头部编码为utf8 header('content-type:text/html;charset=utf-8');
	4,  网站下所有文件编码为utf8
	5， html

</div>
《溯世书》
执笔平宣 泼墨入画一尺经年
酌酒推砚 再写旧人三生眉间
闲拍案 尺方惊醒封陈古意
如今溯世而观 听说书人闭目而谈
指落初叹 斑驳门扉掩映少年
斜斟薄茶半盏 白衣青衫扣门而唤
朱砂一点 只待浮华过尽怎般
前尘依稀可辨 因缘
他说
苍生浮屠过眼 一念须臾之间
梦也痴也入也去也
皆经业火灼炎
修定昆仑之巅 千年一晌倏变
得也失也是也非也
溯世只叙终篇
执笔平宣 泼墨入画一尺经年
酌酒推砚 再写旧人三生眉间
闲拍案 尺方惊醒封陈古意
如今溯世而观 听说书人闭目而谈
浥雨轻寒 蓦然一笑恍若谪仙
临行过往无端 含话唇畔别月天悬
浅入江南 说执妄散尽皆虚幻
誓曰执子庭前 入凡
他说
溯世千年而观 只在俗世流连
幸之命之笑之怨之
流光描画诸般
溯世千年而观 书成一朝荏苒
求之欲之逃之为之
回首皆若飞烟
他说
溯世千年而观 只在俗世流连
幸之命之笑之怨之
流光描画诸般
溯世千年而观 书成一朝荏苒
求之欲之逃之为之
回首皆若飞烟
独白：溯世书溯世而敛 叹过尽千帆后 凡生怎般


@extends('common.base')	
@section('title','学生列表')
@section('content')

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
		<td>{{$v->num}}</td>
		<td>{{$v->name}}</td>
		<td></td>
		<td></td>
	</tr>
	@endforeach
</table>
{{$list->link()}}
@endsection



public function index()
{
	$list =  Student::getStudents();
	return view('student',['list'=>$list]);

}

protected $table = 'students';
public $timestamps = false; // 如果没有创建日期可以设置

public static function getStudents()
{
	$students = self::select('id','stu_no','name')->paginate(3);
	return $students;
}
public function updateStudent($id)
{
	$stu = self::find($id);
	$stu->name = 'xiao';
	$stu ->save();
}
</body>
</html>