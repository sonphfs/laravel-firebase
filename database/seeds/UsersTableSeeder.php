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
            'email' => 'sonph-test@gmail.com',
            'phone' => '+15555550101',
            'password' => bcrypt('admin123'),
        ]);
        DB::table('users')->insert([
            'name' => 'sonph01',
            'email' => 'sonph-test01@gmail.com',
            'phone' => '+15555551101',
            'password' => bcrypt('admin123'),
        ]);
    }
}
