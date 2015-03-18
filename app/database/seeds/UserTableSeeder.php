<?php

class UserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();
        User::create(array(
            'id'        => '2',
            'email'     => 'rise.hun@gmail.com',
            'password'  => Hash::make('supersecret'),
            'stripe_key'=> 'sk_test_YOhLG7AgROpHWUyr62TlGXmg',
            'ready'     => true
        ));
        User::create(array(
            'id'       => '1',
            'email'    => 'demo@demo.demo',
            'password' => Hash::make('1234')
        ));
    }

}
