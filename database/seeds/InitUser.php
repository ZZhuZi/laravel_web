<?php

use Illuminate\Database\Seeder;

class InitUser extends Seeder
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
