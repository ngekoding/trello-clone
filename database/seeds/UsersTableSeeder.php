<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        User::create([
        	'name'     => 'Nur Muhammad',
        	'email'    => 'info@ngekoding.com',
        	'password' => bcrypt('1sampai8')
        ]);
    }
}
