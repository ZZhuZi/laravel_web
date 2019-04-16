<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Role;
use App\Tools\ToolsAdmin;
use App\Model\AdminUsers;
use App\Model\UserRole;

use Illuminate\Support\Facades\DB;
use Log;
class AdminUsersController extends Controller
{
    //
    public function list(){
    	return view('admin.users.list',['list'=>$list]);
    }
}
