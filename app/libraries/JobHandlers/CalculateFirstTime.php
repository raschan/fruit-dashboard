<?php

class CalculateFirstTime 
{
	public function fire($job,$data)
	{
		// we only get the user ID, get the user from it
		$user = User::find($data['userID']);

        Calculator::calculateMetricsOnConnect($user);

        Auth::login($user);
        Mail::send('emails.connected', array(), function($message)
		{
			$user = Auth::user();
		    $message->to($user->email /*, name of the user */)
		    	->subject("Your metrics are ready!");
		});
		Auth::logout();
        $user->ready = true;
        $user->save();

        $job->delete();
	}
}

?>