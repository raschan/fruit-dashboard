<?php

class CalculateBraintreeFirstTime 
{
	public function fire($job,$data)
	{
		// we only get the user ID, get the user from it
		$user = User::find($data['userID']);

        BraintreeHelper::firstTime($user);

    	Log::info('Sending "ready" email for user: '.$user->email);
        $email = Mailman::make('emails.connected')
        	->to($user->email)
        	->subject('Your metrics are ready!')
        	->send();

        $user->ready = 'connected';
        $user->save();

        $job->delete();
	}
}

?>