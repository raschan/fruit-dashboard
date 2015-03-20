<?php

class UserTableExtendSeeder extends Seeder
{

    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->summaryEmailFrequency = 'daily';
            $user->save();
        }
    }

}