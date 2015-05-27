<?php

class ConnectedServicesSeeder extends Seeder
{

    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->connectedServices = 0;
            if ($user->isStripeConnected())
            {
                $user->connectedServices++;
            }

            $user->save();
        }
    }
}
