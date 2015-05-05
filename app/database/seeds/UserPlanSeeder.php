<?php

class UserPlanSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) 
        {
            $user->plan = 'trial';

            $user->save();
        }
    }
}