<?php

namespace App\StudyModel;

use Illuminate\Database\Eloquent\Model;

class Guess extends Model
{
    //
    protected $table = "study_guess";

    public function list(){
    	return self::get()->toArray();
    }

    public function guess($id){
    	return self::where('id',$id)->first()->toArray();
    }
}
