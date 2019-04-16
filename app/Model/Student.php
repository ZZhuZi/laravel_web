<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $table = 'students';
	public $timestamps = false; // 如果没有创建日期可以设置

	public static function getStudents()
	{
		// $students = self::select('id','stu_no','name')->paginate(3);
		$students = self::select()->paginate(3);

		return $students;
	}
	public function updateStudent($id)
	{
		$stu = self::find($id);
		$stu->name = 'xiao';
		$stu ->save();
	}
}
