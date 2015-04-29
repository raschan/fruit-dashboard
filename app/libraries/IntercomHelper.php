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

	public static function signup($user)
	{
		$intercom = self::createInstance();

		$intercom->createUser(array(
			'name'			=> $user->email,
			'email' 		=> $user->email,
			'created_at'	=> Carbon::parse($user->created_at)->timestamp,
		));
	}

	public static function connect($user, $provider)
	{
		$intercom = self::createInstance();
		
		// general connect
		$intercom->createEvent(array(
			'event_name'	=> 'connected',
			'created_at'	=> time(),
			'email'			=> $user->email,
		));

		// witch provider
		$intercom->createEvent(array(
			'event_name' 	=> 'connected-'.$provider,
			'created_at' 	=> time(),
			'email'			=> $user->email,
		));
	}
}