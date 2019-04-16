<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BsUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('bs_user')->insert([
        		'username' => '劦榭邪'
        	]);
    }
}
