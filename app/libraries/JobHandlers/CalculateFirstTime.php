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
		    $message->to($user->email, 'John Smith')->subject("You're numbers are ready!");
		    Auth::logout();
		});
        
        $job->delete();
	}
}

?>