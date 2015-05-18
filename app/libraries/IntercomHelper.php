<?php

use Intercom\IntercomBasicAuthClient;

class IntercomHelper {
	
	private static function createInstance()
	{
		return IntercomBasicAuthClient::factory(array(
            'app_id' 	=> 'nch9zmp2',
            'api_key' 	=> '6bbdd3f52e8cdd508cc98d6fd9c5cdb3fd6f041f'
        ));
	}

	public static function signedup($user)
	{
		$intercom = self::createInstance();

		$intercom->createUser(array(
			'name'			=> $user->email,
			'email' 		=> $user->email,
			'created_at'	=> Carbon::parse($user->created_at)->timestamp,
		));
	}

	public static function connected($user, $provider)
	{
		$intercom = self::createInstance();
		
		// general connect
		$intercom->createEvent(array(
			'event_name'	=> 'connected',
			'created_at'	=> time(),
			'email'			=> $user->email,
		));

		// provider connect
		$intercom->createEvent(array(
			'event_name' 	=> 'connected-'.$provider,
			'created_at' 	=> time(),
			'email'			=> $user->email,
		));
	}

	public static function subscribed($user,$plan)
	{
		$intercom = self::createInstance();

		// plan subscription
		$intercom->createEvent(array(
			'event_name'	=> 'subscribed-to-'.$plan,
			'created_at'	=> time(),
			'email'			=> $user->email,
		));
	}

	public static function cancelled($user)
	{
		$intercom = self::createInstance();

		// subscription cancelled
		$intercom->createEvent(array(
			'event_name'	=> 'cancelled-subscription',
			'created_at'	=> time(),
			'email'			=> $user->email,
		));
	}

	public static function trialEnded($user,$when)
	{
		$intercom = self::createInstance();

		// trial ended
		$intercom->createEvent(array(
			'event_name'	=> 'trial-ended-'.$when,
			'created_at'	=> time(),
			'email'			=> $user->email,
		));
	}

	public static function trialWillEnd($user,$days)
	{
		$intercom = self::createInstance();

		$intercom->createEvent(array(
			'event_name'	=> 'trial-will-end-in-'.$days.'-days',
			'created_at'	=> time(),
			'email'			=> $user->email,
		));
	}
}