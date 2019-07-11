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
            'name' => 'sonph',
            'email' => 'sonph@gmail.com',
            'phone' => '+15555550101',
            'password' => bcrypt('admin123'),
        ]);
    }
}
