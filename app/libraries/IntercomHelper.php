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

		$intercom->createUser(array('email' => $user->email));

		$intercom->createEvent(array(
			'event_name' 	=> 'signed-up',
			'created_at' 	=> time(),
			'email'			=> $user->email,
		));
	}

	public static function connect($user, $provider)
	{
		$intercom = self::createInstance();
		
		$intercom->createEvent(array(
			'event_name' 	=> 'connected-'.$provider,
			'created_at' 	=> time(),
			'email'			=> $user->email,
		));
	}
}