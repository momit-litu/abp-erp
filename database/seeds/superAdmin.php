<?php

use Illuminate\Database\Seeder;

class superAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         \DB::table('users')->insert([
            'first_name' => 'Momit',
			'Last_name' => 'Hasan',
            'email' => 'momit@technolife.ee',
            'password' =>  bcrypt('1234'),
        ]);
		
    }
}


