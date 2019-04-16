<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sign extends Model
{
    //
    protected $table = 'sign_info';
    public static function list($user_id=1){
    	$data = self::select('user_id','days','total_days','total_score');
    			// ->where('user_id',$user_id)
    			// ->toArray();
    			// dd($data);
    	return $data;
    }
}
