<?php

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
        DB::table('users')->insert([
            'name'     => 'stroebjo',
            'email'    => 'mail@jonathanstroebele.de',
            'password' => bcrypt('secret'),
		]);
    }
}
