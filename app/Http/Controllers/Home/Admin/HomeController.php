<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //
    // public function index(){
    // 	return view ('admin.index');
    // }

    public function index(){
    	// $time = time();
    	// $time1 = strtotime('-1 day'); //1552215600
    	// $time2 = date("Y-m-d",$time1);
    	// int_set('max_exection_time','120');
    	 // set_time_limit(120);
    	// return $time2;
 		return view('admin.index');
 	}



 	
	
	
}
