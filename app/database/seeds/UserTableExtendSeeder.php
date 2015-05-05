<?php

class UserTableExtendSeeder extends Seeder
{

    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->summaryEmailFrequency = 'daily';

            if($user->isConnected()){
            	$user->ready = 'connected';
            } else {
            	$user->ready = 'notConnected';
            }

            $user->save();
        }
    }
}