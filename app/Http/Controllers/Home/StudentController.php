<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Student;

class StudentController extends Controller
{
    //

	public function index()
	{
		$list =  Student::getStudents();
		// dd($list);
		return view('sign.student',['list'=>$list]);
		// return view('sign.stu',['list'=>$list]);
	}

}
